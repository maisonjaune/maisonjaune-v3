<?php

namespace App\Controller\Admin\Node;

use App\Admin\Field\EditorJsField;
use App\Entity\Node\Category;
use App\Entity\Node\Post;
use App\Form\Node\PostType;
use App\Workflow\Place\PostTransition;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use RuntimeException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Workflow\WorkflowInterface;

class PostCrudController extends AbstractCrudController
{
    public function __construct(
        private WorkflowInterface        $postWorkflow,
        private EventDispatcherInterface $eventDispatcher,
        private EntityManagerInterface   $entityManager,
        private AdminUrlGenerator        $adminUrlGenerator,
    )
    {
    }

    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions->remove(Crud::PAGE_INDEX, Action::EDIT);

        foreach ($this->postWorkflow->getDefinition()->getTransitions() as $transition) {
            $enumTransition = PostTransition::from($transition->getName());

            if (in_array($enumTransition, PostTransition::getIndexActions())) {
                $action = Action::new($enumTransition->getActionName(), $enumTransition->getActionLabel(), $enumTransition->getActionIcon())
                    ->linkToCrudAction($enumTransition->getActionName())
                    ->addCssClass($enumTransition->getCssClass() ?? '')
                    ->displayIf(fn(Post $entity) => $this->postWorkflow->can($entity, $enumTransition->value));

                $actions->add(Crud::PAGE_INDEX, $action);
            }
        }

        return $actions;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('title')
            ->add(EntityFilter::new('author'));
    }

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addColumn(12);
        yield TextField::new('title');

        yield FormField::addRow();
        yield FormField::addColumn(8);
        yield FormField::addFieldset();
        yield TextField::new('author.fullname')
            ->hideOnForm();

        yield TextareaField::new('excerpt')
            ->onlyOnForms();

        yield EditorJsField::new('content')
            ->onlyOnForms();

        yield FormField::addColumn(4);
        yield FormField::addFieldset();

        yield BooleanField::new('draft')
            ->hideOnIndex();

        yield BooleanField::new('sticky')
            ->renderAsSwitch(false)
            ->hideOnForm();

        yield BooleanField::new('actif')
            ->renderAsSwitch(false)
            ->hideOnForm();

        yield DateTimeField::new('publishedAt')
            ->hideOnForm();

        yield AssociationField::new('categories')
            ->setFormTypeOption('expanded', true)
            ->setFormTypeOption('choice_label', fn(Category $category) => $category->getName())
            ->onlyOnForms();
    }

    public function write(AdminContext $context): Response
    {
        return $this->runAction($context, PostTransition::WRITE);
    }

    public function review(AdminContext $context): Response
    {
        return $this->runAction($context, PostTransition::REVIEW);
    }

    public function decorate(AdminContext $context): Response
    {
        return $this->runAction($context, PostTransition::DECORATE);
    }

    public function publish(AdminContext $context): Response
    {
        return $this->runAction($context, PostTransition::PUBLISH);
    }

    public function unpublish(AdminContext $context): Response
    {
        return $this->runAction($context, PostTransition::UNPUBLISH);
    }

    private function runAction(AdminContext $context, PostTransition $transition): Response
    {
        $entity = $context->getEntity()->getInstance();

        if (!$entity instanceof Post) {
            throw new RuntimeException(sprintf("Entity must be instance of %s", Post::class));
        }

        if (!$this->postWorkflow->can($entity, $transition->value)) {
            throw $this->createAccessDeniedException(sprintf("Transition %s is not possible for post %s", $transition->value, $entity->getId()));
        }

        $form = $this->createForm(PostType::class, $entity, [
            'transition' => $transition->value
        ]);

        $form->handleRequest($context->getRequest());

        if ($form->isSubmitted() && $form->isValid()) {

            $transition = PostTransition::from($context->getRequest()->request->get('transition', $transition->value));

            $this->postWorkflow->apply($entity, $transition->value);

            $this->entityManager->persist($entity);
            $this->entityManager->flush();

            $url = $context->getReferrer() ?? $this->adminUrlGenerator
                ->setAction(Action::INDEX)
                ->generateUrl();

            return $this->redirect($url);
        }

        $event = new AfterCrudActionEvent($context, KeyValueStore::new());
        $this->eventDispatcher->dispatch($event);

        return $this->render(sprintf('@EasyAdmin/node/post/%s.html.twig', $transition->getAdminView()), [
            'edit_form' => $form,
            'entity' => $context->getEntity(),
        ]);
    }
}

<?php

namespace App\Form\Node;

use App\Entity\Node\Category;
use App\Entity\Node\Post;
use App\Form\EditorJsType;
use App\Workflow\Place\PostTransition;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Workflow\WorkflowInterface;

class PostType extends AbstractType
{
    public function __construct(
        private WorkflowInterface $postWorkflow,
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $transition = $options['transition'];

        if ($transition === PostTransition::WRITE->getActionName()) {
            $builder
                ->add('title')
                ->add('slug')
                ->add('excerpt')
                ->add('content', EditorJsType::class)
                ->add('categories', EntityType::class, [
                    'class' => Category::class,
                    'choice_label' => 'name',
                    'multiple' => true,
                    'expanded' => true,
                ]);
        }

        if ($transition === PostTransition::REVIEW->getActionName()) {
            $builder
                ->add('title')
                ->add('slug')
                ->add('excerpt')
                ->add('content', EditorJsType::class);
        }

        if ($transition === PostTransition::PUBLISH->getActionName()) {
            $builder
                ->add('sticky')
                ->add('commentable')
                ->add('publishedAt');
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);

        $resolver->setRequired('transition');
        $resolver->setAllowedTypes('transition', 'string');
        $resolver->setAllowedValues('transition', $this->getAllowedTransitions());
    }

    /**
     * @return array<string>
     */
    private function getAllowedTransitions(): array
    {
        return array_map(fn($transition) => $transition->getName(), $this->postWorkflow->getDefinition()->getTransitions());
    }
}

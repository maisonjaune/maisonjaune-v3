<?php

namespace App\Controller\Admin\Node;

use App\Admin\Field\EditorJsField;
use App\Entity\Node\Category;
use App\Entity\Node\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('title')
            ->add(EntityFilter::new('author'));
    }

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addColumn(8);
        yield FormField::addFieldset();

        yield TextField::new('title');
        yield TextField::new('author.fullname')
            ->hideOnForm();

        yield TextareaField::new('excerpt')
            ->onlyOnForms();

        yield EditorJsField::new('content')
            ->onlyOnForms();

        yield FormField::addColumn(4);
        yield FormField::addFieldset();

        yield BooleanField::new('sticky');
        yield BooleanField::new('actif');

        yield DateTimeField::new('publishedAt');

        yield AssociationField::new('categories')
            ->setFormTypeOption('expanded', true)
            ->setFormTypeOption('choice_label', fn(Category $category) => $category->getName())
            ->onlyOnForms();
    }
}

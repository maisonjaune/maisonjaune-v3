<?php

namespace App\Controller\Admin\Node;

use App\Entity\Node\Category;
use App\Entity\Node\Page;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class PageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Page::class;
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

        yield TextEditorField::new('content')
            ->onlyOnForms();

        yield FormField::addColumn(4);
        yield FormField::addFieldset();

        yield BooleanField::new('sticky');
        yield BooleanField::new('actif');

        yield DateTimeField::new('publishedAt');
    }
}

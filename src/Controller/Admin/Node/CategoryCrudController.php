<?php

namespace App\Controller\Admin\Node;

use App\Entity\Node\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name');
    }

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addColumn(12);
        yield FormField::addFieldset();

        yield TextField::new('name');
        yield TextField::new('shortname');
    }
}

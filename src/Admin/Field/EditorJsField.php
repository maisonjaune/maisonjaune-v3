<?php

namespace App\Admin\Field;

use App\Form\EditorJsType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

class EditorJsField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null)
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(EditorJsType::class)
            ->addWebpackEncoreEntries('admin-field-editorjs')
            ->addFormTheme('@EasyAdmin/form/editorjs.html.twig');
    }
}
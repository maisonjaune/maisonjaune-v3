<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class EditorJsType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['attr']['data-editor-content'] = true;
    }

    public function getBlockPrefix(): string
    {
        return 'ea_text_editor_js';
    }

    public function getParent()
    {
        return TextareaType::class;
    }
}

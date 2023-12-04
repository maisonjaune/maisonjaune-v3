<?php

namespace App\Form;

use App\Service\Asset\AssetManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class EditorJsType extends AbstractType
{
    public function __construct(

        private AssetManagerInterface $assetManager,
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->assetManager->addWebpackEncoreEntries('formtype-editorjs');
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['attr']['data-editor-content'] = true;
    }

    public function getBlockPrefix(): string
    {
        return 'editor_js';
    }

    public function getParent()
    {
        return TextareaType::class;
    }
}

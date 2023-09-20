<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Tytuł',
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
                'label' => 'Opis',
            ])
            ->add('start', DateTimeType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('stop', DateTimeType::class, [
                'widget' => 'single_text',
                'required' => false,
            ]);

        $builder->add('tags', CollectionType::class, [
            'entry_type' => TagType::class,
            'label' => false,
            'allow_add' => true,
            'by_reference' => false,
            'allow_delete' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}

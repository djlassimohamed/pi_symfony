<?php

namespace App\Form;

use App\Entity\Programmenutrition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProgrammenutritionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('repas1', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('repas2', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('repas3', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('repas4', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('repas5', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('duree')
            ->add('jourrepot', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Programmenutrition::class,
        ]);
    }
}

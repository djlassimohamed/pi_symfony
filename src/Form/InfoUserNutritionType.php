<?php

namespace App\Form;

use App\Entity\InfoUserNutrition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InfoUserNutritionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ojectif', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('blessure', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('mangezpas', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('supplementali', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('probleme', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('age')
            ->add('taille')
            ->add('poids')
            ->add('sexe', ChoiceType::class, [
                'choices' => [
                    'Masculin' => 'Masculin',
                    'Feminin' => 'Feminin',
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InfoUserNutrition::class,
        ]);
    }
}

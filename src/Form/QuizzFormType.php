<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizzFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('0', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary w-100 m-1'
                ]
            ])
            ->add('1', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary w-100 m-1'
                ]
            ])
            ->add('2', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary w-100 m-1'
                ]
            ])
            ->add('3', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary w-100 m-1'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

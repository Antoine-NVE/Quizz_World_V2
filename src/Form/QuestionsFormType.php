<?php

namespace App\Form;

use App\Entity\Questions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('question')
            ->add('anecdote', options: [
                'label' => 'Anecdote (optionnelle)'
            ])
            ->add('p1', TextType::class, [
                'mapped' => false,
                'label' => 'Proposition 1'
            ])
            ->add('p2', TextType::class, [
                'mapped' => false,
                'label' => 'Proposition 2'
            ])
            ->add('p3', TextType::class, [
                'mapped' => false,
                'label' => 'Proposition 3'
            ])
            ->add('p4', TextType::class, [
                'mapped' => false,
                'label' => 'Proposition 4'
            ])
            ->add('answer', ChoiceType::class, [
                'choices' => [
                    'Proposition 1' => 'a1',
                    'Proposition 2' => 'a2',
                    'Proposition 3' => 'a3',
                    'Proposition 4' => 'a4'
                ],
                'label' => 'Bonne réponse',
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Questions::class,
        ]);
    }
}

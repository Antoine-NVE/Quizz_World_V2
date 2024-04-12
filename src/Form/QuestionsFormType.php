<?php

namespace App\Form;

use App\Entity\Questions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class QuestionsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('question', options: [
                'required' => false,
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 8,
                        'max' => 128
                    ])
                ]
            ])
            ->add('p1', TextType::class, [
                'required' => false,
                'mapped' => false,
                'label' => 'Proposition 1',
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'max' => 64
                    ])
                ]
            ])
            ->add('p2', TextType::class, [
                'required' => false,
                'mapped' => false,
                'label' => 'Proposition 2',
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'max' => 64
                    ])
                ]
            ])
            ->add('p3', TextType::class, [
                'required' => false,
                'mapped' => false,
                'label' => 'Proposition 3',
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'max' => 64
                    ])
                ]
            ])
            ->add('p4', TextType::class, [
                'required' => false,
                'mapped' => false,
                'label' => 'Proposition 4',
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'max' => 64
                    ])
                ]
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
                'mapped' => false,
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('anecdote', options: [
                'required' => false,
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'max' => 128
                    ])
                ],
                'help' => 'Optionnelle, celle-ci sera affichée lorsque l\'utilisateur aura sélectionné une réponse.'
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

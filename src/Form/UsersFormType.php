<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UsersFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', options: [
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner votre pseudo.'
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre pseudo doit faire au minimum {{ limit }} caractères.',
                        'max' => 20,
                        'maxMessage' => 'Votre pseudo doit faire au maximum {{ limit }} caractères.'
                    ]),
                ]
            ])
            ->add('email', options: [
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner votre email.'
                    ]),
                    new Email([
                        'message' => 'Email invalide.'
                    ])
                ]
            ])
            ->add('role', options: [
                'mapped' => false,
                'disabled' => true,
                'label' => 'Rôle'
            ])
            ->add('createdAt', null, [
                'widget' => 'single_text',
                'disabled' => true,
                'label' => 'Créé le'
            ])
            ->add('isVerified', options: [
                'label' => 'Vérifié'
            ])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}

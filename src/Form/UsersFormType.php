<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo')
            ->add('email')
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

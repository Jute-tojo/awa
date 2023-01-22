<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')->add('prenom', TextType::class, [
            'label' => "Prénom"
        ])->add('username', TextType::class, [
            'label' => 'Pseudo'
        ])
        ->add('roles', ChoiceType::class, [
            'choices' => [
                'Rôle Utilisateur' => 'ROLE_USER',
                'Rôle Editeur' => 'ROLE_EDITOR',
                'Rôle Administrateur' => 'ROLE_ADMIN'
            ]
        ])
        ->add('adresse')
        ->add('telephone')
        ->add('email', EmailType::class)
        ->add('password', PasswordType::class, [
            'label' => "Mot de passe",
            'mapped' => false
        ])
        ->add('confirm_password', PasswordType::class, [
            'label' => "Confirmé mot de passe",
            'constraints' => [
                new Assert\EqualTo('password')
            ],
            'mapped' => false
        ])
        ->add('Enregistrer', SubmitType::class, [
            'label' => 'Enregistrer',
            'attr' => ['class' => 'btn btn-success pull-right mt-2 mb-3']
        ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}

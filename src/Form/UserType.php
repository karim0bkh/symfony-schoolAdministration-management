<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('password')
            ->add('fullname')
            ->add('matricule')
            ->add('filliere',ChoiceType::class, [
                'choices'  => [
                    'Info' => 'info',
                    'Administration' => 'administration',
                    'EA' => 'ea',
                    'EM' => 'em',
                    'Prepa' => 'prepa',
                    'Bio' => 'bio'
                
                ]])
            ->add('type',ChoiceType::class, [
                'choices'  => [
                    'Enseignants' => 'prof',
                    'Etudiants' => 'etudiant',
                    'Admin' => 'admin'
                
                ]
            
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

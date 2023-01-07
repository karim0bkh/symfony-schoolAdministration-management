<?php

namespace App\Form;

use App\Entity\Document;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('filliere',ChoiceType::class, [
                'choices'  => [
                    'Info' => 'info',
                    'Bio' => 'bio',
                    'EA' => 'ea',
                    'EM' => 'em',
                    'Prepa' => 'prepa'
                
                ]])
            ->add('categorie',ChoiceType::class, [
                'choices'  => [
                    'Examens' => 'Examens',
                    'Questions' => 'Questions',
                    'Rapport' => 'Rapport',
                    'Revision' => 'Revision'
                
                ]])
            ->add('description')
            ->add('keyword1')
            ->add('keyword2')
            ->add('keyword3')
            ->add('keyword4')
            ->add('keyword5')
            ->add('file',FileType::class,[
                'data_class'   =>  null,
                'required'   =>  false
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Document::class,
        ]);
    }
}

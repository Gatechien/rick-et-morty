<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchPersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mots', SearchType::class, [
                'label' => 'Search',
                'attr' => [
                    'class' => 'form-control',
                    'class' => 'me-sm-2',
                    'placeholder' => 'Search',
                ],
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Search',
                'attr' => [
                    'class' => 'btn btn-outline-primary my-2 my-sm-0',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\RequestForAL;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AddVacationFormType extends AbstractType {

    public function __construct() {
       
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start', DateType::class, [
                'label' => 'Start Date',
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('end', DateType::class, [
                'label' => 'End Date',
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ])  
            ->add('reason', TextType::class, [
                'label' => 'Reason',
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ]) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RequestForAL::class,
        ]);
    }

}
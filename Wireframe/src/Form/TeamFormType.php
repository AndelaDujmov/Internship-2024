<?php

namespace App\Form;

use App\Entity\Team;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class TeamFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'placeholder' => 'Team Name',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a team name',
                    ]),
                ],
            ])
            ->add('number', IntegerType::class, [
                'label' => 'Number of Members',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter the number of members',
                    ]),
                    new Range([
                        'min' => 1,
                        'minMessage' => 'The number of members must be at least 1',
                    ]),
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Create',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\User;
use App\Enum\Role;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class TeamFormType extends AbstractType
{
    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Team Name',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a team name',
                    ]),
                ],
            ])
            ->add('numberOfMembers', IntegerType::class, [
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
            ->addEventListener(FormEvents::PRE_SUBMIT, function (PreSubmitEvent $event): void {
                $user = $event->getData();
                $form = $event->getForm();
          
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
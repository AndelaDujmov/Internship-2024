<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\TeamLeaders;
use App\Entity\User;
use App\Enum\Role;
use App\Repository\TeamLeadersRepository;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use App\Service\TeamService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class TeamLeadersFormType extends AbstractType
{
    private $userRepository;
    private $teamRepository;
    private $requestStack;

    public function __construct(UserRepository $userRepository, TeamLeadersRepository $teamLeadersRepository, RequestStack $requestStack) {
        $this->userRepository = $userRepository;
        $this->teamRepository = $teamLeadersRepository;
        $this->requestStack = $requestStack;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $users = $this->userRepository->getUsersByRole(Role::TEAMLEADER->value) ?: throw new \Exception("Not found");
        $builder
            ->add('teamLead', ChoiceType::class, [
                'label' => 'Team Leader',
                'choices' => $users,
                'choice_label' => function (?User $user){
                    return $user ? $user->getUsername() : null;
                },
                'choice_value' => function (?User $user){
                    return $user ? $user->getId() : null;
                },
            ])
            ->add('projectLeader', ChoiceType::class, [
                'label' => 'Project Leader',
                'choices' => $this->userRepository->getUsersByRole(Role::PROJECTLEADER->value),
                'choice_label' => function (?User $user){
                    return $user ? $user->getUsername() : null;
                },
                'choice_value' => function (?User $user){
                    return $user ? $user->getId(): null;
                },
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, function (PreSubmitEvent $event) {
                $form = $event->getForm();
                $data = $event->getData();
                $request = $this->requestStack->getCurrentRequest();
                
                if ($request) {
                    $teamId = $request->query->get('teamId');
                    
                    if ($teamId && $form->getData() instanceof TeamLeaders) {
                        $teamLeaders = $form->getData();
                        $team = $this->teamRepository->find($teamId);
                        
                        if ($team) {
                            $teamLeaders->setTeam($team);
                        }
                    }
                }
            });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TeamLeaders::class,
        ]);
    }
}
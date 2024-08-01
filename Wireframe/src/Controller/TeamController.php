<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamFormType;
use App\Service\TeamService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TeamController extends AbstractController
{

    private $teamService;

    public function __construct(TeamService $teamService) {
        $this->teamService = $teamService;
    }

    #[Route('/team', name: 'app_team')]
    public function index(): Response
    {
       try{
            $all = TeamService::getAll();

            $teamLeaders = [];

            foreach ($all as $team) {
                $teamLeaders[] = $this->teamService->showLeaders($team->getId());
            }

            return $this->render('team/index.html.twig', [
                'controller_name' => 'TeamController',
                'teams' => $all,
                'teamsLeaders' => $teamLeaders,
            ]);
       }catch (Exception $e){
            return $this->render('error/error.html.twig', [
                'controller_name' => 'TeamController',
                'error' => $e->getMessage(),
            ]);
        }
    }

    #[Route('/team/create', name:'app_team_create')]
    public function createTeam(Request $request): Response {
        $team = new Team();
        $form = $this->createForm(TeamFormType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $name = $data->getName();
            $memberNumber = $data->getNumberOfMembers();

            try {
                $this->teamService->create($name, $memberNumber);
                return $this->redirectToRoute('app_team');
            } catch (\Exception $e) {
                return $this->render('error/error.html.twig', [
                    'controller_name' => 'TeamController',
                    'error' => $e->getMessage(),
                ]);
            }
    }

        return $this->render('team/create.html.twig', [
            'controller_name' => 'TeamController',
            'form' => $form->createView(),
        ]);
}

    #[Route('/team/create', name:'app_team_create_post', methods: ['POST'])]
    public function createTeamPost(Request $request): Response {
        $form = $this->createForm(TeamFormType::class, new Team());

        if ($form->isSubmitted()) {
            $data = $form->getData();
            $name = $data->getName();
            $memberNumber = $data->getNumberOfMembers();

            try {
                $this->teamService->create($name, $memberNumber);
                return $this->redirectToRoute('app_team');
            } catch (\Exception $e) {
                return $this->render('error/error.html.twig', [
                    'controller_name' => 'TeamController',
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return $this->render('team/create.html.twig', [
            'controller_name' => 'TeamController',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/team/members/{teamId}', name: 'app_team_members')]
    public function showMembersInTeam(string $teamId){
        try{
            $members = $this->teamService->showAllTeammates($teamId);
            $team = $this->teamService->getById($teamId);
            $teamLeaders[] = $this->teamService->showLeaders($team->getId());

            return $this->render('team/members.html.twig', [
                'controller_name' => 'TeamController',
                'members' => $members,
                'team' => $team,
                'leaders' => $teamLeaders,
               
            ]);
        }catch (Exception $e){
            return $this->render('error/error.html.twig', [
                'controller_name' => 'TeamController',
                'error' => $e->getMessage(),
            ]);
        }
    }

    #[Route('/team/member/{memberId}', name: 'app_team_member')]
    public function userInfo(string $memberId) : Response {
        try{
            $user = $this->teamService->showWorkerData($memberId);

             return $this->render('team/userInfo.html.twig', [
                'controller_name' => 'TeamController',
                'user' => $user,
            ]);
        }catch(Exception $e){
            return $this->render('error/error.html.twig', [
                'controller_name' => 'TeamController',
                'error' => $e->getMessage(),
            ]);
        }
    }

    #[Route('/team/remove', name: 'app_team_remove')]
    public function removeMemberFromTeam(Request $request) : RedirectResponse {
        $teamId = $request->get('');
        $memberId = $request->get('');

        $this->teamService->removeWorkerFromTeam($teamId, $memberId);

        return $this->redirectToRoute('app_team');
    }

    #[Route('/team/delete', name: 'app_team_delete', methods: ['GET'])]
    public function deleteTeam(Request $request) : Response {
       try{
            $teamId = $request->get('teamId');

            TeamService::deleteTeam($teamId);
            
            usleep(1200);

            return $this->redirectToRoute('app_team');
       }catch (Exception $e){
            return $this->render('error/error.html.twig', [
                'controller_name' => 'TeamController',
                'error' => $e->getMessage(),
            ]);
       }
    }
}

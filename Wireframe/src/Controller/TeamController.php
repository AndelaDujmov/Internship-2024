<?php

namespace App\Controller;

use App\Service\TeamService;
use App\Service\UserManagementService;
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

       }
    }

    #[Route('/team/{teamId}', name: 'app_team_members')]
    public function showMembersInTeam(string $teamId){
        try{
            $members = $this->teamService->showAllTeammates($teamId);

            return $this->render('team/members.html.twig', [
                'controller_name' => 'TeamController',
                'members' => $members,
               
            ]);
        }catch (Exception $e){

        }
    }

    public function deleteTeam(Request $request) : RedirectResponse{
       try{
            $teamId = $request->get('teamId');

            $this->teamService->deleteTeam($teamId);

            return $this->redirectToRoute('/team');
       }catch (Exception $e){
        
       }
    }

    #[Route('/team/remove', name: 'app_team_remove')]
    public function removeMemberFromTeam(Request $request) : RedirectResponse{
        $teamId = $request->get('');
        $memberId = $request->get('');

        $this->teamService->removeWorkerFromTeam($teamId, $memberId);

        return $this->redirectToRoute('/team');
    }
}

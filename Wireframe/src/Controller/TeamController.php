<?php

namespace App\Controller;

use App\Service\TeamService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    }

    public function showMembersInTeam(string $teamId){
        $members = $this->teamService->showAllTeammates($teamId);

        return $this->render('team/members.html.twig', [
            'controller_name' => 'TeamController',
            'members' => $members,
           
        ]);
    }
}

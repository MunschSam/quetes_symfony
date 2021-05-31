<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Category;
use App\Entity\Episode;

class ProgramController extends AbstractController
{




 
/**
 * Getting a program by id
 *
 * @Route("program/show/{id<^[0-9]+$>}", name="program_show")
 * @return Response
 */


public function show(Program $id):Response
{
    $program = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findOneBy(['id' => $id]);

        $seasons = $program->getSeasons();

    if (!$program) {
        throw $this->createNotFoundException(
            'No program with id : '.$id.' found in program\'s table.'
        );
    }
    return $this->render('program/show.html.twig', [
        'program' => $program, 'seasons' => $seasons

    ]);
    
}



/**
 * Getting a episode by season and program
 *
 * @Route(" /program/show/{programId}/seasons/{seasonId}", name="season_show")
 * @return Response
 */
public function showSeason(Program $programId, Season $seasonId)
{
    $program = $this->getDoctrine()
         ->getRepository(Program::class)
         ->findOneBy(['id' => $programId]);

     $season = $this->getDoctrine()
         ->getRepository(Season::class)
         ->findOneBy(['id' => $seasonId]);
    
    /*

    $episodes = $program->getSeasons()->getEpisodes();
*/
    return $this->render('program/season_show.html.twig', [
        'program' => $program,
        'season' => $season,
        'episodes' => $season->getEpisodes(),
    ]);
}

/**
 * 
 * @Route("/programs", name="program_index")
 * @return Response A response instance
 */
public function index(): Response
{
    $programs = $this->getDoctrine()
             ->getRepository(Program::class)
             ->findAll();

         return $this->render(
             'program/index.html.twig',
             ['programs' => $programs]
         );
    }

    
}


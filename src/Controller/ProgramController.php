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
use App\Form\ProgramType;
use Symfony\Component\HttpFoundation\Request;

class ProgramController extends AbstractController
{

/**
     * The controller for the program add form
     * Display the form or deal with it
     *
     * @Route("/programs/new", name="program_new")
     */
    public function new(Request $request) : Response
    {
        // Create a new Program Object
        $program = new Program();
        // Create the associated Form
        $form = $this->createForm(ProgramType::class, $program);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        
            // Deal with the submitted data
            // For example : persiste & flush the entity
            // And redirect to a route that display the result
        
        if ($form->isSubmitted()&& $form->isValid()) {
            // Deal with the submitted data
            // Get the Entity Manager
            $entityManager = $this->getDoctrine()->getManager();
            // Persist Category Object
            $entityManager->persist($program);
            // Flush the persisted object
            $entityManager->flush();
            // Finally redirect to categories list
            return $this->redirectToRoute('program_index');
        }
        // Render the form
        return $this->render('program/new.html.twig', ["form" => $form->createView()]);
    }

 
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


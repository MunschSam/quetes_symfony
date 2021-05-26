<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;

class ProgramController extends AbstractController
{


 /**
  * @Route("/programs/{id}", requirements={"id"="\d+"}, name="program_show")
  */
public function show(int $id): Response
{
    return $this->render('program/show.html.twig', ['id' => $id]);
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

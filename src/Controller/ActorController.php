<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Actor;


/**
 * @Route("/actor", name="actor_")
 */
class ActorController extends AbstractController
{
    /**
     * @Route("/{id}", name="show")
     */
    public function show(Actor $actor): Response
    {
        return $this->render('program/actor_show.html.twig', [
            'actor' => $actor
            
        ]);
    }

   
}
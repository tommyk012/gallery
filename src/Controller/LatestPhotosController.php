<?php

namespace App\Controller;

use App\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LatestPhotosController extends AbstractController
{
    /**
     * @Route("/latest", name="latest_photos")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $latestPhotosPublic = $em->getRepository(Photo::class)->findAllPublic();
//        $latestPhotosPublic = $em->getRepository(Photo::class)->findBy(['is_public'=>true]);

        return $this->render('latest_photos/index.html.twig', [
            'latestPhotosPublic' => $latestPhotosPublic
        ]);
    }
}
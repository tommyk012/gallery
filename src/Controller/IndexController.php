<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\UploadPhotoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request): Response
    {

        $form = $this->createForm(UploadPhotoType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            if($this->getUser()){

                try{
                    /** @var UploadedFile $pictureFileName */
                    $pictureFileName = $form->get('filename')->getData();
//                dd($pictureFileName);
                    if($pictureFileName){
                        $originalFileName = pathinfo($pictureFileName->getClientOriginalName(), PATHINFO_FILENAME);
                        $safeFileName = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFileName);
                        $newFileName = $safeFileName . '-' . uniqid() . '.' . $pictureFileName->guessExtension();
                        $pictureFileName -> move('images/hosting' , $newFileName);

                        $entityPhoto = new Photo();
                        $entityPhoto->setFilename($newFileName);
                        $entityPhoto->setIsPublic($form->get('is_public')->getData());
                        $entityPhoto->setUploadetAt(new \DateTimeImmutable());
                        $entityPhoto->setUser($this->getUser());
                        $em->persist($entityPhoto);
                        $em->flush();
                        $this->addFlash('success', 'Dodano zdjęcie');

                }}
                catch (\Exception $e){
                    $this->addFlash('error', 'Wystąpił błąd: ' . $e);
                }
            }
        }
        return $this->render('index/index.html.twig', [
            'form' => $form->createView(),

        ]);
    }
}

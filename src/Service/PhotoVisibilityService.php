<?php

namespace App\Service;

use App\Entity\Photo;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class PhotoVisibilityService
{
    private $photoRepository;
    private $secutiry;
    private $entytiManager;

    public function __construct(PhotoRepository $photoRepository, Security $security, EntityManagerInterface $entityManager){
        $this->entytiManager = $entityManager;
        $this->secutiry = $security;
        $this->photoRepository = $photoRepository;
    }

    public function makeVisible(int $id, bool $visibility){
        $em = $this->entytiManager;
        $photo = $this->photoRepository->find($id);
        if($this->isPhotoBelongToCurrentUser($photo)){
            $photo->setIsPublic($visibility);
            $em->persist($photo);
            $em->flush();
            return true;
        } else {
            return false;
        }
    }

    private function isPhotoBelongToCurrentUser(Photo $photo){
        if($photo->getUser() === $this->secutiry->getUser()){
            return true;
        } else {
            return false;
        }
    }

}
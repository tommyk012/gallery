<?php

namespace App\Command;

use App\Entity\Photo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *
 */
class DisablePhotosVisibilityCommand extends Command
{
    protected static $defaultName = 'app:photo-visible-false';
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    public function configure()
    {
        $this
            ->setDescription('Ustawia wszystkie zdjęcia jako prywatne dla każdego ID użytkownika')
            ->addArgument('user', InputArgument::REQUIRED, 'ID użytkownika wymagane');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
//        var_dump($input);
        $em=$this->entityManager;
        $photoRepository = $em->getRepository(Photo::class);
        $photosToSetPrivate = $photoRepository->findBy(['is_public' => 1, 'User' => $input->getArgument('user')]);

        foreach ($photosToSetPrivate as $publicPhoto){
            $publicPhoto->setIsPublic(0);
            $em->persist($publicPhoto);
            $em->flush();

        }
        return 0;
    }
}
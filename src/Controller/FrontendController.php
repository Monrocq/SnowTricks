<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use App\Repository\TrickRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FrontendController extends AbstractController
{
    /**
     * @var TrickRepository
     */
    private $trickRepo;

    /**
     * @var ImageRepository
     */
    private $imageRepo;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(
        TrickRepository $trickRepo,
        ImageRepository $imageRepo,
        ObjectManager $em
    )
    {
        $this->trickRepo = $trickRepo;
        $this->imageRepo = $imageRepo;
        $this->em = $em;
    }

    /**
     * @Route("/", name="frontend")
     */
    public function index()
    {
        $tricks = $this->trickRepo->findLastAll();
        $images = $this->imageRepo->findBy(array('une' => 1));
        dump($images);
        return $this->render('frontend/index.html.twig', [
            'controller_name' => 'FrontendController',
            'tricks' => $tricks,
            'images' => $images
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Repository\CategoryRepository;
use App\Repository\ImageRepository;
use App\Repository\TrickRepository;
use App\Repository\VideoRepository;
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
     * @var VideoRepository
     */
    private $videoRepo;

    /**
     * @var CategoryRepository
     */
    private $categoryRepo;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(
        TrickRepository $trickRepo,
        ImageRepository $imageRepo,
        VideoRepository $videoRepo,
        CategoryRepository $categoryRepo,
        ObjectManager $em
    )
    {
        $this->trickRepo = $trickRepo;
        $this->imageRepo = $imageRepo;
        $this->videoRepo = $videoRepo;
        $this->categoryRepo = $categoryRepo;
        $this->em = $em;
    }

    /**
     * @Route("/", name="frontend")
     */
    public function index()
    {
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_NONE')) {
            return $this->render('security/logout.html.twig');
        }

        $tricks = $this->trickRepo->findLastAll();
        $images = $this->imageRepo->findBy(array('une' => 1));
        dump($tricks[0]);
        return $this->render('frontend/index.html.twig', [
            'controller_name' => 'FrontendController',
            'tricks' => $tricks,
            'images' => $images,
            'nb' => count($tricks)
        ]);
    }

    /**
     * @Route("tricks/details/{id}", name="trick.show")
     */
    public function show(Trick $trick)
    {
        $une = $this->imageRepo->findOneBy(array('trick' => $trick, 'une' => 1));
        $images = $this->imageRepo->findBy(array('trick' => $trick));
        $videos = $this->videoRepo->findBy(array('trick' => $trick));
        $group_id = $trick->getcategory()->getid();
        $group = $this->categoryRepo->find(array('id' => $group_id));
        return $this->render('frontend/show.html.twig', [
            'trick' => $trick,
            'une' => $une,
            'images' => $images,
            'videos' => $videos,
            'group' => $group
        ]);
    }
}

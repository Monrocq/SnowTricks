<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\CommentType;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\ImageRepository;
use App\Repository\TrickRepository;
use App\Repository\VideoRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

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

    private $paginator;

    private $commentRepo;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(
        TrickRepository $trickRepo,
        ImageRepository $imageRepo,
        VideoRepository $videoRepo,
        CategoryRepository $categoryRepo,
        CommentRepository $commentRepo,
        PaginatorInterface $paginator,
        ObjectManager $em
    )
    {
        $this->trickRepo = $trickRepo;
        $this->imageRepo = $imageRepo;
        $this->videoRepo = $videoRepo;
        $this->categoryRepo = $categoryRepo;
        $this->commentRepo = $commentRepo;
        $this->paginator = $paginator;
        $this->em = $em;
    }

    /**
     * @Route("/", name="frontend")
     */
    public function index(Request $request)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_NONE')) {
            return $this->render('security/logout.html.twig');
        }

        //$tricks = $this->trickRepo->findLastAll();
        $tricks = $this->paginator->paginate($this->trickRepo->createQueryBuilder('p'),
            $request->query->getInt('page', 1),
            10
        );
        $images = $this->imageRepo->findBy(array('une' => 1));

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
    public function show(Trick $trick, Request $request)
    {
        $comment = new Comment();
        $commentTpe = $this->createForm(CommentType::class, $comment);
        $commentTpe->handleRequest($request);

        $user = $this->get('security.token_storage')->getToken()->getUser();

        if ($commentTpe->isSubmitted() && $commentTpe->isValid()) {
            $comment->setCreatedAt(new \DateTime('now'));
            $comment->setTrick($trick);
            $comment->setUser($user);
            $this->em->persist($comment);
            $this->em->flush();
        }
        
        $une = $this->imageRepo->findOneBy(array('trick' => $trick, 'une' => 1));
        $images = $this->imageRepo->findBy(array('trick' => $trick));
        $videos = $this->videoRepo->findBy(array('trick' => $trick));
        if ($trick->getcategory()) {
            $group_id = $trick->getcategory()->getid();
            $group = $this->categoryRepo->find(array('id' => $group_id));
        } else {
            $group['title'] = 'Null';
        }
        //$comments = $this->commentRepo->findBy(array('trick' => $trick), array('createdAt' => 'DESC'));
        $trickId = $trick->getId();
        $comments = $this->paginator->paginate($this->commentRepo->createQueryBuilder('p')->where("p.trick = :trick")->setParameter('trick', $trick)->orderBy('p.createdAt', 'DESC'),
            $request->query->getInt('page', 1),
            10
        );

        if ($this->imageRepo->findBy(array('trick' => $trick))[0]) {
            $replace = $this->imageRepo->findBy(array('trick' => $trick))[0]->getUrl();
        } else {
            $replace = null;
        }

        dump($replace);

        return $this->render('frontend/show.html.twig', [
            'trick' => $trick,
            'une' => $une,
            'images' => $images,
            'videos' => $videos,
            'group' => $group,
            'form' => $commentTpe->createView(),
            'comments' => $comments,
            'user' => $user,
            'replace' => $replace
        ]);
    }
}

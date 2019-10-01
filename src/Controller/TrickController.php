<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Une;
use App\Entity\Upload;
use App\Entity\Video;
use App\Form\TrickType;
use App\Form\UneType;
use App\Form\UploadType;
use App\Form\VideoType;
use App\Repository\TrickRepository;
use App\Repository\ImageRepository;
use App\Repository\VideoRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
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
     * @var ObjectManager
     */
    private $em;

    public function __construct(
        TrickRepository $trickRepo,
        ImageRepository $imageRepo,
        VideoRepository $videoRepo,
        ObjectManager $em
    )
    {
        $this->trickRepo = $trickRepo;
        $this->imageRepo = $imageRepo;
        $this->videoRepo = $videoRepo;
        $this->em = $em;
    }

    /**
     * @Route("/trick", name="trick")
     */
    public function index()
    {
        
    }

    /**
     * @Route("/new", name="trick.new")
     */
    public function new()
    {
        $trick = new Trick();
    }

    /**
     * @Route("/edit/{id}", name="trick.edit")
     * @param Trick $trick
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Trick $trick, Request $request)
    {
        //Initialisation des repos
        $une = $this->imageRepo->findOneBy(array('trick' => $trick, 'une' => 1));
        $images = $this->imageRepo->findBy(array('trick' => $trick, 'une' => 0));
        $allImages = $this->imageRepo->findBy(array('trick' => $trick));
        $videos = $this->videoRepo->findBy(array('trick' => $trick));
        $imagesTotal = $this->imageRepo->findAll();
        $videosTotal = $this->videoRepo->findAll();

        //Création forms
        $uneFile = new Une();
        $uneType = $this->createForm(UneType::class, $uneFile);
        $imageFile = new Upload();
        $imageType = $this->createForm(UploadType::class, $imageFile);
        $video = new Video();
        $videoType = $this->createForm(VideoType::class, $video);
        $trickType = $this->createForm(TrickType::class, $trick);

        //Manipulation forms
        $uneType->handleRequest($request);
        $trickType->handleRequest($request);
        $imageType->handleRequest($request);
        $videoType->handleRequest($request);

        //Videos
        if ($videoType->isSubmitted() && $videoType->isValid()) {

            //Update
            if ($this->videoRepo->findOneBy(array('id' => (int)$video->getId())) != null && (int)$video->getId() == (int)$this->videoRepo->findOneBy(array('id' => (int)$video->getId()))->getId()) {

                $id = $video->getId();
                $movie = $this->videoRepo->findOneBy(array('id' => $id));
                $movie->setUrl($video->getUrl());
                $this->em->persist($movie);
                $this->em->flush();

            } else { //Create

                $id = $video->getId();
                $movie = new Video();
                $movie->setUrl($video->getUrl());
                $movie->setTrick($trick);
                $this->em->persist($movie);
                $this->em->flush();

            }

            $videos = $this->videoRepo->findBy(array('trick' => $trick));
        }

        //Images
        if ($imageType->isSubmitted() && $imageType->isValid()) {

            //For Update
            if ($this->imageRepo->findOneBy(array('id' => (int)$imageFile->getNb())) != null && (int)$imageFile->getNb() == $this->imageRepo->findOneBy(array('id' => (int)$imageFile->getNb()))->getId()) {

                $imageToReplace = $this->imageRepo->findOneBy(array('id' => $imageFile->getNb()));
                $file = $imageFile->getName();
                $fileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($this->imageRepo->findOneBy(array('id' => $imageFile->getNb()))->getUrl())).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $fileName);

                //if ($fileName != basename($images[(int)$imageFile->getNb()]->getUrl())) {
                $imageToReplace->setUrl('img/tricks/'.$fileName);
                $this->em->persist($imageToReplace);
                $this->em->flush();
                //}

            } else { //For Create

                $file = $imageFile->getName();
                $fileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', strtolower($trick->getTitle())).((int)count($allImages)+1).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $fileName);

                $newImage = new Image();
                $newImage->setUrl('img/tricks/'.$fileName);
                $newImage->setTrick($trick);
                $newImage->setUne(0);
                $this->em->persist($newImage);
                $this->em->flush();

            }

            $images = $this->imageRepo->findBy(array('trick' => $trick, 'une' => 0));

        }


        //New Image "à la une"?
        if ($uneType->isSubmitted() && $uneType->isValid()) {

            //function could find the new name for the file
            foreach ($allImages as $image) {
                $liens[] = basename($image->getUrl());
            }
            rsort($liens);
            $newLink = (int)preg_replace('~\D~', '', $liens[0]);
            $newLink += 1;
            $newLink = strtolower($trick->getTitle()) . $newLink;

            $file = $uneFile->getName();
            $extension = $file->guessExtension();
            $fileName = $newLink.'.'.$extension;
            $file->move($this->getParameter('upload_directory'), $fileName);
            $uneFile->setName($fileName);

            if ($une != null) {
                $une->setUne(0);
            }

            $newUne = new Image();
            $newUne->setUrl('img/tricks/'.$fileName);
            $newUne->setUne(1);
            $newUne->setTrick($trick);

            dump($newUne);

            $this->em->persist($newUne);
            $this->em->flush();

            //On remet à jour les nouveaux élements
            $une = $this->imageRepo->findOneBy(array('trick' => $trick, 'une' => 1));
            $images = $this->imageRepo->findBy(array('trick' => $trick, 'une' => 0));
        }

        //Other modification?
        if ($trickType->isSubmitted() && $trickType->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('trick.show', ['id' => $trick->getId()]);
        }
        


        //default
        return $this->render('backend/edit.html.twig', [
            'trick' => $trick,
            'une' => $une,
            'images' => $images,
            'videos' => $videos,
            'form' => $trickType->createView(),
            'type' => $uneType->createView(),
            'forms' => $imageType->createView(),
            'videoForm' => $videoType->createView(),
            'numImages' => 0,
            'newValue' => (int)end($imagesTotal)->getId()+1,
            'newValue2' => (int)end($videosTotal)->getId()+1
        ]);
    }
}

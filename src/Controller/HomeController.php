<?php

namespace App\Controller;

use App\Repository\ClassificationRepository;
use App\Repository\IntervenantRepository;
use App\Repository\OrganizerRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @var OrganizerRepository
     */
    private $organizerRepository;

    /**
     * @var IntervenantRepository
     */
    private $intervenantRepository;

    /**
     * @var ClassificationRepository
     */
    private $classificationRepository;

    /**
     * @var PostRepository
     */
    private $postRepository;


    public function __construct(
        OrganizerRepository $organizerRepository,
        IntervenantRepository $intervenantRepository,
        ClassificationRepository $classificationRepository,
        PostRepository $postRepository
    )
    {
        $this->organizerRepository = $organizerRepository;
        $this->intervenantRepository = $intervenantRepository;
        $this->classificationRepository = $classificationRepository;
        $this->postRepository = $postRepository;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {;
        return $this->render('home_front/index.html.twig',[
            'posts' => $this->postRepository->getPostLimited(5),
            'organizers' => $this->organizerRepository->findAll(),
            'intervenants' => $this->intervenantRepository->findAllGreaterThanIntervenant(),
            'classifications'   => $this->classificationRepository->findAllByPosition()
        ]);
    }


    public function renderItemFooter()
    {
        $organizers = $this->organizerRepository->findAll();
        return $this->render('includes/footer.html.twig',[
            'organizers' => $organizers
        ]);
    }
}
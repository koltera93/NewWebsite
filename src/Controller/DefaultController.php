<?php

namespace App\Controller;

use App\Service\Blogs;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Blogs $blogService)
    {
       // return $this->render('blogs/index.html.twig', [
            return $this->render('base.html.twig', [
            'blog' => $blogService->getBlog(),
        ]);
    }
}

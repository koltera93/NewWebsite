<?php

namespace App\Controller;

use App\Entity\Blog;
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

        $filter = $this->getDoctrine()->getRepository(Blog::class);
        $latestBlogs = $filter->findBy([],['date' => 'DESC'], 3);

            return $this->render('base.html.twig', [
                'blog' => $latestBlogs,
                //'blog' => $blogService->getBlog(),
        ]);
    }
}

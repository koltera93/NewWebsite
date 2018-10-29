<?php
/**
 * Created by PhpStorm.
 * User: volodya
 * Date: 28.10.18
 * Time: 15:56
 */

namespace App\Controller;


use App\Entity\Blog;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{

    /**
     * @Route("/Blog", name="Blog")
     */
    public function index()
    {

        $AddBlog = new Blog();

        $form = $this->createFormBuilder($AddBlog)
            ->add('name')
            ->add('text')
            ->getForm();

        return $this->render('blogs/index.html.twig',
            ['form' => $form->createView(),]
            );
    }

    /**
     * @Route("/blogs/{id}", name="blogs_show")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @ParamConverter("post")
     */
    public function show(Blog $blogService)
    {
        return $this->render('blogs/show.html.twig', [
            'blog' => $blogService
        ]);
    }

}
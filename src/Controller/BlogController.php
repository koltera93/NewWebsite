<?php
/**
 * Created by PhpStorm.
 * User: volodya
 * Date: 28.10.18
 * Time: 15:56
 */

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Blog;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends AbstractController
{

    /**
     * @Route("/blog/{id}", name="blog")
     */
    public function index(Request $request, EntityManagerInterface $entityManager)
    {
            $blog = new Blog();

        $form = $this->createFormBuilder($blog)
            ->add('blog')
            ->add('text')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($blog);
            $entityManager->flush();

            return $this->redirectToRoute('blogs_show',['id' => $blog->getId()]);
        }

        return $this->render('blogs/index.html.twig',
            ['form' => $form->createView(),]
            );
    }

    /**
     * @Route("/blogs/{id}", name="blogs_show")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Blog $blog, Request $request, EntityManagerInterface $entityManager)
    {

        $comment = new Comment();

        $form = $this->createFormBuilder($comment)
            ->add('nickname')
            ->add('comment')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('blog', ['id' => $blog->getId()]);
        }

        return $this->render('blogs/show.html.twig', [
            'blog' => $blog,
            'form' => $form->createView(),
        ]);
    }

}
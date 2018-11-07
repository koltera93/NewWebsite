<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Blog;
use App\Form\BlogType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{

    /**
     * @Route("/blog", name="blog")
     */
    public function index(Request $request, EntityManagerInterface $entityManager)
    {
            $blog = new Blog();

        $form = $this->createFormBuilder($blog)
            ->add('name')
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

     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Blog $blog, Request $request, EntityManagerInterface $entityManager)
    {

        $comment = new Comment();
        $comment->setBlog($blog);

        $form = $this->createFormBuilder($comment)
            ->add('nickname')
            ->add('comment')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('blogs_show', ['id' => $blog->getId()]);
        }

        return $this->render('blogs/show.html.twig', [
            'blog' => $blog,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/blogs_edit/{id}", name="blogs_edit")

     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request, Blog $blog)
    {
        $id = $blog->getId();

        $blog = $this->getDoctrine()
            ->getRepository(Blog::class)
            ->find($id);

        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('blogs_edit',[
                'id' => $blog->getId()
            ]);
        }

        return $this->render('blogs/edit.html.twig',
            ['form' => $form->createView()]
        );
    }


}
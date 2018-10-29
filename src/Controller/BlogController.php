<?php
/**
 * Created by PhpStorm.
 * User: volodya
 * Date: 28.10.18
 * Time: 15:56
 */

namespace App\Controller;


use App\Entity\Blog;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends AbstractController
{

    /**
     * @Route("/blog/create", name="blog")
     */
    public function index(Request $request, EntityManagerInterface $entityManager)
    {

        $addBlog = new Blog();

        $form = $this->createFormBuilder($addBlog)
            ->add('name')
            ->add('text')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($addBlog);
            $entityManager->flush();

            $this->addFlash('success' , 'Спасибо за обращение, мы обязательно с вами свяжемся!');

            return $this->redirectToRoute('blogs_show',['id' => $addBlog->getId()]);
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
    public function show(Blog $blog)
    {
        return $this->render('blogs/show.html.twig', [
            'blog' => $blog
        ]);
    }

}
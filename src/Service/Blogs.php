<?php

namespace App\Service;

use App\Entity\Blog;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class Blogs
{

    /**
     * @var EntityMnager
     */
    private $em;

    /**
     * @var EntityRepository
     */
    private $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

        $this->repo = $this->em->getRepository(Blog::class);
    }


    /**
     * @return Blog[]
     */
    public function getBlog()
    {
        return $this->repo->findAll();
    }

    /**
     * @return Blog
     */
    public function getById($id): ?Blog
    {
        return $this->repo->find($id);
    }

}
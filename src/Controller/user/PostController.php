<?php

namespace App\Controller\user;

use App\Entity\Post;
use App\Form\Post1Type;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/" name="post_index", methods={"GET"})
     *
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }


    /**
     * @Route("/post/{slug}")
     * @param string $slug 
     */
    public function post(string $slug): Response
    {
        return $this->render('post/post.html.twig',[
            'slug' => $slug,
        ]);
    }

}

?>
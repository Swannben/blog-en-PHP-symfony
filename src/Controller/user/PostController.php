<?php

namespace App\Controller\user;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/", name="home")
     *
     */
    public function index(): Response
    {
        $postRepository = $this->getDoctrine()->getRepository(Post::class);

        $posts = $postRepository->findAll();


        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/post/{slug}", name="post_show", methods={"GET"})
     * @param string $slug 
     */
    public function post(string $slug): Response
    {
        $postRepository = $this->getDoctrine()->getRepository(Post::class);

        $post = $postRepository->findBySlug($slug);

        return $this->render('post/show.html.twig',[
            'post' => $post,
        ]);
    }


}

?>
<?php

namespace App\Controller\user;


use App\Form\CommentType;
use App\Entity\Post;
use App\Form\PostType;
use DateTime;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class PostController extends AbstractController
{
    /**
     * @Route("/{page}", name="home", methods={"GET"})
     * @param int $page
     */
    public function index(int $page = 1, PaginatorInterface $paginator): Response
    {
        $postRepository = $this->getDoctrine()->getRepository(Post::class);

        $posts = $postRepository->getValidPost();
        $postlist = $paginator->paginate($posts,$page,5);
        return $this->render('post/index.html.twig', [
            'postlist' => $postlist,

        ]);
    }

    /**
     * @Route("/post/{slug}", name="post_show", methods={"GET","POST"})
     * @param string $slug 
     */
    public function post(Request $request,string $slug): Response
    {
        $postRepository = $this->getDoctrine()->getRepository(Post::class);

        $post = $postRepository->findBySlug($slug);

        if (null === $post || $post->getPublishedAt() > new DateTime()) {
            throw $this->createNotFoundException("Post not found");
        }

        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setPost($post);
            $comment->setValid(false);
            $comment->setCreatedAt(new DateTime());
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('post_show', [
                'slug' => $slug
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('post/show.html.twig',[
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }


}

?>
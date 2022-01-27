<?php

namespace App\Controller\admin;

use App\Entity\Category;
use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

class PostController extends AbstractController
{
    /**
     * @Route("/admin/post", name="admin_post_index")
     * 
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.admin.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/post/new", name="admin_post_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {   
        $categoryRepository = $this->getDoctrine()->getRepository(Category::class);

        $post = new Post();
        $post->setPublishedAt(new DateTime());
        
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $post->setCreatedAt(new DateTime());
            $post->setUpdatedAt(new DateTime());
            $post->setSlug((new AsciiSlugger())->slug($post->getTitle()));
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('admin_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/admin/post/edit/{id}", name="post_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, int $id): Response
    {
        $entityManager = $this -> getDoctrine()->getManager();
        $postRepository = $this->getDoctrine()->getRepository(Post::class);
        $post = $postRepository ->find($id);

        if($post == null){
            return $this -> createNotFoundException("Ce post n'existe pas");
        }

        $post -> setUpdatedAt(new DateTime());

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('admin_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/admin/post/delete/{id}", name="post_delete", methods={"GET"})
     * @param int $id
     */
    public function delete(int $id): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $post= $manager->getRepository(Post::class)->find($id);
        if (!$post) {
            throw $this->createNotFoundException("Post not found");
        }
        $manager->remove($post);
        $manager->flush();

        return $this->redirectToRoute('admin_post_index', [], Response::HTTP_SEE_OTHER);
    }
}

?>
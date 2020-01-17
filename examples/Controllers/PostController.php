<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class PostController
 * @package App\Controller
 *
 * @Route("/post", name="post.")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param PostRepository $postRepository
     * @return Response
     */
    public function index(PostRepository $postRepository)
    {
        $posts = $postRepository->findAll();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }


    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        // create a new post with title
        $post = new Post();

        /* $post->setTitle('This is going to be a title'); */

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        /* $errors = $form->getErrors(); */

        if($form->isSubmitted() && $form->isValid())
        {
            /* debug($post); */
            /* dd($request->files); */
            $em = $this->getDoctrine()->getManager();

            /** @var UploadedFile $file */
            $file = $request->files->get('post')['attachment'];

            // if has file uploaded
            if($file)
            {
                # Generate file name
                $filename = md5(uniqid()) .'.'. $file->guessClientExtension();

                # Save file somewhere
                $file->move(
                    $this->getParameter('uploads_dir'),
                    $filename
                );

                $post->setImage($filename);
                $em->persist($post);
                $em->flush();
            }

            return $this->redirect($this->generateUrl('post.index'));
        }


        // return a response
        /* return new Response('Post was created'); */
        /* return $this->redirect($this->generateUrl('post.index')); */

        return $this->render('post/create.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/show/{id}", name="show")
     * @param Post $post
     * @return Response
     */
    public function show(Post $post)
    {
        // create the show view
        return $this->render('post/show.html.twig', [
            'post' => $post
        ]);
    }

    /*
     Route("/show/{id}", name="show")
     public function show(int $id, PostRepository $postRepository)
     {
        $post = $postRepository->findPostWithCategory($id);

        dd($post);
        // create the show view
        return $this->render('post/show.html.twig', [
            'post' => $post
        ]);
     }

     public function show(Post $post)
     {
        // create the show view
        return $this->render('post/show.html.twig', [
            'post' => $post
        ]);
     }

     public function showOld($id, PostRepository $postRepository)
     {
        $post = $postRepository->find($id);

        // create the show view
        return $this->render('post/show.html.twig', [
            'post' => $post
        ]);
     }
    */


    /**
     * @Route("/delete/{id}", name="delete")
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function remove(Post $post)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($post);
        $em->flush();

        $this->addFlash('success', 'Post was removed');


        return $this->redirect($this->generateUrl('post.index'));
    }
}

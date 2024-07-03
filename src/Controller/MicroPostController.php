<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Repository\MicroPostRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MicroPostController extends AbstractController
{
    #[Route('/micro-post', name: 'app_micro_post', priority: 1)]
    public function index(MicroPostRepository $posts): Response
    {
        return $this->render('micro_post/index.html.twig', [
            'posts' => $posts->findAll(),
        ]);
    }

    #[Route('/micro-post/{post}', name: 'app_micro_post_show')]
    public function showOne(MicroPost $post): Response
    {
        return $this->render('micro_post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('micro-post/add', name: 'app_micro_post_add', priority: 2)]
    public function add(Request $req, EntityManagerInterface $em): Response
    {
        $post = new MicroPost();
        $form = $this->createFormBuilder($post)
            ->add('title')
            ->add('text')
            // ->add('submit', SubmitType::class, ['label' => 'Post'])
            ->getForm();

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $post->setCreated(new DateTime());

            $em->persist($post);
            $em->flush();

            // Add a toast popup
            $this->addFlash('success', 'Your post have been submitted');

            // Redirect to the list of posts
            return $this->redirectToRoute('app_micro_post');
        }

        return $this->render(
            'micro_post/add.html.twig',
            [
                'form' => $form,
            ]
        );
    }
}

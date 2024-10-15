<?php

namespace App\Controller;

use DateTime;
use App\Entity\Comment;
use App\Entity\MicroPost;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Repository\CommentRepository;
use App\Repository\MicroPostRepository;
use App\Repository\UserProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    private array $messages = [
        ['message' => 'Hello', 'created' => '2024/04/01'],
        ['message' => 'Hi', 'created' => '2024/02/01'],
        ['message' => 'Bye!', 'created' => '2023/03/01']
    ];

    #[Route('/', name: 'app_index')]
    public function index(EntityManagerInterface $em, UserProfileRepository $profiles, CommentRepository $comments, MicroPostRepository $posts): Response
    {
        // // working with one to one relation
        // // add user
        // $user = new User();
        // $user->setEmail('email@email.com');
        // $user->setPassword('12345678');
        // // add profile
        // $profile = new UserProfile();
        // // set user for profile and persist to db
        // $profile->setUser($user);
        // $em->persist($profile);
        // $em->flush();

        // // remove user and profile
        // $profile = $profiles->find(1);
        // $em->remove($profile);
        // $em->flush();

        // // working with one to many relation
        // // fetch a post
        // $post = $posts->find(12);
        // // add new comment
        // $comment = new Comment();
        // $comment->setText('Hello 2');
        // // associate the comment with the post
        // $comment->setPost($post);
        // // persist the post to db
        // $em->persist($comment);
        // $em->flush();

        // // remove a comment
        // // query the post and the first comment
        // $post = $posts->find(12);
        // $comment = $post->getComments()[0];
        // // remove the comment the persist the post to db
        // $post->removeComment($comment);
        // $em->persist($post);
        // $em->flush();

        return $this->render(
            'hello/index.html.twig',
            [
                'messages' => $this->messages,
                'limit' => 3
            ]
        );
    }

    #[Route('/messages/{id<\d+>}', name: 'app_show_one')]
    public function showOne(int $id): Response
    {
        return $this->render(
            'hello/show_one.html.twig',
            [
                'message' => $this->messages[$id]
            ]
        );
    }
}

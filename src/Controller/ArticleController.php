<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function homepage()
    {
        return new Response('My first page!');
    }

    /**
     * @Route("/news/{slug}")
     */
    public function show($slug)
    {
        $comments = [
            'Accusamus, est, facilis. A alias autem debitis doloremque earum ',
            'Alias culpa dolore excepturi, mollitia nesciunt pariatur. Atque quaerat, sed!',
            'Ab adipisci assumenda corporis, deleniti eaque earum fuga, iste itaque laudantium modi quae, quaerat quia soluta unde ut vero.',
        ];

        return $this->render(
            'article/show.html.twig',
            [
                'title'    => ucwords(str_replace('-', ' ', $slug)),
                'comments' => $comments,
            ]
        );
    }
}
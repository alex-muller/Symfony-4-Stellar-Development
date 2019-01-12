<?php

namespace App\Controller;


use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        return $this->render('article/homepage.html.twig');
    }

    /**
     * @Route("/news/{slug}", name="article_show")
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
                'slug'     => $slug,
            ]
        );
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart($slug, LoggerInterface $logger)
    {
        // TODO - actually heart/unheart the article

        $logger->info('Article is being hearted');

        return new JsonResponse(['hearts' => rand(5, 100)]);
    }
}
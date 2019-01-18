<?php

namespace App\Controller;


use Michelf\MarkdownInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\AdapterInterface;
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
    public function show($slug, MarkdownInterface $markdown, AdapterInterface $cache)
    {
        $comments = [
            'Accusamus, est, facilis. A alias autem debitis doloremque earum ',
            'Alias culpa dolore excepturi, mollitia nesciunt pariatur. Atque quaerat, sed!',
            'Ab adipisci assumenda corporis, deleniti eaque earum fuga, iste itaque laudantium modi quae, quaerat quia soluta unde ut vero.',
        ];

        $articleContent = <<<EOF
Lorem **ipsum dolor** sit amet, consectetur adipiscing elit. Fusce vitae nisi auctor, consequat ante non, auctor ex. 
[Donec eget](https://baconipsum.com) orci feugiat quam cursus ultricies eget et justo. Suspendisse vulputate nisi sed lorem tempor, hendrerit 
gravida felis lacinia. Nulla facilisi. Nulla varius porttitor scelerisque. Nullam eget condimentum est. Pellentesque
hendrerit varius dictum. Aenean eget nunc porta, volutpat massa et, **semper orci** .

Pellentesque efficitur augue eu sem placerat eleifend. Aenean a fermentum elit. Proin eu lacinia ex, a aliquet ipsum. 
Cras lobortis felis justo, in rutrum ligula commodo non. Donec congue tellus ac porta ultricies. Morbi convallis 
rutrum neque quis iaculis. Vestibulum lobortis mauris non pulvinar blandit.

Phasellus interdum ipsum non congue sollicitudin. Duis ut ornare nunc. Proin vel varius nunc, non ullamcorper mauris. 
Integer suscipit ante fermentum enim mollis dictum. Nunc euismod fermentum elit sit amet ornare. Quisque varius libero 
nec est laoreet dapibus. Fusce vehicula augue nisi, id aliquet diam scelerisque sit amet. Maecenas quis odio nulla.
EOF;

        $item = $cache->getItem('markdown_'.md5($articleContent));
        if (!$item->isHit()) {
            $item->set($markdown->transform($articleContent));
            $cache->save($item);
        }
        $articleContent = $item->get();

        return $this->render(
            'article/show.html.twig',
            [
                'title'          => ucwords(str_replace('-', ' ', $slug)),
                'articleContent' => $articleContent,
                'comments'       => $comments,
                'slug'           => $slug,
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
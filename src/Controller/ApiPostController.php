<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiPostController extends AbstractController
{
    /**
     * @Route("/api/post", name="api_post")
     */
    public function index(HttpClientInterface $client): Response
    {

        $response = $client->request(
            'GET',
            'http://medouaz-blog.herokuapp.com/api/posts'
        );
        $content = $response->getContent();
        $content = $response->toArray();
        return $this->render('api_post/index.html.twig', [
            'Posts' => $content
        ]);
    }

    /**
     * @Route("/api/posts", name="api_posts",  methods={"GET"})
     */
    public function sendPosts(PostRepository $postRepository): JsonResponse
    {
        $posts = $postRepository->findFirst5OrderedByPublishedTime();
        $data = [];
        foreach ($posts as $post) {
            $data[] = [
                'id' => $post->getId(),
                'title' => $post->getTitle(),
                'urlAlias' => $post->getUrlAlias(),
                'content' => $post->getContent(),
                'published' => $post->getPublished(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

}

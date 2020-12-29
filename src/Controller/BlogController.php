<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;

class BlogController extends AbstractController
{

    /**
     * @Route("/", name="HomePage")
     */
    public function index(PostRepository $repo,Request $request,PaginatorInterface $paginator)
    {
        $posts=$repo->findAllOrderedByPublishedTime();

        $articles = $paginator->paginate(
            $posts, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4 // Nombre de résultats par page
        );

        return $this->render('blog/index.html.twig', [

            'Posts'=>$articles

        ]);
    }

    /**
     * @Route("/posts/{url_alias}", name="Articlepost")
     */
    public function post(Post $post): Response
    {
        return $this->render('blog/post.html.twig', [
            'post'=> $post
        ]);
    }
}

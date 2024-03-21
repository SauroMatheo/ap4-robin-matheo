<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Articles;
use App\Repository\ArticlesRepository;
use App\Repository\StockageRepository;
use App\Repository\RayonsRepository;

use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    #[Route('/api', name: 'app_api', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return new JsonResponse([
            'controller_name' => 'ApiController',
        ]);
    }

    #[Route('/api/articles', name: 'app_api', methods: ['GET'])]
    public function api_articles(ArticlesRepository $articleRepository, SerializerInterface $serializer): JsonResponse
    {
        /*
        Possibles $_GET :
        id:         Identifiant
        limit:      Limite de résultats (25 max)
        offset:     A partir de quel résultat on commence
        */
        if (isset($_GET["id"])) {
            $articles = $articleRepository->find($_GET["id"]);
        } else {
            $limit = null;
            $offset = null;

            if (isset($_GET["limit"])) { $limit = $_GET["limit"]; }
            if (isset($_GET["offset"])) { $offset = $_GET["offset"]; }
    
            if ($limit == null) {
                $articles = $articleRepository->findLimit(25, 0);
            } else {
                if ($offset == null) {
                    $articles = $articleRepository->findLimit($limit, 0); 
                } else {
                    $articles = $articleRepository->findLimit($limit, $offset); 
                }
            }
        }

        $articlesList = $serializer->serialize($articles, 'json', ['groups' => 'articleList']);

        return new JsonResponse($articlesList, Response::HTTP_OK, [], true);
    }
}

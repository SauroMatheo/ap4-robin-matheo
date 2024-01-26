<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Articles;
use App\Repository\ArticlesRepository;
use App\Repository\ImageArticleRepository;
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
        $limit = null;

        if (isset($_GET["limit"])) { $limit = $_GET["limit"]; }

        if ($limit == null) {
            $articles = $articleRepository->findAll();
        } else {
            $articles = $articleRepository->findLimit($limit); 
        }

        $articlesList = $serializer->serialize($articles, 'json', ['groups' => 'articleList']);

        return new JsonResponse($articlesList, Response::HTTP_OK, [], true);
    }
}

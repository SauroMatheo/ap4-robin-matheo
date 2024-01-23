<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    /**
    * Page du profil.
    * Actuellement sans utilité
    */
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        return $this->render('profil/profil.php.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Consommable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/setQuantite/{id}/{quantite}", name="api_setQuantite")
     * @param Consommable $consommable
     * @param int $quantite
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function setQuantite(Consommable $consommable,int $quantite, EntityManagerInterface $entityManager)
    {
        $consommable->setQuantite($quantite);
        $consommable->setStock((int) (($consommable->getQuantite()/$consommable->getQuantiteOptimale())*100));
        $entityManager->persist($consommable);
        $entityManager->flush();
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }
}

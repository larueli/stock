<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Consommable;
use App\Form\CategorieType;
use App\Form\ConsommableType;
use App\Service\GestionEntite;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function index(EntityManagerInterface $entityManager)
    {
        $categories = $entityManager->getRepository(Categorie::class)->findAll();
        return $this->render('index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/courses/{stockMinimum}", name="courses")
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function courses(EntityManagerInterface $entityManager)
    {
        $sommeCategories = [];
        $tableau = [];
        $prixTotal = 0;
        foreach ($entityManager->getRepository(Categorie::class)->findAll() as $categorie) {
            $tableau[$categorie->getNom()] = [];
            $tableau[$categorie->getNom()]["somme"] = 0;
            $tableau[$categorie->getNom()]["produits"] = [];
            foreach ($entityManager->getRepository(Consommable::class)->createQueryBuilder('u')
                         ->andWhere('u.categorie = :cat')
                         ->setParameters(["cat" => $categorie->getId()])->getQuery()->execute() as $consommable) {
                /** @var Consommable $consommable */
                $nbPackAAcheter = 0;
                if ($consommable->getQuantiteOptimale() > $consommable->getQuantite())
                    $nbPackAAcheter = ceil((float) (($consommable->getQuantiteOptimale() - $consommable->getQuantite()) / $consommable->getVenduParPaquetsDe()));
                else
                    $nbPackAAcheter = 0;
                $prix = $nbPackAAcheter * $consommable->getPrixPaquet();
                $tableau[$categorie->getNom()]["somme"] += $prix;
                $prixTotal += $prix;
                if ($prix != 0)
                    $tableau[$categorie->getNom()]["produits"][] = ["consommable" => $consommable, "nbPackAAcheter" => $nbPackAAcheter, "prix" => $prix];
            }
        }
        //dd($tableau);
        return $this->render('courses.html.twig', [
            'tableau' => $tableau, 'total' => $prixTotal,
        ]);
    }

    /**
     * @Route("/editCategorie/{id?}", name="editCategorie")
     * @param $id
     * @param EntityManagerInterface $entityManager
     * @param GestionEntite $gestionEntite
     * @return RedirectResponse|Response
     */
    public function editCategorie($id, EntityManagerInterface $entityManager, GestionEntite $gestionEntite, Request $request)
    {
        $categorie = $gestionEntite->creerOuRecuperer(Categorie::class, $id);
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($categorie);
            $entityManager->flush();
            $this->addFlash("success", "La catégorie a bien été créée");
            return $this->redirectToRoute("accueil");
        }
        return $this->render('formulaire_basique.html.twig', [
            "creation"     => is_null($categorie->getId()),
            'titre'        => "Edition d'une catégorie",
            "route_post"   => $this->generateUrl("editCategorie", ["id" => $categorie->getId()]),
            'formulaire'   => $form->createView(),
            "description"  => "Ajouter une catégorie de consommables",
            "route_delete" => $this->generateUrl('supprimerCategorie', ["id" => $categorie->getId()]),
            "route_retour" => $this->generateUrl("accueil"),
        ]);
    }

    /**
     * @Route("/supprimerCategorie/{id?}", name="supprimerCategorie")
     * @param Categorie $categorie
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse
     */
    public function supprimerCategorie(Categorie $categorie, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($categorie);
        $entityManager->flush();
        $this->addFlash("warning","La catégorie et ses produits ont été effacés");
        return $this->redirectToRoute("accueil");
    }

    /**
     * @Route("/editConsommable/{id?}", name="editConsommable")
     * @param $id
     * @param EntityManagerInterface $entityManager
     * @param GestionEntite $gestionEntite
     * @return RedirectResponse|Response
     */
    public function editConsommable($id, EntityManagerInterface $entityManager, GestionEntite $gestionEntite, Request $request)
    {
        /** @var Consommable $consommable */
        $consommable = $gestionEntite->creerOuRecuperer(Consommable::class, $id);
        $form = $this->createForm(ConsommableType::class, $consommable);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $consommable->setStock((int) (($consommable->getQuantite()/$consommable->getQuantiteOptimale())*100));
            $entityManager->persist($consommable);
            $entityManager->flush();
            $this->addFlash("success", "La catégorie a bien été créée");
            return $this->redirectToRoute("accueil");
        }
        return $this->render('formulaire_basique.html.twig', [
            "creation"     => is_null($consommable->getId()),
            'titre'        => "Edition d'un consommable",
            "route_post"   => $this->generateUrl("editConsommable", ["id" => $consommable->getId()]),
            'formulaire'   => $form->createView(),
            "description"  => "Editer un consommable",
            "route_delete" => $this->generateUrl('supprimerConsommable', ["id" => $consommable->getId()]),
            "route_retour" => $this->generateUrl("accueil"),
        ]);
    }

    /**
     * @Route("/supprimerConsommable/{id?}", name="supprimerConsommable")
     * @param Consommable $consommable
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse
     */
    public function supprimerConsommable(Consommable $consommable, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($consommable);
        $entityManager->flush();
        $this->addFlash("warning","Le consommable a été effacé");
        return $this->redirectToRoute("accueil");
    }
}

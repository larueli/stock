<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * \class   GestionEntite
 *
 * @author  Ivann LARUELLE
 * \brief   Permet de créer ou récupérer une entité.
 * \details Cela sert notamment dans les pages qui gèrent des formulaires,
 *          cela permet d'avoir une entité à fournir au constructeur du formulaire.
 * @package App\Service
 */
class GestionEntite
{

    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /**
     * GestionEntite constructor.
     *
     * \brief Ne doit pas être appelé. Ce service est auto-wiré. use App\\Service\\GestionEntite; suffit.
     *
     * @param EntityManagerInterface $entityManager Autowiré par Symfony
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     *
     * \brief   Crée une instance (dont le champ actif vaut true) de la classe demandée si l'id est nul, sinon va récupérer l'instance dans la BDD ou lève une erreur 404 si l'id ne correspond à aucune donnée stockée.
     *
     * \details Il faut l'appeller juste avant de construire le formulaire.
     *
     * @param string   $classe
     * @param int|NULL $id
     *
     * @return object|null
     */
    public function creerOuRecuperer(string $classe, int $id = NULL)
    {
        if (is_null($id)) {
            $objet = new $classe();
        }
        else {
            $objet = $this->entityManager->getRepository($classe)->find($id);
            if (is_null($objet))
                throw new NotFoundHttpException();
        }
        return $objet;
    }
}
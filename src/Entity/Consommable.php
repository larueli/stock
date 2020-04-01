<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConsommableRepository")
 */
class Consommable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="consommables")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantiteOptimale;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantiteEnMoinsJour;

    /**
     * @ORM\Column(type="integer")
     */
    private $venduParPaquetsDe;

    /**
     * @ORM\Column(type="float")
     */
    private $prixPaquet;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prixUnite;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getQuantiteOptimale(): ?int
    {
        return $this->quantiteOptimale;
    }

    public function setQuantiteOptimale(int $quantiteOptimale): self
    {
        $this->quantiteOptimale = $quantiteOptimale;

        return $this;
    }

    public function getQuantiteEnMoinsJour(): ?int
    {
        return $this->quantiteEnMoinsJour;
    }

    public function setQuantiteEnMoinsJour(int $quantiteEnMoinsJour): self
    {
        $this->quantiteEnMoinsJour = $quantiteEnMoinsJour;

        return $this;
    }

    public function getVenduParPaquetsDe(): ?int
    {
        return $this->venduParPaquetsDe;
    }

    public function setVenduParPaquetsDe(int $venduParPaquetsDe): self
    {
        $this->venduParPaquetsDe = $venduParPaquetsDe;

        return $this;
    }

    public function getPrixPaquet(): ?float
    {
        return $this->prixPaquet;
    }

    public function setPrixPaquet(float $prixPaquet): self
    {
        $this->prixPaquet = $prixPaquet;

        return $this;
    }

    public function getPrixUnite(): ?float
    {
        return $this->prixUnite;
    }

    public function setPrixUnite(?float $prixUnite): self
    {
        $this->prixUnite = $prixUnite;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }
}

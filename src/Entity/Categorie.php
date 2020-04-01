<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 */
class Categorie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Consommable", mappedBy="categorie", orphanRemoval=true)
     */
    private $consommables;

    public function __construct()
    {
        $this->consommables = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Consommable[]
     */
    public function getConsommables(): Collection
    {
        return $this->consommables;
    }

    public function addConsommable(Consommable $consommable): self
    {
        if (!$this->consommables->contains($consommable)) {
            $this->consommables[] = $consommable;
            $consommable->setCategorie($this);
        }

        return $this;
    }

    public function removeConsommable(Consommable $consommable): self
    {
        if ($this->consommables->contains($consommable)) {
            $this->consommables->removeElement($consommable);
            // set the owning side to null (unless already changed)
            if ($consommable->getCategorie() === $this) {
                $consommable->setCategorie(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_commande = null;

    #[ORM\Column]
    private ?int $id_membre = null;

    #[ORM\Column]
    private ?int $id_vehicule = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_heure_depart = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_heure_fin = null;

    #[ORM\Column(nullable: true)]
    private ?int $prix_total = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_enregistrement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCommande(): ?int
    {
        return $this->id_commande;
    }

    public function setIdCommande(int $id_commande): static
    {
        $this->id_commande = $id_commande;

        return $this;
    }

    public function getIdMembre(): ?int
    {
        return $this->id_membre;
    }

    public function setIdMembre(int $id_membre): static
    {
        $this->id_membre = $id_membre;

        return $this;
    }

    public function getIdVehicule(): ?int
    {
        return $this->id_vehicule;
    }

    public function setIdVehicule(int $id_vehicule): static
    {
        $this->id_vehicule = $id_vehicule;

        return $this;
    }

    public function getDateHeureDepart(): ?\DateTimeInterface
    {
        return $this->date_heure_depart;
    }

    public function setDateHeureDepart(?\DateTimeInterface $date_heure_depart): static
    {
        $this->date_heure_depart = $date_heure_depart;

        return $this;
    }

    public function getDateHeureFin(): ?\DateTimeInterface
    {
        return $this->date_heure_fin;
    }

    public function setDateHeureFin(?\DateTimeInterface $date_heure_fin): static
    {
        $this->date_heure_fin = $date_heure_fin;

        return $this;
    }

    public function getPrixTotal(): ?int
    {
        return $this->prix_total;
    }

    public function setPrixTotal(?int $prix_total): static
    {
        $this->prix_total = $prix_total;

        return $this;
    }

    public function getDateEnregistrement(): ?\DateTimeInterface
    {
        return $this->date_enregistrement;
    }

    public function setDateEnregistrement(?\DateTimeInterface $date_enregistrement): static
    {
        $this->date_enregistrement = $date_enregistrement;

        return $this;
    }
}

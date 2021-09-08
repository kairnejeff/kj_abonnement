<?php

namespace PrestaShop\Module\Abonnement\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Abonnement
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_abonnement;

    /**
     * @var string
     * @ORM\Column(type="string",nullable=true)
     */
    private $id_abonnement_stripe;

    /**
     * @var string
     * @ORM\Column(type="string",nullable=true)
     */
    private $titre;

    /**
     * @var string
     * @ORM\Column(type="string",nullable=true)
     */
    private $sous_titre;

    /**
     * @var float
     * @ORM\Column(type="float",nullable=true)
     */
    private $prix;

    /**
     * @var string
     * @ORM\Column(type="string",nullable=true)
     */
    private $image;

    /**
     * @var string
     * @ORM\Column(type="text",nullable=true)
     */
    private $description;

    /**
     * @return int
     */
    public function getIdAbonnement(): ?int
    {
        return $this->id_abonnement;
    }

    /**
     * @param mixed $id_abonnement
     */
    public function setIdAbonnement($id_abonnement): void
    {
        $this->id_abonnement = $id_abonnement;
    }

    /**
     * @return string
     */
    public function getIdAbonnementStripe(): ?string
    {
        return $this->id_abonnement_stripe;
    }

    /**
     * @param string $id_abonnement_stripe
     */
    public function setIdAbonnementStripe(string $id_abonnement_stripe): void
    {
        $this->id_abonnement_stripe = $id_abonnement_stripe;
    }


    /**
     * @return string
     */
    public function getTitre(): ?string
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }

    /**
     * @return string
     */
    public function getSousTitre(): ?string
    {
        return $this->sous_titre;
    }

    /**
     * @param string $sous_titre
     */
    public function setSousTitre(string $sous_titre): void
    {
        $this->sous_titre = $sous_titre;
    }

    /**
     * @return float
     */
    public function getPrix(): ?float
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix(float $prix): void
    {
        $this->prix = $prix;
    }

    /**
     * @return string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }


    public function toArray(){
        return [
            'id_abonnement'=>$this->getIdAbonnement(),
            'titre'=>$this->getTitre(),
            'sous_titre'=>$this->getSousTitre(),
            'prix'=>$this->getPrix(),
            'image'=>$this->getImage(),
            'description'=>$this->getDescription()
        ];
    }


}
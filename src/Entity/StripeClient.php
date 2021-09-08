<?php


namespace PrestaShop\Module\Abonnement\Entity;


use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class StripeClient
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column( type="integer")
     */
    private $ps_id_client;

    /**
     * @var string
     * @ORM\Column( type="string")
     */
    private $stripe_id_client;

    /**
     * @return int
     */
    public function getPsIdClient(): ?int
    {
        return $this->ps_id_client;
    }

    /**
     * @param int $ps_id_client
     */
    public function setPsIdClient(int $ps_id_client): void
    {
        $this->ps_id_client = $ps_id_client;
    }

    /**
     * @return string
     */
    public function getStripeIdClient(): ?string
    {
        return $this->stripe_id_client;
    }

    /**
     * @param string $stripe_id_client
     */
    public function setStripeIdClient(string $stripe_id_client): void
    {
        $this->stripe_id_client = $stripe_id_client;
    }





}
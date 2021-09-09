<?php


namespace PrestaShop\Module\Abonnement\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="PrestaShop\Module\Abonnement\Repository\ConfigurationStripeRepository")
 */
class ConfigurationStripe
{
    /**
     * @ORM\Id
     * @ORM\Column( type="string")
     */
    private $public_key;

    private $secret_key;

    private $id_group_client;

    /**
     * @return mixed
     */
    public function getPublicKey()
    {
        return $this->public_key;
    }

    /**
     * @param mixed $public_key
     */
    public function setPublicKey($public_key): void
    {
        $this->public_key = $public_key;
    }

    /**
     * @return mixed
     */
    public function getSecretKey()
    {
        return $this->secret_key;
    }

    /**
     * @param mixed $secret_key
     */
    public function setSecretKey($secret_key): void
    {
        $this->secret_key = $secret_key;
    }

    /**
     * @return mixed
     */
    public function getIdGroupClient()
    {
        return $this->id_group_client;
    }

    /**
     * @param mixed $id_group_client
     */
    public function setIdGroupClient($id_group_client): void
    {
        $this->id_group_client = $id_group_client;
    }


}
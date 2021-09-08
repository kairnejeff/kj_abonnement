<?php


namespace PrestaShop\Module\Abonnement\Entity;


class ConfigurationStripe
{
    private $public_key;
    private $secret_key;

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


}
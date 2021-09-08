<?php


namespace PrestaShop\Module\Abonnement\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class AbonneClient
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $id_transaction;

    /**
     * @var int
     * @ORM\Column( type="integer")
     */
    private $ps_id_client;

    /**
     * @var Abonnement
     * @ManyToOne(targetEntity="PrestaShop\Module\Abonnement\Entity\Abonnement")
     * @JoinColumn(name="id_abonnement", referencedColumnName="id_abonnement")
     */
    private $id_abonnement;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $date_start;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $status;

    /**
     * @return int
     */
    public function getPsIdClient(): int
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
     * @return Abonnement
     */
    public function getIdAbonnement(): ?Abonnement
    {
        return $this->id_abonnement;
    }

    /**
     * @param Abonnement $id_abonnement
     */
    public function setIdAbonnement(Abonnement $id_abonnement): void
    {
        $this->id_abonnement = $id_abonnement;
    }

    /**
     * @return string
     */
    public function getIdTransaction(): ?string
    {
        return $this->id_transaction;
    }

    /**
     * @param string $id_transaction
     */
    public function setIdTransaction(string $id_transaction): void
    {
        $this->id_transaction = $id_transaction;
    }

    /**
     * @return \DateTime
     */
    public function getDateStart(): ?\DateTime
    {
        return $this->date_start;
    }

    /**
     * @param \DateTime $date_start
     */
    public function setDateStart(\DateTime $date_start): void
    {
        $this->date_start = $date_start;
    }

    /**
     * @return string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function toArray(){
        return [
            'ps_id_client'=>$this->getPsIdClient(),
            'abonnement'=>$this->getIdAbonnement()->toArray(),
            'id_transaction'=>$this->getIdTransaction(),
            'date_start'=>$this->getDateStart()->format('d/m/Y H:i:s'),
            'status'=>$this->getStatus()
        ];
    }

    public function cancel(){
        $this->setStatus('canceled');
    }

}
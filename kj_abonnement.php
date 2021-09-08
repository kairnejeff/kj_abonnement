<?php


class Kj_Abonnement extends Module
{
    private $db;
    public function __construct()
    {
        $this->name = 'kj_abonnement';
        $this->author = 'Jing';
        $this->version = '1.0.0';
        $this->need_instance = 0;
        $this->bootstrap = true;
        $this->tab = 'others';
        parent::__construct();
        $this->ps_versions_compliancy = array(
            'min' => '1.7',
            'max' => _PS_VERSION_
        );
        $this->displayName = $this->l('Abonnement avec Stripe');
        $this->description = $this->l('Getsion des abonemments avec stripe');
        $this->db = Db::getInstance();
    }

    public function install(){
        if (parent::install() && $this->registerHook('displayCustomerAccount')
        ) {
            $this->createGroupClient();
            return $this->installDatabaseTables();
        }
        return false;
    }

    public function uninstall()
    {
        /* Deletes Module */
        if (parent::uninstall()) {
            return $this->uninstallDatabaseTables();
        }
        return false;
    }

    public function installDatabaseTables(){
        $sql=array();
        $sql[]="CREATE TABLE ". _DB_PREFIX_ . "abonnement (id_abonnement INT AUTO_INCREMENT NOT NULL, id_abonnement_stripe VARCHAR(255) NOT NULL, titre VARCHAR(255) NULL, sous_titre VARCHAR(255) NULL, prix DOUBLE PRECISION NULL, image VARCHAR(255) NULL, description LONGTEXT NULL, PRIMARY KEY(id_abonnement)) DEFAULT CHARACTER SET utf8mb4 ";
        $sql[]="CREATE TABLE ". _DB_PREFIX_ . "stripe_client (ps_id_client INT NOT NULL, stripe_id_client VARCHAR(255) NOT NULL, PRIMARY KEY(ps_id_client)) DEFAULT CHARACTER SET utf8mb4" ;
        $sql[] ="CREATE TABLE ". _DB_PREFIX_ . "abonne_client (id_transaction VARCHAR(255) NOT NULL, ps_id_client INT NOT NULL, id_abonnement INT NOT NULL, date_start DATETIME NOT NULL, status VARCHAR(
            255) NOT NULL, INDEX IDX_6B9CCFE89098E86C (id_transaction), PRIMARY KEY(id_transaction)) DEFAULT CHARACTER SET utf8mb4";

        $this->excuteAllQueries($sql);
        return true;
    }

    public function uninstallDatabaseTables(){
        $sql=array();
        $sql[]="DROP TABLE IF EXISTS ". _DB_PREFIX_ . "abonne_client";
        $sql[]="DROP TABLE IF EXISTS ". _DB_PREFIX_ . "stripe_client";
        $sql[]="DROP TABLE IF EXISTS ". _DB_PREFIX_ . "abonnement";
        $this->excuteAllQueries($sql);
        $this->deleteGroupClient();
        return true;
    }

    public function excuteAllQueries($sql){
        foreach ($sql as $query) {
            if (!$this->db->execute($query)) {
                return false;
            }
        }
    }

    public function getContent()
    {
        Tools::redirectAdmin(
            $this->context->link->getAdminLink('AdminAbonnement')
        );
    }
    public function createGroupClient()
    {
        $group = new Group();
        $group->name = array(Configuration::get('PS_LANG_DEFAULT') => 'abonnement');
        $group->reduction=5.5;
        $group->price_display_method = 1;
        $group->add();
        Configuration::updateValue('KJ_ID_GROUP_ABONNEMENT', $group->id);
    }
    public function deleteGroupClient(){
        $id =  Configuration::getIdByName('KJ_ID_GROUP_ABONNEMENT');
        $group = new Group($id);
        $group->delete();
    }

    public function hookDisplayCustomerAccount(){
        $id_customer= $this->context->customer->id;
        $abonnementClients = $this->get('doctrine.orm.default_entity_manager')->getRepository(\PrestaShop\Module\Abonnement\Entity\AbonneClient::class)->findBy(array('ps_id_client'=> $id_customer));
        if($abonnementClients){
            $myAbonnements=array();
            foreach ($abonnementClients as $abonnementClient){
                if($abonnementClient&& ($abonnementClient->getStatus()=='active')){
                    $myAbonnements[]=$abonnementClient->toArray();
                }
            }
            $this->context->smarty->assign(array(
                'myAbonnements'=> $myAbonnements,
                'link'=>$this->context->link->getModuleLink('kj_abonnement', 'desabonner', array(), true)
            ));
            return $this->display(__FILE__, 'views/templates/front/account-abonnement.tpl');
        }
        return $this->display(__FILE__, 'views/templates/front/no-abonnement.tpl');
    }
}
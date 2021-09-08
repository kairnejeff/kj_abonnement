<?php


class Kj_abonnementAbonnerModuleFrontController extends ModuleFrontController
{
    private $id_abonnement;

    public function init(){
        parent::init();
    }

    public function postProcess(){
        parent::postProcess();
        if(!$this->context->customer->isLogged()){
            Tools::redirect('index.php?controller=authentication?back=my-account');
        }
        if(Tools::getIsset('id_abonnement')){
            $this->id_abonnement=Tools::getValue('id_abonnement');
        }else {
            Tools::redirect($this->context->link->getModuleLink('kj_abonnement', 'showAbonnement', array(), true));
        }
    }

    public function initContent(){
        parent::initContent();
        $this->context->smarty->assign(
            array(
                'id_abonnement' => $this->id_abonnement,
                'link'=>$this->context->link->getModuleLink('kj_abonnement', 'payer', array(), true),
                'public_key'=>Configuration::get('KJ_STRIPE_PUBLIC_KEY')
            ));
        $this->setTemplate('module:kj_abonnement/views/templates/front/abonner.tpl');
    }



}
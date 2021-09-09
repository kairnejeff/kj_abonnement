<?php


class Kj_abonnementShowAbonnementModuleFrontController extends ModuleFrontController
{
    public function initContent(){
        parent::initContent();
        $repository = $this->get('doctrine.orm.default_entity_manager')->getRepository(\PrestaShop\Module\Abonnement\Entity\Abonnement::class);
        $listAbonnement=array();
        $abonnements= $repository->findAll();

        foreach ($abonnements as $abonnement){
            $listAbonnement[]=$abonnement->toArray();
        }
        $this->context->smarty->assign(
            array(
                'abonnements' => $listAbonnement,
                'imgPath'=>Tools::getHttpHost(true).__PS_BASE_URI__.DIRECTORY_SEPARATOR . "modules" .DIRECTORY_SEPARATOR . "kj_abonnement" . DIRECTORY_SEPARATOR . "img". DIRECTORY_SEPARATOR,
                'link'=>$this->context->link->getModuleLink('kj_abonnement', 'abonner', array(), true)
            ));
        $this->setTemplate('module:kj_abonnement/views/templates/front/abonnements.tpl');

    }

}
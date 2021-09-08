<?php


class  Kj_abonnementDesabonnerModuleFrontController extends ModuleFrontController
{
    public function init(){
        parent::init();
    }

    public function postProcess(){
        parent::postProcess();
        if(!$this->context->customer->isLogged()){
            Tools::redirect('index.php?controller=authentication?back=my-account');
        }
        if(Tools::getIsset('id_transaction')){
            $this->id_abonnement=Tools::getValue('id_transaction');
        }else {
            Tools::redirect('index.php?controller=authentication?back=my-account');
        }


    }

    public function initContent(){
        parent::initContent();
        $msg= $this->desabonner(Tools::getValue('id_transaction'));
        $this->context->smarty->assign(
            array(
                'msg' => $msg,
            ));
        $this->setTemplate('module:kj_abonnement/views/templates/front/desabonner.tpl');
    }

    public function desabonner($id_transaction){
        $manager=$this->get('doctrine.orm.default_entity_manager');
        $myAbonnement= $manager->getRepository(\PrestaShop\Module\Abonnement\Entity\AbonneClient::class)
                        ->find($id_transaction);

        $stripe = new \Stripe\StripeClient(Configuration::get('KJ_STRIPE_SECRET_KEY'));
        try {
            $unSubscription=$stripe->subscriptions->cancel(
                $id_transaction,
                []
            );
        }catch(Exception $e) {
            $api_error = $e->getMessage();
        }

        if(empty($api_error) && $unSubscription){
            $subsData = $unSubscription->jsonSerialize();
            if($subsData['status'] == 'canceled'){
                $myAbonnement->setStatus('canceled');
                try{
                    $manager->persist($myAbonnement);
                    $manager->flush();
                    $statusMsg = 'Cancel your subscription has been Successful!';
                }catch (Exception $e) {
                    $statusMsg = "Cancel your subscription failed (DB)!";
                }
            }else{
                $statusMsg = "Cancel your subscription failed (API)!";
            }
        }else{
            $statusMsg = $api_error;
        }

        return $statusMsg;

    }

}
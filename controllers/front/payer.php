<?php

use \PrestaShop\Module\Abonnement\Entity\AbonneClient;
use \PrestaShop\Module\Abonnement\Entity\Abonnement;

class Kj_abonnementPayerModuleFrontController extends ModuleFrontController
{
    private $id_abonnement;
    private $stripeToken;
    private $AbonneClient;

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
        if(Tools::getIsset('stripeToken')){
            $this->stripeToken=Tools::getValue('stripeToken');
        }else {
            //$this->context->cookie->__set('redirect_errors', Tools::displayError('Please complete card information.'));
            Tools::redirect($this->context->link->getModuleLink('kj_abonnement', 'abonner', array(), true));
        }

    }

    public function initContent(){
        parent::initContent();
        $statusMsg=$this->sendRequestStripe();
     //dump($statusMsg); dump($this->AbonneClient); die;
        $this->context->smarty->assign(
            array(
                'msg' => $statusMsg,
                'abonnement'=> $this->AbonneClient->toArray()
            ));
        $this->setTemplate('module:kj_abonnement/views/templates/front/status.tpl');
    }

    public function sendRequestStripe(){
        \Stripe\Stripe::setApiKey(Configuration::get('KJ_STRIPE_SECRET_KEY'));
        $customerId=$this->context->customer->id;
        $manager=$this->get('doctrine.orm.default_entity_manager');
        $abonnement=$manager->getRepository(Abonnement::class)->find($this->id_abonnement);
        try {
            $customer = \Stripe\Customer::create(array(
                'email' => $this->context->customer->email,
                'source'  => $this->stripeToken
            ));
            $strip_id=$customer->id;
        }catch(Exception $e) {
            $api_error = $e->getMessage();
        }
        if(empty($api_error) && $customer){
            try {
                $subscription = \Stripe\Subscription::create([
                'customer' => $strip_id,
                'items' => [[
                    'price' => $abonnement->getIdAbonnementStripe(),
                ]]
            ]);
            }catch(Exception $e) {
                $api_error = $e->getMessage();
            }

            if(empty($api_error) && $subscription){
                $subsData = $subscription->jsonSerialize();
                if($subsData['status'] == 'active'){
                    $subscrID = $subsData['id'];
                    $created = date("d/m/Y:H:i:s", $subsData['created']);
                    $status = $subsData['status'];
                    $AbonneClient = new AbonneClient();
                    $AbonneClient->setIdAbonnement($abonnement);
                    $AbonneClient->setIdTransaction($subscrID);
                    $AbonneClient->setPsIdClient($customerId);
                    $AbonneClient->setDateStart(date_create_from_format('d/m/Y:H:i:s', $created));
                    $AbonneClient->setStatus($status);
                    $this->AbonneClient=$AbonneClient;
                    try{
                        $manager->persist($AbonneClient);
                        $manager->flush();
                        $statusMsg = 'Your Subscription Payment has been Successful!';
                        $this->context->customer->addGroups(array(Configuration::get('KS_ABONNEMENT_ID_GROUP_CLIENT')));
                    }catch (Exception $e) {
                        $statusMsg = "Subscription activation failed!";
                    }
                }else{
                    $statusMsg = "Subscription activation failed!";
                }
            }else{
                 $statusMsg = "Subscription creation failed! ".$api_error;
            }
        }else{
            $statusMsg = "Invalid card details!". $api_error;
        }
        return $statusMsg;
    }

}
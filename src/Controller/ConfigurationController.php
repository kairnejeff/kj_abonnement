<?php


namespace PrestaShop\Module\Abonnement\Controller;


use PrestaShop\Module\Abonnement\Entity\ConfigurationStripe;
use PrestaShop\Module\Abonnement\Form\ConfigurationStripeType;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;

class ConfigurationController extends FrameworkBundleAdminController
{
    public function configurationAction(Request $request)
    {
        $configurtaion = new ConfigurationStripe();
        if($public_key=\Configuration::get('KJ_STRIPE_PUBLIC_KEY')){
            $configurtaion->setPublicKey($public_key);
            $configurtaion->setSecretKey(\Configuration::get('KJ_STRIPE_SECRET_KEY'));
        }
        $form = $this->createForm(ConfigurationStripeType::class, $configurtaion)->handleRequest($request);
        if ($form->isSubmitted()) {
            \Configuration::updateValue('KJ_STRIPE_PUBLIC_KEY',$configurtaion->getPublicKey());
            \Configuration::updateValue('KJ_STRIPE_SECRET_KEY',$configurtaion->getSecretKey());
            return $this->redirectToRoute('kj_abonnement_index');
        }

        return $this->render('@Modules/kj_abonnement/views/templates/admin/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
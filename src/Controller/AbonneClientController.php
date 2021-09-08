<?php


namespace PrestaShop\Module\Abonnement\Controller;


use PrestaShop\Module\Abonnement\Entity\AbonneClient;
use PrestaShop\Module\Abonnement\Grid\Filters\AbonneClientFilter;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;

class AbonneClientController extends FrameworkBundleAdminController
{
    public function indexAction(AbonneClientFilter $abonneClientFilter)
    {
        $abonneclientGridFactory = $this->get('prestashop.module.kj_abonnement.grid.factory.abonneclient');
        $abonneclientGrid = $abonneclientGridFactory->getGrid($abonneClientFilter);
        return $this->render(
            '@Modules/kj_abonnement/views/templates/admin/grid_abonne.html.twig',
            [
                'enableSidebar' => true,
                'layoutTitle' => $this->trans('Abonnement', 'Modules.kj_abonnement.Admin'),
                'itemGrid' => $this->presentGrid($abonneclientGrid),
                'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
            ]
        );
    }
    public function cancelAction(Request $request, $idTransaction){
        $em = $this->get('doctrine.orm.default_entity_manager');
        $abonneClient  = $em->getRepository(AbonneClient::class)->find($idTransaction);
        if($abonneClient->getStatus() !=='canceled'){
            $abonneClient->cancel();
            $em->remove($abonneClient);
            $em->flush();
        }else{
            $this->addFlash('error', $this->trans('it has been canceled.', 'Admin.Notifications.Success'));
        }
        return $this->redirectToRoute('kj_abonnement_abonne');
    }

    private function getToolbarButtons()
    {
        return [
            'abonnement' => [
                'desc' => $this->trans('Liste Abonnement', 'Modules.kj_abonnement.Admin'),
                'icon' => 'add_circle_outline',
                'href' => $this->generateUrl('kj_abonnement_index'),
            ]

        ];
    }
}
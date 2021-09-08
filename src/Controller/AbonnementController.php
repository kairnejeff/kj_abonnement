<?php

namespace PrestaShop\Module\Abonnement\Controller;

use PrestaShop\Module\Abonnement\Entity\Abonnement;
use PrestaShop\Module\Abonnement\Form\AbonnementType;
use PrestaShop\Module\Abonnement\Grid\Filters\AbonnementFilter;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class AbonnementController extends FrameworkBundleAdminController
{
    private $filePath;
    private $em;
    public function __construct($em)
    {
        $this->filePath = _PS_MODULE_DIR_ . "kj_abonnement" . DIRECTORY_SEPARATOR . "img". DIRECTORY_SEPARATOR;
        $this->em=$em;
        parent::__construct();
    }

    public function indexAction(AbonnementFilter $abonnementFilter)
    {
        $abonnementGridFactory = $this->get('prestashop.module.kj_abonnement.grid.factory.abonnement');
        $abonnementGrid = $abonnementGridFactory->getGrid($abonnementFilter);
        return $this->render(
            '@Modules/kj_abonnement/views/templates/admin/index.html.twig',
            [
                'enableSidebar' => true,
                'layoutTitle' => $this->trans('Abonnement', 'Modules.kj_abonnement.Admin'),
                'itemGrid' => $this->presentGrid($abonnementGrid),
                'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
            ]
        );
    }

    public function addAction(Request $request)
    {
        $abonnement = new Abonnement();
        $form = $this->createForm(AbonnementType::class,$abonnement)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            /** @var UploadedFile $file */
            $file = $form->get('image')->getData();
            $fileName=$file->getClientOriginalName();
            if($file){
                try {
                    $file->move(
                        $this->filePath,
                        $fileName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }
            $abonnement->setImage($fileName);
            $this->em->persist($abonnement);
            $this->em->flush();
            return $this->redirectToRoute('kj_abonnement_index');
        }
        return $this->render('@Modules/kj_abonnement/views/templates/admin/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function editAction(Request $request, $idAbonnement){
        $em = $this->get('doctrine.orm.default_entity_manager');
        $abonnement = $em->getRepository(Abonnement::class)->find($idAbonnement);
        //dump($abonnement);die;
        $form = $this->createForm(AbonnementType::class, $abonnement)->handleRequest($request);
        if ($form->isSubmitted()) {
            /** @var UploadedFile $file */
            $file = $form->get('image')->getData();
            $fileName=$file->getClientOriginalName();
            if($fileName!==$abonnement->getImage()){
                @unlink($this->filePath.$abonnement->getImage());
                if($file){
                    try {
                        $file->move(
                            $this->filePath,
                            $fileName
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }
                }
                $abonnement->setImage($fileName);
            }

            $em->persist($abonnement);
            $em->flush();
            return $this->redirectToRoute('kj_abonnement_index');
        }
        return $this->render('@Modules/kj_abonnement/views/templates/admin/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function deleteAction(Request $request, $idAbonnement){
        $em = $this->get('doctrine.orm.default_entity_manager');
        $abonnement  = $em->getRepository(Abonnement::class)->find($idAbonnement);
        @unlink($this->filePath.$abonnement->getImage());
        $em->remove($abonnement);
        $em->flush();
        return $this->redirectToRoute('kj_abonnement_index');
    }


    private function getToolbarButtons()
    {
        return [
            'add_link' => [
                'desc' => $this->trans('Add new abonnement', 'Modules.kj_abonnement.Admin'),
                'icon' => 'add_circle_outline',
                'href' => $this->generateUrl('kj_abonnement_add'),
            ],
            'configuraton' => [
                'desc' => $this->trans('Configuration', 'Modules.kj_abonnement.Admin'),
                'icon' => 'add_circle_outline',
                'href' => $this->generateUrl('kj_abonnement_configuration'),
            ],
            'show_abonne' => [
                'desc' => $this->trans('Liste abonnés', 'Modules.kj_abonnement.Admin'),
                'icon' => 'add_circle_outline',
                'href' => $this->generateUrl('kj_abonnement_abonne'),
            ]


        ];
    }
}
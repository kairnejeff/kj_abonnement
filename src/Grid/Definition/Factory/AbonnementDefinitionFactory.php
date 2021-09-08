<?php

namespace PrestaShop\Module\Abonnement\Grid\Definition\Factory;

use PrestaShop\PrestaShop\Core\Grid\Action\Row\RowActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\Type\LinkRowAction;
use PrestaShop\PrestaShop\Core\Grid\Column\ColumnCollection;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\ActionColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\BulkActionColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\DataColumn;
use PrestaShop\PrestaShop\Core\Grid\Definition\Factory\AbstractGridDefinitionFactory;

class AbonnementDefinitionFactory extends AbstractGridDefinitionFactory
{
    const GRID_ID = 'abonnement';
    protected function getId(){
        return self::GRID_ID;
    }

    protected function getName()
    {
        return $this->trans('Abonnement', [], 'Modules.kj_abonnement.Admin');
    }
    protected function getColumns(){
        return (new ColumnCollection())
            ->add(
                (new BulkActionColumn('delete_abonnement'))
                    ->setOptions([
                        'bulk_field' => 'id_abonnement',
                    ])
            )
            ->add(
                (new DataColumn('id_abonnement'))
                    ->setName('ID')
                    ->setOptions([
                        'field' => 'id_abonnement',
                    ])
            )->add(
                (new DataColumn('titre'))
                    ->setName('Titre')
                    ->setOptions([
                        'field' => 'titre',
                    ])
            )->add((new ActionColumn('actions'))
                ->setName($this->trans('Actions', [], 'Admin.Global'))
                ->setOptions([
                    'actions' => (new RowActionCollection())
                        ->add((new LinkRowAction('edit'))
                            ->setName($this->trans('Edit', [], 'Admin.Actions'))
                            ->setIcon('edit')
                            ->setOptions([
                                'route' => 'kj_abonnement_edit',
                                'route_param_name' => 'idAbonnement',
                                'route_param_field' => 'id_abonnement',
                                'clickable_row' => true,
                            ])
                        )
                        ->add((new LinkRowAction('delete'))
                            ->setName($this->trans('Delete', [], 'Admin.Actions'))
                            ->setIcon('delete')
                            ->setOptions([
                                'route' => 'kj_abonnement_delete',
                                'route_param_name' => 'idAbonnement',
                                'route_param_field' => 'id_abonnement',
                                'clickable_row' => true,
                            ])
                        )
                ])
            );

    }

}
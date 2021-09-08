<?php


namespace PrestaShop\Module\Abonnement\Grid\Definition\Factory;


use PrestaShop\PrestaShop\Core\Grid\Action\GridActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\RowActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\Type\LinkRowAction;
use PrestaShop\PrestaShop\Core\Grid\Action\Type\SimpleGridAction;
use PrestaShop\PrestaShop\Core\Grid\Column\ColumnCollection;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\ActionColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\BulkActionColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\DateTimeColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\LinkColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\DataColumn;
use PrestaShop\PrestaShop\Core\Grid\Definition\Factory\AbstractGridDefinitionFactory;
use PrestaShop\PrestaShop\Core\Grid\Filter\Filter;
use PrestaShop\PrestaShop\Core\Grid\Filter\FilterCollection;
use PrestaShopBundle\Form\Admin\Type\SearchAndResetType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AbonneClientDefinitionFactory extends AbstractGridDefinitionFactory
{
    const GRID_ID = 'abonneClient';
    protected function getId(){
        return self::GRID_ID;
    }

    protected function getName()
    {
        return $this->trans('Abonnés', [], 'Modules.kj_abonnement.Admin');
    }
    protected function getColumns(){
        return (new ColumnCollection())
            ->add(
                (new BulkActionColumn('delete_abonne'))
                    ->setOptions([
                        'bulk_field' => 'id_transaction',
                    ])
            )
            ->add(
                (new DataColumn('id_transaction'))
                    ->setName('ID transaction')
                    ->setOptions([
                        'field' => 'id_transaction',
                    ])
            )->add(
                (new LinkColumn('ps_id_client'))
                    ->setName('Client')
                    ->setOptions([
                        'field' => 'name',
                        'route' => 'admin_customers_view',
                        'route_param_name' => 'customerId',
                        'route_param_field' => 'ps_id_client',
                    ])
            )->add(
                (new DataColumn('id_abonnement'))
                    ->setName('Abonnement')
                    ->setOptions([
                        'field' => 'titre',
                    ])
            )
            ->add(
                (new DateTimeColumn('date_start'))
                    ->setName('Created at')
                    ->setOptions([
                        'field' => 'date_start',
                        'format' => 'd/m/Y H:i:s'
                    ])
            )
            ->add(
                (new DataColumn('status'))
                    ->setName('Status')
                    ->setOptions([
                        'field' => 'status',
                    ])
            )
            ->add((new ActionColumn('actions'))
                ->setName($this->trans('Actions', [], 'Admin.Global'))
                ->setOptions([
                    'actions' => (new RowActionCollection())
                        ->add((new LinkRowAction('cancel'))
                            ->setName($this->trans('Cancel', [], 'Admin.Actions'))
                            ->setIcon('Cancel')
                            ->setOptions([
                                'route' => 'kj_abonnement_abonne_cancel',
                                'route_param_name' => 'idTransaction',
                                'route_param_field' => 'id_transaction',
                                'clickable_row' => true,
                            ])
                        )
                ])
            );

    }
/*    protected function getFilters()
    {
        return (new FilterCollection())
            ->add((new Filter('id_transaction', TextType::class))
                ->setTypeOptions([
                    'required' => false,
                    'attr' => [
                        'placeholder' => $this->trans('ID transaction', [], 'Admin.Global'),
                    ],
                ])
                ->setAssociatedColumn('id_transaction')
            )
            ->add((new Filter('libelle', TextType::class))
                ->setTypeOptions([
                    'required' => false,
                    'attr' => [
                        'placeholder' => $this->trans('libelle', [], 'Modules.Demodoctrine.Admin'),
                    ],
                ])
                ->setAssociatedColumn('libelle')
            )
            ->add((new Filter('url', TextType::class))
                ->setTypeOptions([
                    'required' => false,
                    'attr' => [
                        'placeholder' => $this->trans('url', [], 'Modules.Demodoctrine.Admin'),
                    ],
                ])
                ->setAssociatedColumn('url')
            )
            ->add((new Filter('actions', SearchAndResetType::class))
                ->setTypeOptions([
                    'reset_route' => 'admin_common_reset_search_by_filter_id',
                    'reset_route_params' => [
                        'filterId' => self::GRID_ID,
                    ],
                    'redirect_route' => 'kj_custommenu_link_index',
                ])
                ->setAssociatedColumn('actions')
            )
            ;
    }*/

    /**
     * {@inheritdoc}
     */
    protected function getGridActions()
    {
        return (new GridActionCollection())
            ->add((new SimpleGridAction('common_refresh_list'))
                ->setName($this->trans('Refresh list', [], 'Admin.Advparameters.Feature'))
                ->setIcon('refresh')
            )
            ->add((new SimpleGridAction('common_show_query'))
                ->setName($this->trans('Show SQL query', [], 'Admin.Actions'))
                ->setIcon('code')
            )
            ->add((new SimpleGridAction('common_export_sql_manager'))
                ->setName($this->trans('Export to SQL Manager', [], 'Admin.Actions'))
                ->setIcon('storage')
            )
            ;
    }
}
<?php
namespace PrestaShop\Module\Abonnement\Grid\Filters;

use PrestaShop\PrestaShop\Core\Search\Filters;

class AbonnementFilter extends Filters
{
    /**
     * {@inheritdoc}
     */
    public static function getDefaults()
    {
        return [
            'limit' => 10,
            'offset' => 0,
            'orderBy' => 'id_abonnement',
            'sortOrder' => 'asc',
            'filters' => [],
        ];
    }


}
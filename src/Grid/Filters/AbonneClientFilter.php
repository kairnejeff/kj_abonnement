<?php


namespace PrestaShop\Module\Abonnement\Grid\Filters;


use PrestaShop\PrestaShop\Core\Search\Filters;

class AbonneClientFilter extends Filters
{
    public static function getDefaults()
    {
        return [
            'limit' => 10,
            'offset' => 0,
            'orderBy' => 'date_start',
            'sortOrder' => 'asc',
            'filters' => [],
        ];
    }

}
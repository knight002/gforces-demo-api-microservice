<?php

namespace Vechicle\V1\Rest\Orders;

use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\TableGateway\Feature\RowGatewayFeature;
use Laminas\Hydrator\ArraySerializable;
use Psr\Container\ContainerInterface;

/**
 * Description of OrdersTableGatewayFactory
 *
 * @author lukasz
 */
class OrdersTableGatewayFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new OrdersTableGateway(
            'orders',
            $container->get('pdo_mysql_adapter'),
            null,
            //new RowGatewayFeature('id'),
            $this->getResultSetPrototype($container)
        );
    }

    private function getResultSetPrototype(ContainerInterface $container)
    {
        $hydrators = $container->get('HydratorManager');
        $hydrator = $hydrators->get(ArraySerializable::class);
        return new HydratingResultSet($hydrator, new OrdersEntity());
    }
}

<?php

namespace Vechicle\V1\Rest\Orders;

use Psr\Container\ContainerInterface;

class OrdersResourceFactory
{
    public function __invoke(ContainerInterface $services)
    {
        return new OrdersResource(
            $services->get(OrdersTableGateway::class),
            'id',
            OrdersCollection::class
        );
    }
}

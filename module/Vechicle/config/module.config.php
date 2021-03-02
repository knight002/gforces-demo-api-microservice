<?php
return [
    'service_manager' => [
        'factories' => [
            \Vechicle\V1\Rest\Orders\OrdersResource::class => \Vechicle\V1\Rest\Orders\OrdersResourceFactory::class,
            \Vechicle\V1\Rest\Orders\OrdersTableGateway::class => \Vechicle\V1\Rest\Orders\OrdersTableGatewayFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'vechicle.rest.orders' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/orders[/:orders_id]',
                    'defaults' => [
                        'controller' => 'Vechicle\\V1\\Rest\\Orders\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'vechicle.rest.orders',
        ],
    ],
    'api-tools-rest' => [
        'Vechicle\\V1\\Rest\\Orders\\Controller' => [
            'listener' => \Vechicle\V1\Rest\Orders\OrdersResource::class,
            'route_name' => 'vechicle.rest.orders',
            'route_identifier_name' => 'orders_id',
            'collection_name' => 'orders',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'POST',
            ],
            'collection_http_methods' => [
                0 => 'POST',
                1 => 'GET',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => 'page',
            'entity_class' => \Vechicle\V1\Rest\Orders\OrdersEntity::class,
            'collection_class' => \Vechicle\V1\Rest\Orders\OrdersCollection::class,
            'service_name' => 'orders',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            'Vechicle\\V1\\Rest\\Orders\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'Vechicle\\V1\\Rest\\Orders\\Controller' => [
                0 => 'application/vnd.vechicle.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Vechicle\\V1\\Rest\\Orders\\Controller' => [
                0 => 'application/vnd.vechicle.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'api-tools-hal' => [
        'metadata_map' => [
            \Vechicle\V1\Rest\Orders\OrdersEntity::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'vechicle.rest.orders',
                'route_identifier_name' => 'orders_id',
                'hydrator' => \Laminas\Hydrator\ArraySerializable::class,
            ],
            \Vechicle\V1\Rest\Orders\OrdersCollection::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'vechicle.rest.orders',
                'route_identifier_name' => 'orders_id',
                'is_collection' => true,
            ],
        ],
    ],
    'api-tools-content-validation' => [
        'Vechicle\\V1\\Rest\\Orders\\Controller' => [
            'input_filter' => 'Vechicle\\V1\\Rest\\Orders\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'Vechicle\\V1\\Rest\\Orders\\Validator' => [
            0 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\Regex::class,
                        'options' => [
                            'message' => 'Only digits and dots expected',
                            'pattern' => '/[\\d\\.]{1,10}/',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'total',
                'description' => 'total expected to be a double value',
                'field_type' => 'double',
                'error_message' => 'I expect a double',
            ],
            1 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'model',
            ],
        ],
    ],
];

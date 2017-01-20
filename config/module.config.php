<?php
return [
    'service_manager' => [
        'factories' => [
            \ApigilityVIP\V1\Rest\Status\StatusResource::class => \ApigilityVIP\V1\Rest\Status\StatusResourceFactory::class,
            \ApigilityVIP\V1\Rest\Service\ServiceResource::class => \ApigilityVIP\V1\Rest\Service\ServiceResourceFactory::class,
            \ApigilityVIP\V1\Rest\Contract\ContractResource::class => \ApigilityVIP\V1\Rest\Contract\ContractResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'apigility-vip.rest.status' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/vip/status[/:status_id]',
                    'defaults' => [
                        'controller' => 'ApigilityVIP\\V1\\Rest\\Status\\Controller',
                    ],
                ],
            ],
            'apigility-vip.rest.service' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/vip/service[/:service_id]',
                    'defaults' => [
                        'controller' => 'ApigilityVIP\\V1\\Rest\\Service\\Controller',
                    ],
                ],
            ],
            'apigility-vip.rest.contract' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/vip/contract[/:contract_id]',
                    'defaults' => [
                        'controller' => 'ApigilityVIP\\V1\\Rest\\Contract\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'apigility-vip.rest.status',
            1 => 'apigility-vip.rest.service',
            2 => 'apigility-vip.rest.contract',
        ],
    ],
    'zf-rest' => [
        'ApigilityVIP\\V1\\Rest\\Status\\Controller' => [
            'listener' => \ApigilityVIP\V1\Rest\Status\StatusResource::class,
            'route_name' => 'apigility-vip.rest.status',
            'route_identifier_name' => 'status_id',
            'collection_name' => 'status',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \ApigilityVIP\V1\Rest\Status\StatusEntity::class,
            'collection_class' => \ApigilityVIP\V1\Rest\Status\StatusCollection::class,
            'service_name' => 'Status',
        ],
        'ApigilityVIP\\V1\\Rest\\Service\\Controller' => [
            'listener' => \ApigilityVIP\V1\Rest\Service\ServiceResource::class,
            'route_name' => 'apigility-vip.rest.service',
            'route_identifier_name' => 'service_id',
            'collection_name' => 'service',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \ApigilityVIP\V1\Rest\Service\ServiceEntity::class,
            'collection_class' => \ApigilityVIP\V1\Rest\Service\ServiceCollection::class,
            'service_name' => 'Service',
        ],
        'ApigilityVIP\\V1\\Rest\\Contract\\Controller' => [
            'listener' => \ApigilityVIP\V1\Rest\Contract\ContractResource::class,
            'route_name' => 'apigility-vip.rest.contract',
            'route_identifier_name' => 'contract_id',
            'collection_name' => 'contract',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'user_id',
                1 => 'order_status',
                2 => 'order_id',
            ],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \ApigilityVIP\V1\Rest\Contract\ContractEntity::class,
            'collection_class' => \ApigilityVIP\V1\Rest\Contract\ContractCollection::class,
            'service_name' => 'Contract',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'ApigilityVIP\\V1\\Rest\\Status\\Controller' => 'HalJson',
            'ApigilityVIP\\V1\\Rest\\Service\\Controller' => 'HalJson',
            'ApigilityVIP\\V1\\Rest\\Contract\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'ApigilityVIP\\V1\\Rest\\Status\\Controller' => [
                0 => 'application/vnd.apigility-vip.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'ApigilityVIP\\V1\\Rest\\Service\\Controller' => [
                0 => 'application/vnd.apigility-vip.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'ApigilityVIP\\V1\\Rest\\Contract\\Controller' => [
                0 => 'application/vnd.apigility-vip.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'ApigilityVIP\\V1\\Rest\\Status\\Controller' => [
                0 => 'application/vnd.apigility-vip.v1+json',
                1 => 'application/json',
            ],
            'ApigilityVIP\\V1\\Rest\\Service\\Controller' => [
                0 => 'application/vnd.apigility-vip.v1+json',
                1 => 'application/json',
            ],
            'ApigilityVIP\\V1\\Rest\\Contract\\Controller' => [
                0 => 'application/vnd.apigility-vip.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \ApigilityVIP\V1\Rest\Status\StatusEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-vip.rest.status',
                'route_identifier_name' => 'status_id',
                'hydrator' => \Zend\Hydrator\ClassMethods::class,
            ],
            \ApigilityVIP\V1\Rest\Status\StatusCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-vip.rest.status',
                'route_identifier_name' => 'status_id',
                'is_collection' => true,
            ],
            \ApigilityVIP\V1\Rest\Service\ServiceEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-vip.rest.service',
                'route_identifier_name' => 'service_id',
                'hydrator' => \Zend\Hydrator\ClassMethods::class,
            ],
            \ApigilityVIP\V1\Rest\Service\ServiceCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-vip.rest.service',
                'route_identifier_name' => 'service_id',
                'is_collection' => true,
            ],
            \ApigilityVIP\V1\Rest\Contract\ContractEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-vip.rest.contract',
                'route_identifier_name' => 'contract_id',
                'hydrator' => \Zend\Hydrator\ClassMethods::class,
            ],
            \ApigilityVIP\V1\Rest\Contract\ContractCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-vip.rest.contract',
                'route_identifier_name' => 'contract_id',
                'is_collection' => true,
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'ApigilityVIP\\V1\\Rest\\Contract\\Controller' => [
                'collection' => [
                    'GET' => false,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => true,
                ],
            ],
        ],
    ],
];

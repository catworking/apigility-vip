<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/11/16
 * Time: 14:52
 */
return [
    'service_manager' => array(
        'factories' => array(
            'ApigilityVIP\Service\StatusService' => 'ApigilityVIP\Service\StatusServiceFactory',
            'ApigilityVIP\Service\ServiceService' => 'ApigilityVIP\Service\ServiceServiceFactory',
            'ApigilityVIP\Service\ContractService' => 'ApigilityVIP\Service\ContractServiceFactory',
        ),
    )
];
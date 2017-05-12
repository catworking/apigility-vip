<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/11/7
 * Time: 10:31
 */
return array(
    'doctrine' => array(
        'driver' => array(
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'apigility_vip_annotation_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/DoctrineEntity'
                ),
            ),

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => array(
                'drivers' => array(
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    'ApigilityVIP\DoctrineEntity' => 'apigility_vip_annotation_driver'
                )
            )
        )
    )
);
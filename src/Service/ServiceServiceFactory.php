<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/27
 * Time: 11:31:54
 */
namespace ApigilityVIP\Service;

use Zend\ServiceManager\ServiceManager;

class ServiceServiceFactory
{
    public function __invoke(ServiceManager $services)
    {
        return new ServiceService($services);
    }
}
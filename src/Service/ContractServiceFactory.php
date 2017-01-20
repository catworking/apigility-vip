<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/27
 * Time: 11:32:30
 */
namespace ApigilityVIP\Service;

use Zend\ServiceManager\ServiceManager;

class ContractServiceFactory
{
    public function __invoke(ServiceManager $services)
    {
        return new ContractService($services);
    }
}
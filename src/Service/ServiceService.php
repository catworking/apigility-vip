<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/27
 * Time: 11:31:43
 */
namespace ApigilityVIP\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\Hydrator\ClassMethods as ClassMethodsHydrator;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrineToolPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;
use ApigilityVIP\DoctrineEntity;

class ServiceService
{
    protected $classMethodsHydrator;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var StatusService
     */
    protected $statusService;

    public function __construct(ServiceManager $services)
    {
        $this->classMethodsHydrator = new ClassMethodsHydrator();
        $this->em = $services->get('Doctrine\ORM\EntityManager');
        $this->statusService = $services->get('ApigilityVIP\Service\StatusService');
    }

    /**
     * 创建一个服务
     *
     * @param $data
     * @return DoctrineEntity\Service
     */
    public function createService($data)
    {
        $service = new DoctrineEntity\Service();

        if (isset($data->title)) $service->setTitle($data->title);
        if (isset($data->status_id)) $service->setStatus($this->statusService->getStatus($data->status_id));
        if (isset($data->expire)) $service->setExpire($data->expire);
        if (isset($data->price)) $service->setPrice($data->price);

        $this->em->persist($service);
        $this->em->flush();

        return $service;
    }

    /**
     * 获取一个服务
     *
     * @param $service_id
     * @return DoctrineEntity\Service
     * @throws \Exception
     */
    public function getService($service_id)
    {
        $service = $this->em->find('ApigilityVIP\DoctrineEntity\Service', $service_id);
        if (empty($service)) throw new \Exception('服务不存在', 404);
        else return $service;
    }

    /**
     * 获取服务列表
     *
     * @param $params
     * @return DoctrinePaginatorAdapter
     */
    public function getServices($params)
    {
        $qb = new QueryBuilder($this->em);
        $qb->select('s')->from('ApigilityVIP\DoctrineEntity\Service', 's');

        $doctrine_paginator = new DoctrineToolPaginator($qb->getQuery());
        return new DoctrinePaginatorAdapter($doctrine_paginator);
    }

    /**
     * 修改服务
     *
     * @param $service_id
     * @param $data
     * @return DoctrineEntity\Service
     * @throws \Exception
     */
    public function updateService($service_id, $data)
    {
        $service = $this->getService($service_id);

        if (isset($data->title)) $service->setTitle($data->title);
        if (isset($data->status_id)) $service->setStatus($this->statusService->getStatus($data->status_id));
        if (isset($data->expire)) $service->setExpire($data->expire);
        if (isset($data->price)) $service->setPrice($data->price);

        $this->em->flush();

        return $service;
    }

    /**
     * 删除一个服务
     *
     * @param $service_id
     * @return bool
     * @throws \Exception
     */
    public function deleteService($service_id)
    {
        $service = $this->getService($service_id);

        $this->em->remove($service);
        $this->em->flush();

        return true;
    }
}
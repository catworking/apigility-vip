<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/27
 * Time: 11:31:13
 */
namespace ApigilityVIP\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\Hydrator\ClassMethods as ClassMethodsHydrator;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrineToolPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;
use ApigilityVIP\DoctrineEntity;

class StatusService
{
    protected $classMethodsHydrator;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    public function __construct(ServiceManager $services)
    {
        $this->classMethodsHydrator = new ClassMethodsHydrator();
        $this->em = $services->get('Doctrine\ORM\EntityManager');
    }

    /**
     * 创建一个身份
     *
     * @param $data
     * @return DoctrineEntity\Status
     */
    public function createStatus($data)
    {
        $status = new DoctrineEntity\Status();

        if (isset($data->name)) $status->setName($data->name);

        $this->em->persist($status);
        $this->em->flush();

        return $status;
    }

    /**
     * 获取一个身份
     *
     * @param $status_id
     * @return DoctrineEntity\Status
     * @throws \Exception
     */
    public function getStatus($status_id)
    {
        $status = $this->em->find('ApigilityVIP\DoctrineEntity\Status', $status_id);
        if (empty($status)) throw new \Exception('身份不存在', 404);
        else return $status;
    }

    /**
     * 获取身份列表
     *
     * @param $params
     * @return DoctrinePaginatorAdapter
     */
    public function getStatuses($params)
    {
        $qb = new QueryBuilder($this->em);
        $qb->select('s')->from('ApigilityVIP\DoctrineEntity\Status', 's');

        $doctrine_paginator = new DoctrineToolPaginator($qb->getQuery());
        return new DoctrinePaginatorAdapter($doctrine_paginator);
    }

    /**
     * 修改身份
     *
     * @param $status_id
     * @param $data
     * @return DoctrineEntity\Status
     * @throws \Exception
     */
    public function updateStatus($status_id, $data)
    {
        $status = $this->getStatus($status_id);

        if (isset($data->name)) $status->setName($data->name);

        $this->em->flush();

        return $status;
    }

    /**
     * 删除一个身份
     *
     * @param $status_id
     * @return bool
     * @throws \Exception
     */
    public function deleteStatus($status_id)
    {
        $status = $this->getStatus($status_id);

        $this->em->remove($status);
        $this->em->flush();

        return true;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/27
 * Time: 11:32:19
 */
namespace ApigilityVIP\Service;

use ApigilityCatworkFoundation\Base\ApigilityEventAwareObject;
use ApigilityUser\DoctrineEntity\User;
use Zend\ServiceManager\ServiceManager;
use Zend\Hydrator\ClassMethods as ClassMethodsHydrator;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrineToolPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;
use ApigilityVIP\DoctrineEntity;
use Doctrine\ORM\Query\Expr;

class ContractService extends ApigilityEventAwareObject
{
    const EVENT_CONTRACT_PAYED = 'ContractService.EVENT_CONTRACT_PAYED';

    const BUY_TYPE_ORIGINAL = 1;    //直接购买
    const BUY_TYPE_GROUP = 2;       //拼团购买

    const STATUS_WAIT_TO_PAY = 1;   // 等待付款
    const STATUS_CANCELED = 2;      // 已取消
    const STATUS_PAYED = 3;         // 已支付
    const STATUS_WAIT_TO_SEND = 4;  // 等待发货
    const STATUS_SENT = 5;          // 已发货
    const STATUS_SENT_BACK = 6;     // 货已回发
    const STATUS_FINISH = 7;        // 已完成

    protected $classMethodsHydrator;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var ServiceService
     */
    protected $serviceService;

    /**
     * @var \ApigilityOrder\Service\OrderService
     */
    protected $orderService;

    public function __construct(ServiceManager $services)
    {
        $this->classMethodsHydrator = new ClassMethodsHydrator();
        $this->em = $services->get('Doctrine\ORM\EntityManager');
        $this->serviceService = $services->get('ApigilityVIP\Service\ServiceService');
        $this->orderService = $services->get('ApigilityOrder\Service\OrderService');
        $this->groupService = $services->get('ApigilityGroup\Service\GroupService');
    }

    /**
     * 创建一个合约
     *
     * @param $data
     * @param User $user
     * @return DoctrineEntity\Contract
     * @throws \Exception
     */
    public function createContract($data, User $user)
    {
        $contract = new DoctrineEntity\Contract();

        if (!isset($data->service_id)) throw new \Exception('没有指定的购买的服务', 500);

        $service = $this->serviceService->getService($data->service_id);
        $contract->setService($service);
        $contract->setTitle($service->getTitle());

        $contract->setEffectiveTime(new \DateTime());
        $contract->setExpireTime((new \DateTime())->setTimestamp($contract->getEffectiveTime()->getTimestamp()+$service->getExpire()));
        $contract->setCreateTime(new \DateTime());
        $contract->setUser($user);

        $price = $service->getPrice();
        if (isset($data->price)) {
            $price = $data->price;
        }
        $status = $this::STATUS_WAIT_TO_PAY;

        $service = $this->serviceService->getService($data->service_id);
        $order = $this->orderService->createOrder($service->getTitle(), $user, $status);
        $this->orderService->createOrderDetail(
            $order,
            $service->getTitle(),
            $price,
            1,
            $service->getId(),
            $service->getId()
        );
        $contract->setOrder($order);

        $this->em->persist($contract);
        $this->em->flush();

        return $contract;
    }

    /**
     * 获取一个合约
     *
     * @param $contract_id
     * @return DoctrineEntity\Contract
     * @throws \Exception
     */
    public function getContract($contract_id)
    {
        $contract = $this->em->find('ApigilityVIP\DoctrineEntity\Contract', $contract_id);
        if (empty($contract)) throw new \Exception('合约不存在', 404);
        else return $contract;
    }

    /**
     * 获取合约列表
     *
     * @param $params
     * @return DoctrinePaginatorAdapter
     */
    public function getContracts($params)
    {
        $qb = new QueryBuilder($this->em);
        $qb->select('c')->from('ApigilityVIP\DoctrineEntity\Contract', 'c')->orderBy(new Expr\OrderBy('c.id', 'DESC'));

        $where = '';

        if (isset($params->user_id)) {
            $qb->innerJoin('c.user', 'u');
            if (!empty($where)) $where .= ' AND ';
            $where .= 'u.id = :user_id';
        }

        if (isset($params->order_status)) {
            $qb->innerJoin('c.order', 'o');
            if (!empty($where)) $where .= ' AND ';
            $where .= 'o.status = :order_status';
        }

        if (isset($params->order_id)) {
            $qb->innerJoin('c.order', 'o');
            if (!empty($where)) $where .= ' AND ';
            $where .= 'o.id = :order_id';
        }

        if (isset($params->total)) {
            $qb->innerJoin('c.order', 'o');
            if (!empty($where)) $where .= ' AND ';
            $where .= 'o.total = :total';
        }

        if (!empty($where)) {
            $qb->where($where);
            if (isset($params->user_id)) $qb->setParameter('user_id', $params->user_id);
            if (isset($params->order_status)) $qb->setParameter('order_status', $params->order_status);
            if (isset($params->order_id)) $qb->setParameter('order_id', $params->order_id);
            if (isset($params->total)) $qb->setParameter('total', $params->total);
        }

        $doctrine_paginator = new DoctrineToolPaginator($qb->getQuery());
        return new DoctrinePaginatorAdapter($doctrine_paginator);
    }

    /**
     * @param $order_id
     * @return DoctrineEntity\Contract
     * @throws \Exception
     */
    public function getContractByOrderId($order_id)
    {
        $contracts = $this->getContracts((object)['order_id'=>$order_id]);
        if (!$contracts->count()) throw new \Exception('找不到此合约', 404);

        return $contracts->getItems(0,1)[0];
    }

    /**
     * 修改合约
     *
     * @param $contract_id
     * @param $data
     * @return DoctrineEntity\Contract
     * @throws \Exception
     */
    public function updateContract($contract_id, $data)
    {
        $contract = $this->getContract($contract_id);

        if (isset($data->title)) $contract->setTitle($data->title);
        if (isset($data->effective_time)) {
            $contract->setEffectiveTime((new \DateTime())->setTimestamp($data->effective_time));
            $contract->setExpireTime((new \DateTime())->setTimestamp($contract->getEffectiveTime()->getTimestamp()+$contract->getService()->getExpire()));
        }

        $this->em->flush();

        return $contract;
    }

    /**
     * 删除一个合约
     *
     * @param $contract_id
     * @return bool
     * @throws \Exception
     */
    public function deleteContract($contract_id)
    {
        $contract = $this->getContract($contract_id);

        $this->em->remove($contract);
        $this->em->flush();

        return true;
    }

    public function triggerContractEvent($event_name, $contract_id)
    {
        $this->getEventManager()->trigger($event_name, $this, [
            'contract' => $this->getContract($contract_id)
        ]);
    }

    /**
     * 获取用户的合约
     *
     * @param $user
     * @return DoctrineEntity\Contract
     * @throws \Exception
     */
    public function getContractsByUser(User $user)
    {
        $qb = new QueryBuilder($this->em);
        $qb->select('c')->from('ApigilityVIP\DoctrineEntity\Contract', 'c')->orderBy(new Expr\OrderBy('c.expire_time', 'DESC'));

        $where = '';

        $qb->innerJoin('c.user', 'u');
        $where .= 'u.id = :user_id';

        $qb->innerJoin('c.order', 'o');
        $where .= ' AND o.status = 3';

        $qb->where($where);
        $qb->setParameter('user_id', $user->getId());
        return $qb->getQuery()->getResult();
    }

}
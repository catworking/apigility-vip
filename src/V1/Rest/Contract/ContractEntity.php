<?php
namespace ApigilityVIP\V1\Rest\Contract;

use ApigilityCatworkFoundation\Base\ApigilityObjectStorageAwareEntity;
use ApigilityOrder\DoctrineEntity\Order;
use ApigilityOrder\V1\Rest\Order\OrderEntity;
use ApigilityUser\DoctrineEntity\User;
use ApigilityUser\V1\Rest\User\UserEntity;
use ApigilityVIP\DoctrineEntity\Service;
use ApigilityVIP\V1\Rest\Service\ServiceEntity;

class ContractEntity extends ApigilityObjectStorageAwareEntity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * 合约标题
     *
     * @Column(type="string", length=50, nullable=true)
     */
    protected $title;

    /**
     * 服务
     *
     * @ManyToOne(targetEntity="Service", inversedBy="contracts")
     * @JoinColumn(name="service_id", referencedColumnName="id")
     */
    protected $service;

    /**
     * 生效时间
     *
     * @Column(type="datetime", nullable=false)
     */
    protected $effective_time;

    /**
     * 失效时间
     *
     * @Column(type="datetime", nullable=false)
     */
    protected $expire_time;

    /**
     * 创建时间
     *
     * @Column(type="datetime", nullable=false)
     */
    protected $create_time;

    /**
     * 合约的所属用户，ApigilityUser组件的User对象
     *
     * @ManyToOne(targetEntity="ApigilityUser\DoctrineEntity\User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * 关联的订单
     *
     * @ManyToOne(targetEntity="ApigilityOrder\DoctrineEntity\Order")
     * @JoinColumn(name="order_id", referencedColumnName="id")
     */
    protected $order;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setService($service)
    {
        $this->service = $service;
        return $this;
    }

    public function getService()
    {
        if ($this->service instanceof Service) return $this->hydrator->extract(new ServiceEntity($this->service));
        else return $this->service;
    }

    public function setEffectiveTime($effective_time)
    {
        $this->effective_time = $effective_time;
        return $this;
    }

    public function getEffectiveTime()
    {
        if ($this->effective_time instanceof \DateTime) return $this->effective_time->getTimestamp();
        else return $this->effective_time;
    }

    public function setExpireTime($expire_time)
    {
        $this->expire_time = $expire_time;
        return $this;
    }

    public function getExpireTime()
    {
        if ($this->expire_time instanceof \DateTime) return $this->expire_time->getTimestamp();
        else return $this->expire_time;
    }

    public function setCreateTime($create_time)
    {
        $this->create_time = $create_time;
        return $this;
    }

    public function getCreateTime()
    {
        if ($this->create_time instanceof \DateTime) return $this->create_time->getTimestamp();
        else return $this->create_time;
    }

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    public function getUser()
    {
        if ($this->user instanceof User) return $this->hydrator->extract(new UserEntity($this->user, $this->serviceManager));
        else return $this->user;
    }

    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    public function getOrder()
    {
        if ($this->order instanceof Order) return $this->hydrator->extract(new OrderEntity($this->order, $this->serviceManager));
        else return $this->order;
    }
}

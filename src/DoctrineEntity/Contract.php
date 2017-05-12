<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/27
 * Time: 11:30:47
 */
namespace ApigilityVIP\DoctrineEntity;

use ApigilityUser\DoctrineEntity\User;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Contract
 * @package ApigilityVIP\DoctrineEntity
 * @Entity @Table(name="apigilityvip_contract")
 */
class Contract
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

    /**
     * @return Service
     */
    public function getService()
    {
        return $this->service;
    }

    public function setEffectiveTime($effective_time)
    {
        $this->effective_time = $effective_time;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEffectiveTime()
    {
        return $this->effective_time;
    }

    public function setExpireTime($expire_time)
    {
        $this->expire_time = $expire_time;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpireTime()
    {
        return $this->expire_time;
    }

    public function setCreateTime($create_time)
    {
        $this->create_time = $create_time;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    public function getOrder()
    {
        return $this->order;
    }
}
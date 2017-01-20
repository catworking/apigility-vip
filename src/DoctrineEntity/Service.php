<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/27
 * Time: 11:30:30
 */
namespace ApigilityVIP\DoctrineEntity;

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
 * Class Service
 * @package ApigilityVIP\DoctrineEntity
 * @Entity @Table(name="apigilityvip_service")
 */
class Service
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * 服务标题
     *
     * @Column(type="string", length=50, nullable=true)
     */
    protected $title;

    /**
     * 身份
     *
     * @ManyToOne(targetEntity="Status", inversedBy="services")
     * @JoinColumn(name="status_id", referencedColumnName="id")
     */
    protected $status;

    /**
     * 服务时长，以秒为单位
     *
     * @Column(type="integer", nullable=false)
     */
    protected $expire;

    /**
     * 价格
     *
     * @Column(type="decimal", precision=11, scale=2, nullable=false)
     */
    protected $price;

    /**
     * 此服务的所有合约
     *
     * @OneToMany(targetEntity="Contract", mappedBy="service")
     */
    protected $contracts;

    public function __construct()
    {
        $this->contracts = new ArrayCollection();
    }

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

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function setExpire($expire)
    {
        $this->expire = $expire;
        return $this;
    }

    public function getExpire()
    {
        return $this->expire;
    }

    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setContracts($contracts)
    {
        $this->contracts = $contracts;
        return $this;
    }

    public function getContracts()
    {
        return $this->contracts;
    }
}
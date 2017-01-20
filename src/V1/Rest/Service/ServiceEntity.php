<?php
namespace ApigilityVIP\V1\Rest\Service;

use ApigilityCatworkFoundation\Base\ApigilityEntity;
use ApigilityVIP\DoctrineEntity\Status;
use ApigilityVIP\V1\Rest\Status\StatusEntity;

class ServiceEntity extends ApigilityEntity
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
     * @OneToMany(targetEntity="Contract", mappedBy="services")
     */
    protected $contracts;

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

    public function getStatus()
    {
        if ($this->status instanceof Status) return $this->hydrator->extract(new StatusEntity($this->status));
        else return $this->status;
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
        return $this->contracts->count();
    }
}

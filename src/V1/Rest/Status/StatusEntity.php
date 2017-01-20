<?php
namespace ApigilityVIP\V1\Rest\Status;

use ApigilityCatworkFoundation\Base\ApigilityEntity;

class StatusEntity extends ApigilityEntity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * 身份名称
     *
     * @Column(type="string", length=50, nullable=true)
     */
    protected $name;

    /**
     * 关联到此身份的服务
     *
     * @OneToMany(targetEntity="Service", mappedBy="status")
     */
    protected $services;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setServices($services)
    {
        $this->services = $services;
        return $this;
    }

    public function getServices()
    {
        return $this->services->count();
    }
}

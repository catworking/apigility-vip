<?php
namespace ApigilityVIP\V1\Rest\Service;

use ApigilityCatworkFoundation\Base\ApigilityResource;
use Zend\ServiceManager\ServiceManager;
use ZF\ApiProblem\ApiProblem;

class ServiceResource extends ApigilityResource
{
    /**
     * @var \ApigilityVIP\Service\ServiceService
     */
    protected $serviceService;

    public function __construct(ServiceManager $services)
    {
        parent::__construct($services);
        $this->serviceService = $this->serviceManager->get('ApigilityVIP\Service\ServiceService');
    }

    public function create($data)
    {
        try {
            return new ServiceEntity($this->serviceService->createService($data));
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function fetch($id)
    {
        try {
            return new ServiceEntity($this->serviceService->getService($id));
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function fetchAll($params = [])
    {
        try {
            return new ServiceCollection($this->serviceService->getServices($params));
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function patch($id, $data)
    {
        try {
            return new ServiceEntity($this->serviceService->updateService($id, $data));
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            return $this->serviceService->deleteService($id);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }
}

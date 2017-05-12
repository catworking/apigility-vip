<?php
namespace ApigilityVIP\V1\Rest\Status;

use ApigilityCatworkFoundation\Base\ApigilityResource;
use Zend\ServiceManager\ServiceManager;
use ZF\ApiProblem\ApiProblem;

class StatusResource extends ApigilityResource
{
    /**
     * @var \ApigilityVIP\Service\StatusService
     */
    protected $statusService;

    public function __construct(ServiceManager $services)
    {
        parent::__construct($services);
        $this->statusService = $this->serviceManager->get('ApigilityVIP\Service\StatusService');
    }

    public function create($data)
    {
        try {
            return new StatusEntity($this->statusService->createStatus($data));
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function fetch($id)
    {
        try {
            return new StatusEntity($this->statusService->getStatus($id));
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function fetchAll($params = [])
    {
        try {
            return new StatusCollection($this->statusService->getStatuses($params));
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function patch($id, $data)
    {
        try {
            return new StatusEntity($this->statusService->updateStatus($id, $data));
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            return $this->statusService->deleteStatus($id);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }
}

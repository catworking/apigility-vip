<?php
namespace ApigilityVIP\V1\Rest\Contract;

use ApigilityCatworkFoundation\Base\ApigilityResource;
use Zend\ServiceManager\ServiceManager;
use ZF\ApiProblem\ApiProblem;

class ContractResource extends ApigilityResource
{
    /**
     * @var \ApigilityVIP\Service\ContractService
     */
    protected $contractService;

    /**
     * @var \ApigilityUser\Service\UserService
     */
    protected $userService;

    public function __construct(ServiceManager $services)
    {
        parent::__construct($services);
        $this->contractService = $this->serviceManager->get('ApigilityVIP\Service\ContractService');
        $this->userService = $this->serviceManager->get('ApigilityUser\Service\UserService');
    }

    public function create($data)
    {
        try {
            $auth_user = $this->userService->getAuthUser();
            return new ContractEntity($this->contractService->createContract($data, $auth_user), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function fetch($id)
    {
        try {
            return new ContractEntity($this->contractService->getContract($id), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function fetchAll($params = [])
    {
        try {
            return new ContractCollection($this->contractService->getContracts($params), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function patch($id, $data)
    {
        try {
            return new ContractEntity($this->contractService->updateContract($id, $data), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            return $this->contractService->deleteContract($id);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }
}

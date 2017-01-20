<?php
namespace ApigilityVIP\V1\Rest\Contract;

class ContractResourceFactory
{
    public function __invoke($services)
    {
        return new ContractResource($services);
    }
}

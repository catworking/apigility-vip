<?php
namespace ApigilityVIP\V1\Rest\Status;

class StatusResourceFactory
{
    public function __invoke($services)
    {
        return new StatusResource($services);
    }
}

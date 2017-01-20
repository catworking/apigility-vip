<?php
namespace ApigilityVIP\V1\Rest\Contract;

use ApigilityCatworkFoundation\Base\ApigilityObjectStorageAwareCollection;

class ContractCollection extends ApigilityObjectStorageAwareCollection
{
    protected $itemType = ContractEntity::class;
}

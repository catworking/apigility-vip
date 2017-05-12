<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/15
 * Time: 11:37
 */
namespace ApigilityVIP;

use ApigilityFinance\DoctrineEntity\Ledger;
use ApigilityOrder\Service\PaymentService;
use ApigilityVIP\Service\ContractService;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\EventManager\EventInterface;
use Zend\ServiceManager\ServiceManager;

class ContractListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    private $services;

    /**
     * @var \ApigilityVIP\Service\ContractService
     */
    private $contractService;

    /**
     * @var \ApigilityFinance\Service\LedgerService
     */
    protected $ledgerService;

    public function __construct(ServiceManager $services)
    {
        $this->services = $services;
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(PaymentService::EVENT_PAY_SUCCESS, [$this, 'ContractPayed'], $priority);
    }

    public function ContractPayed(EventInterface $e)
    {
        $params = $e->getParams();
        $order = $params['order'];

        $this->ledgerService = $this->services->get('ApigilityFinance\Service\LedgerService');

        // 处理财务记账
        $this->ledgerService->createLedger((object)[
            'account' => 'vip_contract_income',
            'amount'  => $order->getTotal(),
            'amount_type' => Ledger::AMOUNT_TYPE_DEBIT
        ]);

        $this->contractService = $this->services->get('ApigilityVIP\Service\ContractService');
        $contract = $this->contractService->getContractByOrderId($order->getId());

        // 更新生效时间
        $this->contractService->updateContract($contract->getId(), (object)[
            'effective_time'=>(new \DateTime())->getTimestamp()
        ]);

        // 触发合约支付完成事件
        $this->contractService->triggerContractEvent(ContractService::EVENT_CONTRACT_PAYED, $contract->getId());
    }
}
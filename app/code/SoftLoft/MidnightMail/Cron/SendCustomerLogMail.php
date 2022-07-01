<?php
declare(strict_types=1);

namespace SoftLoft\MidnightMail\Cron;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Mail\TransportInterfaceFactory;
use SoftLoft\MidnightMail\Model\ResourceModel\ConnectionCollection\CollectionFactory;
use SoftLoft\MidnightMail\Api\ConfigInterface;
use SoftLoft\MidnightMail\Api\CustomerConnectionRepositoryInterface;
use Magento\Framework\App\Area;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Send email with portion of customer logs
 */
class SendCustomerLogMail
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @var CustomerConnectionRepositoryInterface
     */
    private $connectionRepository;

    /**
     * @var TransportBuilder
     */
    private $transportBuilder;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var StateInterface
     */
    private $inlineTranslation;

    /**
     * @param CollectionFactory $collectionFactory
     * @param ConfigInterface $config
     * @param TransportInterfaceFactory $transportFactory
     * @param TransportBuilder $transportBuilder
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param StateInterface $state
     * @param CustomerConnectionRepositoryInterface $connectionRepository
     */
    public function __construct(
        CollectionFactory                     $collectionFactory,
        ConfigInterface                       $config,
        TransportBuilder                      $transportBuilder,
        ScopeConfigInterface                  $scopeConfig,
        StoreManagerInterface                 $storeManager,
        StateInterface                        $state,
        CustomerConnectionRepositoryInterface $connectionRepository
    ) {
        $this->config = $config;
        $this->connectionRepository = $connectionRepository;
        $this->collectionFactory = $collectionFactory;
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->inlineTranslation = $state;
    }

    /**
     * If functional enabled send email with connections
     *
     * @return void
     * @throws MailException
     */
    public function execute(): void
    {
        if ($this->config->mailTrackedIsEnabled()) {
            $storeId = $this->storeManager->getStore()->getId();

            $this->inlineTranslation->suspend();
            $emailTempVariables['$items'] = $this->prepareSendString();


            $templateOptions = [
                'area' => Area::AREA_ADMINHTML,
                'store' => $storeId
            ];

            $transport = $this->transportBuilder->setTemplateIdentifier('test_task_id')
                ->setTemplateOptions($templateOptions)
                ->setTemplateVars($emailTempVariables)
                ->setFrom(['email' => $this->getCustomerSupportEmail(), 'name' => 'Admin'])
                ->addTo($this->config->getMailRecepientEmail())
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        }
    }

    /**
     * Prepare array with data for email
     *
     * @return array
     * @throws CouldNotSaveException
     */
    private function prepareSendData(): array
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('mail_send', 0);
        $data = [];

        foreach ($collection->getItems() as $logEntity) {
            $data[] = $logEntity->getData();
            $logEntity->setMailSend();
            $this->connectionRepository->save($logEntity);
        }

        return $data;
    }

    /**
     * Transform data array to message text
     *
     * @return string
     */
    private function prepareSendString(): string
    {
        $result = '';
        $sendData = $this->prepareSendData();

        foreach ($sendData as $log) {
            $result .= sprintf(
                'log - %s customer with id - %s and IP address - %s lodded at - %s' . PHP_EOL,
                $log['log_id'],
                $log['customer_id'],
                $log['customer_ip'],
                $log['created_at']);
        }

        if (empty($result)) {
            $result = 'New connections is absent';
        }

        return $result;
    }

    /**
     * Get customer support email
     *
     * @return string
     */
    private function getCustomerSupportEmail(): string
    {
        return $this->scopeConfig->getValue(
            'trans_email/ident_support/email', ScopeInterface::SCOPE_STORE
        );
    }
}

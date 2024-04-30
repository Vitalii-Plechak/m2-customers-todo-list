<?php

declare(strict_types=1);

namespace VPT\Todo\Ui\Columns;

use Exception;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class TaskCustomerColumn extends Column
{
    /**
     * @param CustomerRepositoryInterface $customerRepository
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')] = $this->prepareItem($item);
            }
        }

        return $dataSource;
    }

    /**
     * @param array $item
     * @return string
     */
    private function prepareItem(array $item) {
        try {
            $customer = $this->customerRepository->getById((int) $item['customer_id']);
            return $customer->getFirstname() . ' ' . $customer->getLastname();
        } catch (Exception $e) {
            return 'N/A';
        }
    }
}
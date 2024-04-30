<?php

declare(strict_types=1);

namespace VPT\Todo\Service;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use VPT\Todo\Api\CustomerTaskListInterface;
use VPT\Todo\Api\Data\TaskInterface;
use VPT\Todo\Api\TaskRepositoryInterface;

/**
 * Implementation of '\VPT\Todo\Api\CustomerTaskListInterface'
 */
class CustomerTaskList implements CustomerTaskListInterface
{
    /**
     * @param TaskRepositoryInterface $taskRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterBuilder $filterBuilder
     */
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository,
        private readonly SearchCriteriaBuilder $searchCriteriaBuilder,
        private readonly FilterBuilder $filterBuilder
    ) {}

    /**
     * @param $customerId
     * @return TaskInterface[]
     */
    public function getList($customerId)
    {
        $this->searchCriteriaBuilder->addFilter(
            $this->filterBuilder->create()
                ->setField('customer_id')
                ->setValue($customerId)
        );

        $searchCriteria = $this->searchCriteriaBuilder->create();

        return $this->taskRepository
            ->getList($searchCriteria)
            ->getItems();
    }
}
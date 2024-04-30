<?php

declare(strict_types=1);

namespace VPT\Todo\Service;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use VPT\Todo\Api\CustomerTaskStatusManagement;
use VPT\Todo\Api\TaskManagementInterface;
use VPT\Todo\Api\TaskRepositoryInterface;
use VPT\Todo\Model\Task;

class TaskStatusManagement implements CustomerTaskStatusManagement
{
    /**
     * @param TaskRepositoryInterface $repository
     * @param TaskManagementInterface $management
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterBuilder $filterBuilder
     */
    public function __construct(
        private readonly TaskRepositoryInterface $repository,
        private readonly TaskManagementInterface $management,
        private readonly SearchCriteriaBuilder $searchCriteriaBuilder,
        private readonly FilterBuilder $filterBuilder
    ) {}

    /**
     * @param int $customerId
     * @param int $taskId
     * @param string $status
     * @return bool
     */
    public function change(int $customerId, int $taskId, string $status): bool
    {
        if (!in_array($status, ['open', 'complete'])) {
            return false;
        }

        $task = $this->repository->get($taskId);
        $task->setData(Task::STATUS, $status);

        $this->management->save($customerId, $task);

        return true;
    }

    public function completeAll(int $customerId): bool
    {
        $this->searchCriteriaBuilder->addFilter(
            $this->filterBuilder->create()
                ->setField('customer_id')
                ->setValue($customerId)
        );

        $searchCriteria = $this->searchCriteriaBuilder->create();

        $taskList = $this->repository->getList($searchCriteria);

        foreach ($taskList as $task) {
            $task->setData(Task::STATUS, 'complete');

            $this->management->save($customerId, $task);
        }

        return true;
    }
}
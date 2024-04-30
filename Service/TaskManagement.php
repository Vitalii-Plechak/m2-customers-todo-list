<?php

declare(strict_types=1);

namespace VPT\Todo\Service;

use Exception;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\Exception\AlreadyExistsException;
use VPT\Todo\Api\Data\TaskInterface;
use VPT\Todo\Api\TaskManagementInterface;
use VPT\Todo\Model\ResourceModel\Task;
use VPT\Todo\Api\TaskRepositoryInterface;

class TaskManagement implements TaskManagementInterface
{
    /**
     * @param Task $resource
     * @param TaskRepository $taskRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterBuilder $filterBuilder
     */
    public function __construct(
        private readonly Task $resource,
        private readonly TaskRepository $taskRepository,
        private readonly SearchCriteriaBuilder $searchCriteriaBuilder,
        private readonly FilterBuilder $filterBuilder
    ) {}

    /**
     * @param int $customerId
     * @param TaskInterface $task
     * @return int
     * @throws AlreadyExistsException
     */
    public function save(int $customerId, TaskInterface $task): int
    {
        $task->setData('customer_id', $customerId);

        $this->resource->save($task);
        return $task->getTaskId();
    }

    /**
     * @param int $customerId
     * @param TaskInterface $task
     * @return bool
     * @throws Exception
     */
    public function delete(int $customerId, TaskInterface $task): bool
    {
        $this->resource->delete($task);
        return true;
    }

    /**
     * @param int $customerId
     * @return bool
     * @throws Exception
     */
    public function deleteAll(int $customerId): bool
    {
        $this->searchCriteriaBuilder->addFilter(
            $this->filterBuilder->create()
                ->setField('customer_id')
                ->setValue($customerId)
        );

        $searchCriteria = $this->searchCriteriaBuilder->create();

        $taskList = $this->taskRepository->getList($searchCriteria);

        foreach ($taskList as $task) {
            $this->resource->delete($task);
        }

        return true;
    }

    /**
     * @param int $customerId
     * @return bool
     * @throws Exception
     */
    public function deleteCompleted(int $customerId): bool
    {
        $this->searchCriteriaBuilder->addFilter(
            $this->filterBuilder->create()
                ->setField('status')
                ->setValue('complete')
        );

        $this->searchCriteriaBuilder->addFilter(
            $this->filterBuilder->create()
                ->setField('customer_id')
                ->setValue($customerId)
        );

        $searchCriteria = $this->searchCriteriaBuilder->create();

        $taskList = $this->taskRepository->getList($searchCriteria);

        foreach ($taskList as $task) {
            if (intval($task->getCustomerId()) === $customerId) {
                $this->resource->delete($task);
            }
        }

        return true;
    }
}
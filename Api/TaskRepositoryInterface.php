<?php

namespace VPT\Todo\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use VPT\Todo\Api\Data\TaskInterface;
use VPT\Todo\Api\Data\TaskSearchResultInterface;

/**
 * Responsible for a query and retrieval operations.
 *
 * @api
 */
interface TaskRepositoryInterface
{
    /**
     * Get List
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return TaskSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): TaskSearchResultInterface;

    /**
     * Get
     *
     * @param int $taskId
     * @return TaskInterface
     */
    public function get(int $taskId): TaskInterface;
}
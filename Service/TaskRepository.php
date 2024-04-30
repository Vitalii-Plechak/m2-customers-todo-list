<?php

declare(strict_types=1);

namespace VPT\Todo\Service;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use VPT\Todo\Api\Data\TaskInterface;
use VPT\Todo\Api\Data\TaskSearchResultInterface;
use VPT\Todo\Api\Data\TaskSearchResultInterfaceFactory;
use VPT\Todo\Api\TaskRepositoryInterface;
use VPT\Todo\Model\ResourceModel\Task;
use VPT\Todo\Model\TaskFactory;
use Magento\Framework\Api\SearchCriteriaInterface;

class TaskRepository implements TaskRepositoryInterface
{
    /**
     * @param Task $resource
     * @param TaskFactory $taskFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param TaskSearchResultInterfaceFactory $searchResultFactory
     */
    public function __construct(
        private readonly Task $resource,
        private readonly TaskFactory $taskFactory,
        private readonly CollectionProcessorInterface $collectionProcessor,
        private readonly TaskSearchResultInterfaceFactory $searchResultFactory
    ) {}

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return TaskSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): TaskSearchResultInterface
    {
        /** Created an instance of search result */
        $searchResult = $this->searchResultFactory->create();

        /** Created search criteria */
        $searchResult->setSearchCriteria($searchCriteria);

        /**
         * Used to process our search criteria and search result.
         * The idea of collectionProcessor method that it will loop through all available collection processors
         * and will call all different collection methods, what located in the collection '\VPT\Todo\Model\ResourceModel\Task\Collection'.
         * Used $searchCriteria and $searchResult in order to prepare collection and assign back to the $searchResult.
         * As a result we will get an Instance of 'VPT\Todo\Api\Data\TaskSearchResultInterface' when we can use getList method.
         */
        $this->collectionProcessor->process($searchCriteria, $searchResult);

        return $searchResult;
    }

    /**
     * Return required data from database table according to the ID
     *
     * @param int $taskId
     * @return TaskInterface
     */
    public function get(int $taskId): TaskInterface
    {
        /** Responsible for creating new empty object */
        $object = $this->taskFactory->create();

        $this->resource->load($object, $taskId);

        return $object;
    }
}
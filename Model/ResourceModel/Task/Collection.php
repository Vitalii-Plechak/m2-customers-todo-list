<?php

declare(strict_types=1);

namespace VPT\Todo\Model\ResourceModel\Task;

use Exception;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use VPT\Todo\Api\Data\TaskSearchResultInterface;
use VPT\Todo\Model\Task;
use VPT\Todo\Model\ResourceModel\Task as TaskResource;
use Magento\Framework\Api\SearchCriteriaInterface;

class Collection extends AbstractCollection implements TaskSearchResultInterface
{
    /**
     * @var SearchCriteriaInterface
     */
    private $searchCriteria;

    protected function _construct()
    {
        $this->_init(Task::class, TaskResource::class);
    }

    /**
     * Get search result
     *
     * @return SearchCriteriaInterface|null
     */
    public function getSearchCriteria()
    {
        return $this->searchCriteria;
    }

    /**
     * Set search criteria
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return Collection
     */
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria)
    {
        $this->searchCriteria = $searchCriteria;

        return $this;
    }

    /**
     * Get total count
     *
     * @return int
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }

    /**
     * Set total count
     *
     * @param int $totalCount
     * @return $this
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

    /**
     * Implemented search result interface as part of a task collection class
     *
     * @param array|null $items
     * @return $this
     * @throws Exception
     */
    public function setItems(array $items = null)
    {
        if (!$items) {
            return $this;
        }

        foreach ($items as $item) {
            $this->addItem($item);
        }

        return $this;
    }
}
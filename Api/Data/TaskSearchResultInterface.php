<?php

declare(strict_types=1);

namespace VPT\Todo\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * This interface returned a result of our search results collection.
 * Interface used in TaskRepositoryInterface for getList method.
 *
 * @api
 */
interface TaskSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return TaskInterface[]
     */
    public function getItems();

    /**
     * @param TaskInterface[] $items
     * @return SearchResultsInterface
     */
    public function setItems(array $items);
}
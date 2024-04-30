<?php

declare(strict_types=1);

namespace VPT\Todo\Api;

use VPT\Todo\Api\Data\TaskInterface;

/**
 * @api
 */
interface CustomerTaskListInterface
{
    /**
     * @param int $customerId
     * @return TaskInterface[]
     */
    public function getList(int $customerId);
}
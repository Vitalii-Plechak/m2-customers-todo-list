<?php

namespace VPT\Todo\Api;

/**
 * @api
 */
interface CustomerTaskStatusManagement
{
    /**
     * @param int $customerId
     * @param int $taskId
     * @param string $status
     * @return bool
     */
    public function change(int $customerId,int $taskId, string $status): bool;

    /**
     * @param int $customerId
     * @return bool
     */
    public function completeAll(int $customerId): bool;
}
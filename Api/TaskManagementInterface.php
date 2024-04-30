<?php

namespace VPT\Todo\Api;

use VPT\Todo\Api\Data\TaskInterface;

/**
 * Allowed providing public methods that are going to be used to performed save and delete or modification operations.
 *
 * @api
 */
interface TaskManagementInterface
{
    /**
     * Save Task
     *
     * @param int $customerId
     * @param TaskInterface $task
     * @return int
     */
    public function save(int $customerId, TaskInterface $task): int;

    /**
     * Delete Task
     *
     * @param int $customerId
     * @param TaskInterface $task
     * @return bool
     */
    public function delete(int $customerId, TaskInterface $task): bool;

    /**
     * @param int $customerId
     * @return bool
     */
    public function deleteAll(int $customerId): bool;

    /**
     * @param int $customerId
     * @return bool
     */
    public function deleteCompleted(int $customerId): bool;
}
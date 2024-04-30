<?php

declare(strict_types=1);

namespace VPT\Todo\Api\Data;

/**
 * This is representation of our task.
 *
 * @api
 */
interface TaskInterface
{
    /**
     * @return int
     */
    public function getTaskId(): int;

    /**
     * @return string
     */
    public function getStatus(): string;

    /**
     * @return string
     */
    public function getLabel(): string;

    /**
     * @return string
     */
    public function getCustomerId(): string;

    /**
     * @param int $taskId
     * @return void
     */
    public function setTaskId(int $taskId);

    /**
     * @param string $status
     * @return void
     */
    public function setStatus(string $status);

    /**
     * @param string $label
     * @return void
     */
    public function setLabel(string $label);

    /**
     * @param string $customerId
     * @return void
     */
    public function setCustomerId(string $customerId);
}
<?php

declare(strict_types=1);

namespace VPT\Todo\Model;

use Magento\Framework\Model\AbstractModel;
use VPT\Todo\Api\Data\TaskInterface;
use VPT\Todo\Model\ResourceModel\Task as TaskResource;

class Task extends AbstractModel implements TaskInterface
{
    const TASK_ID = 'task_id';
    const STATUS = 'status';
    const LABEL = 'label';
    const CUSTOMER_ID = 'customer_id';

    protected function _construct()
    {
        $this->_init(TaskResource::class);
    }

    /**
     * @return int
     */
    public function getTaskId(): int
    {
        return (int) $this->getData(self::TASK_ID);
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->getData(self::LABEL);
    }

    /**
     * @return string
     */
    public function getCustomerId(): string
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * @param int $taskId
     * @return void
     */
    public function setTaskId(int $taskId)
    {
        $this->setData(self::TASK_ID, $taskId);
    }

    /**
     * @param string $status
     * @return void
     */
    public function setStatus(string $status)
    {
        $this->setData(self::STATUS, $status);
    }

    /**
     * @param string $label
     * @return void
     */
    public function setLabel(string $label)
    {
        $this->setData(self::LABEL, $label);
    }

    /**
     * @param string $customerId
     * @return void
     */
    public function setCustomerId(string $customerId)
    {
        $this->setData(self::CUSTOMER_ID, $customerId);
    }
}
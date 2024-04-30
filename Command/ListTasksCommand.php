<?php

declare(strict_types=1);

namespace VPT\Todo\Command;

use Magento\Framework\Api\FilterBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\Console\Cli;
use VPT\Todo\Api\Data\TaskSearchResultInterface;
use VPT\Todo\Api\TaskRepositoryInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;

/**
 * Output list of tasks by required criteria
 */
class ListTasksCommand extends Command
{
    /** Command Name */
    const NAME = 'vpt:todo:task-list';

    /** Option name by Customer ID */
    const CUSTOMER_ID = 'customer_id';

    /** Option name by Task ID */
    const TASK_ID = 'task_id';

    /** Option name by Task Status */
    const TASK_STATUS = 'status';

    /** Option name by Task Label */
    const TASK_LABEL = 'label';

    /**
     * @param TaskRepositoryInterface $taskRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterBuilder $filterBuilder
     * @param string|null $name
     */
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository,
        private readonly SearchCriteriaBuilder $searchCriteriaBuilder,
        private readonly FilterBuilder $filterBuilder,
        string $name = null
    ) {
        parent::__construct($name);
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName(self::NAME)
            ->setDescription('Provides a list of tasks');

        $this->addOption(
            self::CUSTOMER_ID,
            'c',
            InputOption::VALUE_REQUIRED,
            'Search by Customer ID'
        )->addOption(
            self::TASK_ID,
            't',
            InputOption::VALUE_REQUIRED,
            'Search by Task ID'
        )->addOption(
            self::TASK_STATUS,
            's',
            InputOption::VALUE_REQUIRED,
            'Search by Task Status'
        )->addOption(
            self::TASK_LABEL,
            'l',
            InputOption::VALUE_REQUIRED,
            'Search by Task Label'
        );

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $tasksSearchResultCount = $this->taskRepository->getList($this->searchCriteriaBuilder->create())->getTotalCount();

        if ($tasksSearchResultCount > 0) {
            $foreachIteration = 0;

            if ($customerId = $input->getOption(self::CUSTOMER_ID)) {
                $tasksSearchResult = $this->TasksSearchResultForExecute(self::CUSTOMER_ID, $customerId);

                $this->ForeachIterationForExecute($foreachIteration, $output, $tasksSearchResult);
            } else if ($taskId = $input->getOption(self::TASK_ID)) {
                $tasksSearchResult = $this->TasksSearchResultForExecute(self::TASK_ID, $taskId);

                $this->ForeachIterationForExecute($foreachIteration, $output, $tasksSearchResult);
            } else if ($taskStatus = $input->getOption(self::TASK_STATUS)) {
                $tasksSearchResult = $this->TasksSearchResultForExecute(self::TASK_STATUS, $taskStatus);

                $this->ForeachIterationForExecute($foreachIteration, $output, $tasksSearchResult);
            } else if ($taskLabel = $input->getOption(self::TASK_LABEL)) {
                $tasksSearchResult = $this->TasksSearchResultForExecute(self::TASK_LABEL, $taskLabel);

                $this->ForeachIterationForExecute($foreachIteration, $output, $tasksSearchResult);
            } else {
                $tasksSearchResult = $this->taskRepository->getList($this->searchCriteriaBuilder->create());

                $this->ForeachIterationForExecute($foreachIteration, $output, $tasksSearchResult);
            }
        } else {
            $output->writeln('<error> Tasks have not been created yet </error>');
        }

        return Cli::RETURN_SUCCESS;
    }

    /**
     * Console output execution result
     *
     * @param $foreachIteration
     * @param $output
     * @param $tasksSearchResult
     * @return void
     */
    private function ForeachIterationForExecute ($foreachIteration, $output, $tasksSearchResult) {
        if ($tasksSearchResult->getTotalCount() > 0) {
            foreach ($tasksSearchResult as $task) {
                $foreachIteration += 1;

                ($foreachIteration == 1) ? $output->writeln('') : null;

                $output->writeln(
                    '<info> | <comment>Customer ID: </comment>' . $task->getCustomerId() .
                    ' | <comment>Task ID: </comment>' . $task->getTaskId() .
                    ' | <comment>Task Status: </comment>' . '(' . $task->getStatus() . ')' .
                    ' | <comment>Task Label: </comment>' . $task->getLabel() . '</info>'
                );

                ($foreachIteration !== $tasksSearchResult->getTotalCount()) ? $output->writeln('') : null;
                ($foreachIteration == $tasksSearchResult->getTotalCount()) ? $output->writeln('') : null;
            }
        } else {
            $output->writeln('<error> There are no record found for your search result </error>');
        }
    }

    /**
     * Tasks Search Result by Search Criteria
     *
     * @param $value
     * @param $fieldName
     * @return TaskSearchResultInterface
     */
    private function TasksSearchResultForExecute ($value, $fieldName) {
        $this->searchCriteriaBuilder->addFilter(
            $this->filterBuilder->create()
                ->setField($value)
                ->setValue($fieldName)
        );

        $searchCriteria = $this->searchCriteriaBuilder->create();

        return $this->taskRepository->getList($searchCriteria);
    }
}
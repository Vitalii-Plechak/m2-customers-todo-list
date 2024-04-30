<?php

declare(strict_types=1);

namespace VPT\Todo\Command;

use Magento\Framework\Api\FilterBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Magento\Framework\Console\Cli;
use VPT\Todo\Api\TaskRepositoryInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;

/**
 * Output total count of tasks by required criteria
 */
class TasksCountCommand extends Command
{
    /** Command Name */
    const NAME = 'vpt:todo:task-list-count';

    /** Option name by Customer ID */
    const CUSTOMER_ID_OPTION_NAME = 'customer_id';

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
            ->setDescription('Provides the total number of tasks');

        $this->addOption(
            self::CUSTOMER_ID_OPTION_NAME,
            'c',
            InputOption::VALUE_REQUIRED,
            'Customer ID'
        );

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return null|int
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        if ($customerId = $input->getOption(self::CUSTOMER_ID_OPTION_NAME)) {
            $this->searchCriteriaBuilder->addFilter(
                $this->filterBuilder->create()
                    ->setField('customer_id')
                    ->setValue($customerId)
            );

            $searchCriteria = $this->searchCriteriaBuilder->create();

            $totalCount = $this->taskRepository->getList($searchCriteria)->getTotalCount();

            $output->writeln(
                '<comment>The total number of tasks for customer with ID ' . $customerId . ' is </comment>' .
                '<info>' . $totalCount . '</info>'
            );
        } else {
            $tasksSearchResultCount = $this->taskRepository->getList($this->searchCriteriaBuilder->create())->getTotalCount();

            $output->writeln(
                '<comment>The total number of tasks: ' . '</comment>' .
                '<info>' .  $tasksSearchResultCount  . '</info>'
            );
        }

        return Cli::RETURN_SUCCESS;
    }
}
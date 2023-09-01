<?php

namespace App\Command;

use App\OrderExport\OrderExportInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OrderExport extends Command
{
    private OrderExportInterface $orderExport;

    public function __construct(OrderExportInterface $orderExport)
    {
        $this->orderExport = $orderExport;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('order:export')
            ->setDescription('Export orders to CSV');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->orderExport->exportOrders();
        return 0;
    }
}
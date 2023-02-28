<?php

declare(strict_types=1);

namespace DrinkMachine\Infrastructure\Ui\Console;

use DrinkMachine\Application\Handler\DrinkMakerHandler;
use DrinkMachine\Application\Query\DrinkMakerQuery;
use DrinkMachine\Domain\Entities\Chocolate;
use DrinkMachine\Domain\Entities\Coffee;
use DrinkMachine\Domain\Entities\OrangeJuice;
use DrinkMachine\Domain\Entities\Tea;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Webmozart\Assert\Assert;

#[AsCommand(name: 'drink:maker')]
class DrinkMachineCommand extends Command
{
    private const OPTIONS = [
        'T' => Tea::NAME,
        'H' => Chocolate::NAME,
        'C' => Coffee::NAME,
        'O' => OrangeJuice::NAME,
        'M' => 'message',
    ];
    private const MONEY_ARGUMENT = 'money';
    private const ORDER_ARGUMENT = 'order';
    private const EXTRA_HOT_OPTION = 'extra-hot';

    public function __construct(
        private readonly DrinkMakerHandler $handler
    ) {
        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->setName(self::ORDER_ARGUMENT)
            ->addArgument(
                self::ORDER_ARGUMENT,
                InputArgument::REQUIRED,
                'Order to the Drink Machine'
            )
            ->setDescription('Order to the Drink Machine');

        $this
            ->setName(self::MONEY_ARGUMENT)
            ->addArgument(
                self::MONEY_ARGUMENT,
                InputArgument::OPTIONAL,
                'Money inserted into the Drink Machine'
            )
            ->setDescription('Money inserted into the Drink Machine');

        $this->setName('extraHot')
            ->addOption(
                self::EXTRA_HOT_OPTION,
                'eh',
                InputOption::VALUE_OPTIONAL,
                'Extra hot drink',
                false
            )
            ->setDescription('Extra hot drink');
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        /** @var string $rawMoney */
        $rawMoney = $input->getArgument(self::MONEY_ARGUMENT);
        /** @var string $rawOrder */
        $rawOrder = $input->getArgument(self::ORDER_ARGUMENT);
        $orderOptions = explode(':', $rawOrder);
        $extraHot = false !== $input->getOption(self::EXTRA_HOT_OPTION);

        try {
            Assert::oneOf($orderOptions[0], array_keys(self::OPTIONS));
            if ($orderOptions[0] === 'M') {
                Assert::count($orderOptions, 2, 'No message set');
                $output->write($orderOptions[1]);
                return Command::SUCCESS;
            }
            Assert::count($orderOptions, 3, 'Insufficient parameters');
            $option = self::OPTIONS[$orderOptions[0]];
            $result = $this->handler->__invoke(
                new DrinkMakerQuery($option, (int)$orderOptions[1], $extraHot, (float)$rawMoney)
            );
            $output->write($result);

            return Command::SUCCESS;
        } catch (Exception $e) {
            $output->write($e->getMessage());

            return Command::FAILURE;
        }
    }
}

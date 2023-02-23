<?php

declare(strict_types=1);

namespace DrinkMachine\Tests\Functional\Infrastructure\Ui\Console;

use Generator;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class DrinkMachineCommandTest extends KernelTestCase
{
    /** @dataProvider getInputs */
    public function testExecute(string $order, ?string $money, array $options, string $message)
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('drink:maker');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array_merge([
            'order' => $order,
            'money' => $money,
        ], $options));

        $commandTester->assertCommandIsSuccessful();

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertEquals($message, $output);
    }

    public function getInputs(): Generator
    {
        yield 'Get Chocolate with 1 sugar' => [
            'H:1:0',
            '0.5',
            [],
            'Drink maker makes 1 chocolate with 1 sugar and a stick'
        ];

        yield 'Get Chocolate with 2 sugar' => [
            'H:2:0',
            '0.5',
            [],
            'Drink maker makes 1 chocolate with 2 sugar and a stick'
        ];

        yield 'Get Chocolate with no sugar' => [
            'H::',
            '0.5',
            [],
            'Drink maker makes 1 chocolate with no sugar - and therefore no stick'
        ];

        yield 'Get Chocolate with 1 sugar and extra hot' => [
            'H:1:0',
            '0.5',
            ['--extra-hot' => null],
            'Drink maker makes an extra hot chocolate with 1 sugar and a stick'
        ];

        yield 'Get Chocolate with no sugar and extra hot' => [
            'H::',
            '0.5',
            ['--extra-hot' => null],
            'Drink maker makes an extra hot chocolate with no sugar - and therefore no stick'
        ];

        yield 'Get Coffee with 1 sugar' => [
            'C:1:0',
            '0.6',
            [],
            'Drink maker makes 1 coffee with 1 sugar and a stick'
        ];

        yield 'Get Coffee with 2 sugar' => [
            'C:2:0',
            '0.6',
            [],
            'Drink maker makes 1 coffee with 2 sugar and a stick'
        ];

        yield 'Get Coffee with no sugar' => [
            'C::',
            '0.6',
            [],
            'Drink maker makes 1 coffee with no sugar - and therefore no stick'
        ];

        yield 'Get Tea with 1 sugar' => [
            'T:1:0',
            '0.4',
            [],
            'Drink maker makes 1 tea with 1 sugar and a stick'
        ];

        yield 'Get Tea with 2 sugar' => [
            'T:2:0',
            '0.4',
            [],
            'Drink maker makes 1 tea with 2 sugar and a stick'
        ];

        yield 'Get Tea with no sugar' => [
            'T::',
            '0.4',
            [],
            'Drink maker makes 1 tea with no sugar - and therefore no stick'
        ];

        yield 'Get Message' => [
            'M:foo',
            null,
            [],
            'foo'
        ];

        yield 'Get Orange Juice' => [
            'O::',
            '0.6',
            [],
            'Drink maker makes 1 orange juice'
        ];
    }

    public function testWrongOrdersExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('drink:maker');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'order' => 'a::',
        ]);

        $output = $commandTester->getDisplay();
        $this->assertEquals('Expected one of: "T", "H", "C", "O", "M". Got: "a"', $output);

        $this->assertEquals(1, $commandTester->getStatusCode());
    }

    public function testWrongMessageExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('drink:maker');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'order' => 'M',
        ]);

        $output = $commandTester->getDisplay();
        $this->assertEquals('No message set', $output);

        $this->assertEquals(1, $commandTester->getStatusCode());
    }

    public function testWrongInsufficientParamsExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('drink:maker');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'order' => 'T:',
        ]);

        $output = $commandTester->getDisplay();
        $this->assertEquals('Insufficient parameters', $output);

        $this->assertEquals(1, $commandTester->getStatusCode());
    }

    public function testNotSugarAvailableForOrangeJuiceOrderExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('drink:maker');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'order' => 'O:1:',
            'money' => 0.6,
        ]);

        $output = $commandTester->getDisplay();
        $this->assertEquals('Sugar not available for orange juice', $output);

        $this->assertEquals(1, $commandTester->getStatusCode());
    }

    public function testExtraHotNotAvailableForOrangeJuiceOrderExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('drink:maker');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'order' => 'O::',
            'money' => 0.6,
            '--extra-hot' => null,
        ]);

        $output = $commandTester->getDisplay();
        $this->assertEquals('Extra hot not available for orange juice', $output);

        $this->assertEquals(1, $commandTester->getStatusCode());
    }
}
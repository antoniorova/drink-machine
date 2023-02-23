<?php

declare(strict_types=1);

use PHP_CodeSniffer\Standards\Generic\Sniffs\Arrays\DisallowLongArraySyntaxSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([
        __DIR__ . '/config',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    $ecsConfig->import(SetList::PSR_12);
    $ecsConfig->import(SetList::STRICT);

    $services = $ecsConfig->services();

    $services->set(NoUnusedImportsFixer::class);
    $services->set(DisallowLongArraySyntaxSniff::class);
    $services->set(LineLengthSniff::class)
        ->property('absoluteLineLimit', 120);
};

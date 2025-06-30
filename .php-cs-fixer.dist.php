<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('database');
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder($finder)
;
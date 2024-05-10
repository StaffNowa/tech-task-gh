<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
    ->exclude('migrations')
    ->exclude('public')
    ->exclude('config')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'yoda_style' => false,
        'concat_space' => ['spacing' => 'one'],
    ])
    ->setFinder($finder)
;

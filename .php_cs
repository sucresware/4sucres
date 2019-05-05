<?php

$finder = PhpCsFixer\Finder::create()
    ->notPath('bootstrap/cache')
    ->notPath('storage')
    ->notPath('vendor')
    ->in(__DIR__)
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        '@PSR2' => true,
        'ordered_imports' => true,
        /*'ordered_class_elements' => [
            'order' => ['use_trait'],
            'sortAlgorithm' => 'alpha',
        ],*/
        'array_syntax' => ['syntax' => 'short'],
        'linebreak_after_opening_tag' => true,
        'line_ending' => true,
        'yoda_style' => false,
        'concat_space' => ['spacing' => 'one'],
    ])
    ->setFinder($finder)
;

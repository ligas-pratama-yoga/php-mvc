<?php
// @phpstan-ignore class.notFound
$finder = (new PhpCsFixer\Finder()) // @phpstan-ignore-line
	->in(__DIR__)
;

return (new PhpCsFixer\Config()) // @phpstan-ignore-line
	->setRules([
		'@PER-CS' => true,
		'@PHP82Migration' => true,
	])
	->setIndent("\t")
	->setFinder($finder)
;

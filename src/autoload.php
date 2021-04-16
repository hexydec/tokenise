<?php
declare(strict_types = 1);
spl_autoload_register(function (string $class) : bool {
	if ($class == 'hexydec\\tokens\\tokenise') {
		return require(__DIR__.'/tokenise.php');
	}
	return false;
});

<?php
declare(strict_types = 1);
\spl_autoload_register(function (string $class) : void {
	if ($class === 'hexydec\\tokens\\tokenise') {
		require(__DIR__.'/tokenise.php');
	}
});

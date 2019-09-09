<?php
/**
 * Crea las clases que creas necesarias para hacer el trabajo.
 * Ten en cuenta que el archivo `users.csv`
 */
require __DIR__.'/import/ImportUser.php';

$db = require __DIR__.'/db.php';

use Import\ImportUser;

echo "-> Starting import \n";

$users = ImportUser::importUsers(__DIR__ . '/users.csv');

echo "-> Going through csv file \n";

foreach ($users as $user) {
	if (!$user) {
		continue;
	}

	ImportUser::saveUsers($db, $user);
}

echo "-> Successful import \n";
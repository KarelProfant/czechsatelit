<?php
try
{
	$dbh = new PDO(
		'sqlite:'.$_SERVER['DOCUMENT_ROOT'].'/web/db/tvs.sqlite',
		null,
		null,
		array(PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION)
	);
}
catch (Exception $ex)
{
	die($ex->getMessage());
}
$dbh->exec("PRAGMA foreign_keys = ON");
?>

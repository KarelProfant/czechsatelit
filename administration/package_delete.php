<?php
if ($_SERVER[SCRIPT_URI] != "http://czechsatelit.sweb.cz/administration/"):
else:
{
	if (isset($_POST["btnSubmit_delete_package"])):
	{
		$sqlSelect =
			"SELECT * FROM packages ".
			"WHERE ID='".$_POST["select_delete_package_ID"]."'";
		try
		{
			$prepared = $dbh->prepare($sqlSelect);
			$prepared->execute();
		}
		catch (Exception $ex)
		{
			echo $ex->getMessage();
		}
		$result = $prepared->fetch(PDO::FETCH_ASSOC);
		$sqlDelete =
			"DELETE FROM packages ".
			"WHERE ID='".$_POST["select_delete_package_ID"]."'";
		try
		{
			$prepared = $dbh->prepare($sqlDelete);
			$prepared->execute();
		}
		catch (Exception $ex)
		{
			echo $ex->getMessage();
		}
		{
			if(!isset($ex))
			{
				echo
					json_encode($result, JSON_UNESCAPED_UNICODE).
					" has been deleted from table packages.";
			}
		}
	}
	else:
	{
?>
				<form action='/administration/#<?php echo basename(__FILE__, '.php'); ?>' method='post'>
					<select name='select_delete_package_ID'>
<?php
		$sqlSelect = "
SELECT p.ID,
       p.name,
       p.name_corporation
  FROM packages p
       JOIN
       corporations c ON p.name_corporation = c.name
 ORDER BY c.ID,
          p.local_ID;

";
		foreach ($dbh->query($sqlSelect) as $row)
		{
?>
						<option value='<?php echo $row["ID"]; ?>'>
							<?php echo $row["name"].", ".$row["name_corporation"]."\n"; ?>
						</option>
<?php
		}
?>
					</select><br>
					<input type='submit' name='btnSubmit_delete_package' value='delete'><br>
				</form>
<?php
	}
	endif;
}
endif;
?>

<?php
if ($_SERVER[SCRIPT_URI] != "http://czechsatelit.sweb.cz/administration/"):
else:
{
	if (isset($_POST["btnSubmit_delete_supercorporation"])):
	{
		$sqlSelect =
			"SELECT * FROM supercorporations ".
			"WHERE ID='".$_POST["select_delete_supercorporation_ID"]."'";
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
			"DELETE FROM supercorporations ".
			"WHERE ID='".$_POST["select_delete_supercorporation_ID"]."'";
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
				echo
					json_encode($result, JSON_UNESCAPED_UNICODE).
					" has been deleted from table supercorporations.";
		}
	}
	else:
	{
?>
				<form action='/administration/#<?php echo basename(__FILE__, '.php'); ?>' method='post'>
					<select name='select_delete_supercorporation_ID'>
<?php
		foreach ($dbh->query("SELECT * FROM supercorporations ORDER BY ID") as $row)
		{
?>
							<option value='<?php echo $row["ID"]; ?>'>
								<?php echo $row["name"]."\n"; ?>
							</option>
<?php
		}
?>
						</select><br>
					<input type='submit' name='btnSubmit_delete_supercorporation' value='delete'><br>
				</form>
<?php
	}
	endif;
}
endif;
?>

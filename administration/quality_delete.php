<?php
if ($_SERVER[SCRIPT_URI] != "http://czechsatelit.sweb.cz/administration/"):
else:
{
	if (isset($_POST["btnSubmit_delete_quality"])):
	{
		$sqlSelect =
			"SELECT * FROM qualities ".
			"WHERE value='".$_POST["select_delete_quality_value"]."'";
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
			"DELETE FROM qualities ".
			"WHERE value='".$_POST["select_delete_quality_value"]."'";
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
					" has been deleted from table qualities.";
		}
	}
	else:
	{
?>
				<form action='/administration/#<?php echo basename(__FILE__, '.php'); ?>' method='post'>
					<select name='select_delete_quality_value'>
<?php
		foreach ($dbh->query("SELECT * FROM qualities ORDER BY value") as $row)
		{
?>
							<option value='<?php echo $row["value"]; ?>'>
								<?php echo $row["value"]."\n"; ?>
							</option>
<?php
		}
?>
						</select><br>
					<input type='submit' name='btnSubmit_delete_quality' value='delete'><br>
				</form>
<?php
	}
	endif;
}
endif;
?>

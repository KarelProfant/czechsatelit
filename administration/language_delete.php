<?php
if ($_SERVER[SCRIPT_URI] != "http://czechsatelit.sweb.cz/administration/"):
else:
{
	if (isset($_POST["btnSubmit_delete_language"])):
	{
		$sqlSelect =
			"SELECT * FROM languages ".
			"WHERE value='".$_POST["select_delete_language_value"]."'";
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
			"DELETE FROM languages ".
			"WHERE value='".$_POST["select_delete_language_value"]."'";
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
						" has been deleted from table languages.";
		}
	}
	else:
	{
?>
				<form action='/administration/#<?php echo basename(__FILE__, '.php'); ?>' method='post'>
					<select name='select_delete_language_value'>
<?php
		foreach ($dbh->query("SELECT * FROM languages ORDER BY value") as $row)
		{
?>
							<option value='<?php echo $row["value"]; ?>'>
								<?php echo $row["value"]."\n"; ?>
							</option>
<?php
		}
?>
						</select><br>
					<input type='submit' name='btnSubmit_delete_language' value='delete'><br>
				</form>
<?php
	}
	endif;
}
endif;
?>

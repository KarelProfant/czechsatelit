<?php
if ($_SERVER[SCRIPT_URI] != "http://czechsatelit.sweb.cz/administration/"):
else:
{
	if (isset($_POST["btnSubmit_delete_parameter"])):
	{
		$sqlSelect =
			"SELECT * FROM parameters ".
			"WHERE ID='".$_POST["select_delete_parameter_ID"]."'";
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
			"DELETE FROM parameters ".
			"WHERE ID='".$_POST["select_delete_parameter_ID"]."'";
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
					" has been deleted from table parameters.";
			}
		}
	}
	else:
	{
?>
				<form action='/administration/#<?php echo basename(__FILE__, '.php'); ?>' method='post'>
					<select name='select_delete_parameter_ID'>
<?php
		$sqlSelect = "
SELECT *
  FROM parameters
 ORDER BY ID;
";
		foreach ($dbh->query($sqlSelect) as $row)
		{
?>
						<option value='<?php echo $row["ID"]; ?>'>
							<?php echo $row["ID"]."\n"; ?>
						</option>
<?php
		}
?>
					</select><br>
					<input type='submit' name='btnSubmit_delete_parameter' value='delete'><br>
				</form>
<?php
	}
	endif;
}
endif;
?>

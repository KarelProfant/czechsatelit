<?php
if ($_SERVER[SCRIPT_URI] != "http://czechsatelit.sweb.cz/administration/"):
else:
{
	if (isset($_POST["btnSubmit_delete_category"])):
	{
		$sqlSelect =
			"SELECT * FROM categories ".
			"WHERE ID='".$_POST["select_delete_category_ID"]."'";
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
			"DELETE FROM categories ".
			"WHERE ID='".$_POST["select_delete_category_ID"]."'";
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
					" has been deleted from table categories.";
		}
	}
	else:
	{
?>
				<form action='/administration/#<?php echo basename(__FILE__, '.php'); ?>' method='post'>
					<select name='select_delete_category_ID'>
<?php
		foreach ($dbh->query("SELECT * FROM categories ORDER BY ID") as $row)
		{
?>
						<option value='<?php echo $row["ID"]; ?>'>
							<?php echo $row["name"]."\n"; ?>
						</option>
<?php
		}
?>
					</select><br>
					<input type='submit' name='btnSubmit_delete_category' value='delete'><br>
				</form>
<?php
	}
	endif;
}
endif;
?>

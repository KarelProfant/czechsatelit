<?php
if ($_SERVER[SCRIPT_URI] != "http://czechsatelit.sweb.cz/administration/"):
else:
{
	if (isset($_POST["btnFind_edit_SATnorm"])):
	{
		$sqlSelect =
			"SELECT * FROM SATnorms ".
			"WHERE value='".$_POST["select_edit_SATnorm_value"]."'";
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
?>
				<form action='/administration/#<?php echo basename(__FILE__, '.php'); ?>' method='post'>
					<table>
						<tr>
							<td>value
						<tr>
							<td>
								<input type='hidden' name='select_edit_SATnorm_value'
									value='<?php echo $result["value"]; ?>'>
								<input type='text' name='txt_edit_SATnorm_value'
									value='<?php echo $result["value"]; ?>' size=4 maxlength=4>
					</table>
					<input type='submit' name='btnSubmit_edit_SATnorm' value='edit'><br>
				</form>
<?php
	}
	else:
	{
		if (isset($_POST["btnSubmit_edit_SATnorm"])):
		{
			$sqlSelect =
				"SELECT * FROM SATnorms ".
				"WHERE value='".$_POST["select_edit_SATnorm_value"]."'";
			try
			{
				$prepared = $dbh->prepare($sqlSelect);
				$prepared->execute();
			}
			catch (Exception $ex)
			{
				echo $ex->getMessage();
			}
			$result_old = $prepared->fetch(PDO::FETCH_ASSOC);
			$sqlUpdate =
				"UPDATE SATnorms ".
				"SET ".
					"value='".$_POST["txt_edit_SATnorm_value"]."' ".
				"WHERE value='".$_POST["select_edit_SATnorm_value"]."'";
			try
			{
				$prepared = $dbh->prepare($sqlUpdate);
				$prepared->execute();
			}
			catch (Exception $ex)
			{
				echo $ex->getMessage();
			}
			$sqlSelect =
				"SELECT * FROM SATnorms ".
				"WHERE value='".$_POST["txt_edit_SATnorm_value"]."'";
			try
			{
				$prepared = $dbh->prepare($sqlSelect);
				$prepared->execute();
			}
			catch (Exception $ex)
			{
				echo $ex->getMessage();
			}
			$result_new = $prepared->fetch(PDO::FETCH_ASSOC);
			{
				if(!isset($ex))
					echo
						json_encode($result_old, JSON_UNESCAPED_UNICODE).
						" in table SATnorms has been edited to ".
						json_encode($result_new, JSON_UNESCAPED_UNICODE).
						".";
			}
		}
		else:
		{
?>
				<form action='/administration/#<?php echo basename(__FILE__, '.php'); ?>' method='post'>
					<select name='select_edit_SATnorm_value'>
<?php
			foreach ($dbh->query("SELECT * FROM SATnorms ORDER BY value;") as $row)
			{
?>
						<option value='<?php echo $row["value"]; ?>'>
							<?php echo $row["value"]."\n"; ?>
						</option>
<?php
			}
?>
					</select><br>
					<input type='submit' name='btnFind_edit_SATnorm' value='choose'><br>
				</form>
<?php
		}
		endif;
	}
	endif;
}
endif;
?>

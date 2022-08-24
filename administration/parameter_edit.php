<?php
if ($_SERVER[SCRIPT_URI] != "http://czechsatelit.sweb.cz/administration/"):
else:
{
	if (isset($_POST["btnFind_edit_parameter"])):
	{
		$sqlSelect =
			"SELECT * FROM parameters ".
			"WHERE ID='".$_POST["select_edit_parameter_ID"]."'";
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
							<td>ID
							<td>pos
							<td>SATnorm
							<td>freq
							<td>pol
							<td>SR
						<tr>
							<td>
								<input type='hidden' name='select_edit_parameter_ID'
									value='<?php echo $result["ID"]; ?>''>
								<input type='text' name='txt_edit_parameter_ID' size=10 maxlength=10
									value='<?php echo $result["ID"]; ?>'>
							<td>
								<select name='txt_edit_parameter_pos'>
		<?php
		foreach ($dbh->query("SELECT * FROM positions ORDER BY value;") as $row)
		{
?>
									<option value='<?php echo $row["value"]; ?>'<?php echo (($row["value"]==$result["pos"])?" selected='selected'":""); ?>>
										<?php echo $row["value"]."\n"; ?>
									</option>
<?php
		}
?>
								</select>
							<td>
								<select name='txt_edit_parameter_SATnorm'>
		<?php
		foreach ($dbh->query("SELECT * FROM SATnorms ORDER BY value;") as $row)
		{
?>
									<option value='<?php echo $row["value"]; ?>'<?php echo (($row["value"]==$result["SATnorm"])?" selected='selected'":""); ?>>
										<?php echo $row["value"]."\n"; ?>
									</option>
<?php
		}
?>
								</select>
							<td>
								<input type='text' name='txt_edit_parameter_freq' size=5 maxlength=5
									value='<?php echo $result["freq"]; ?>'>
							<td>
								<select name='txt_edit_parameter_pol'>
		<?php
		foreach ($dbh->query("SELECT * FROM polarizations ORDER BY value;") as $row)
		{
?>
									<option value='<?php echo $row["value"]; ?>'<?php echo (($row["value"]==$result["pol"])?" selected='selected'":""); ?>>
										<?php echo $row["value"]."\n"; ?>
									</option>
<?php
		}
?>
								</select>
							<td>
								<input type='text' name='txt_edit_parameter_SR' size=5 maxlength=5
									value='<?php echo $result["SR"]; ?>'>
					</table>
					<input type='submit' name='btnSubmit_edit_parameter' value='edit'><br>
				</form>
<?php
	}
	else:
	{
		if (isset($_POST["btnSubmit_edit_parameter"])):
		{
			$sqlSelect =
				"SELECT * FROM parameters ".
				"WHERE ID='".$_POST["select_edit_parameter_ID"]."'";
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
				"UPDATE parameters ".
				"SET ".
					"ID='".$_POST["txt_edit_parameter_ID"]."',".
					"pos='".$_POST["txt_edit_parameter_pos"]."',".
					"SATnorm='".$_POST["txt_edit_parameter_SATnorm"]."',".
					"freq='".$_POST["txt_edit_parameter_freq"]."',".
					"pol='".$_POST["txt_edit_parameter_pol"]."',".
					"SR='".$_POST["txt_edit_parameter_SR"]."' ".
				"WHERE ID='".$_POST["select_edit_parameter_ID"]."'";
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
				"SELECT * FROM parameters ".
				"WHERE ID='".$_POST["txt_edit_parameter_ID"]."'";
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
						" in table parameters has been edited to ".
						json_encode($result_new, JSON_UNESCAPED_UNICODE).
						".";
			}
		}
		else:
		{
?>
				<form action='/administration/#<?php echo basename(__FILE__, '.php'); ?>' method='post'>
					<select name='select_edit_parameter_ID'>
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
					<input type='submit' name='btnFind_edit_parameter' value='choose'><br>
				</form>
<?php
		}
		endif;
	}
	endif;
}
endif;
?>

<?php
if ($_SERVER[SCRIPT_URI] != "http://czechsatelit.sweb.cz/administration/"):
else:
{
	if (isset($_POST["btnSubmit_add_parameter"])):
	{
		$sqlInsert =
			"INSERT INTO parameters (ID,pos,SATnorm,freq,pol,SR) ".
			"VALUES ".
			"(".
				"'".$_POST["txt_add_parameter_ID"]."',".
				"'".$_POST["txt_add_parameter_pos"]."',".
				"'".$_POST["txt_add_parameter_SATnorm"]."',".
				"'".$_POST["txt_add_parameter_freq"]."',".
				"'".$_POST["txt_add_parameter_pol"]."',".
				"'".$_POST["txt_add_parameter_SR"]."'".
			")";
		try
		{
			$prepared = $dbh->prepare($sqlInsert);
			$prepared->execute();
		}
		catch (Exception $ex)
		{
			echo $ex->getMessage();
		}
		$sqlSelect =
			"SELECT * FROM parameters ".
			"WHERE ID='".$_POST["txt_add_parameter_ID"]."'";
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
		{
			if(!isset($ex))
				echo
					json_encode($result, JSON_UNESCAPED_UNICODE).
					" has been inserted to table parameters.";
		}
	}
	else:
	{
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
							<td><input type='text' name='txt_add_parameter_ID' size=10 maxlength=10>
							<td>
								<select name='txt_add_parameter_pos'>
<?php
		foreach ($dbh->query("SELECT * FROM positions ORDER BY value;") as $row)
		{
?>
									<option value='<?php echo $row["value"]; ?>'>
										<?php echo $row["value"]."\n"; ?>
									</option>
<?php
		}
?>
								</select>
							<td>
								<select name='txt_add_parameter_SATnorm'>
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
								</select>
							<td><input type='text' name='txt_add_parameter_freq' size=5 maxlength=5>
							<td>
								<select name='txt_add_parameter_pol'>
<?php
		foreach ($dbh->query("SELECT * FROM polarizations ORDER BY value;") as $row)
		{
?>
									<option value='<?php echo $row["value"]; ?>'>
										<?php echo $row["value"]."\n"; ?>
									</option>
<?php
		}
?>
								</select>
							<td><input type='text' name='txt_add_parameter_SR' size=5 maxlength=5>
					</table>
					<input type='submit' name='btnSubmit_add_parameter' value='add'><br>
				</form>
<?php
	}
	endif;
}
endif;
?>

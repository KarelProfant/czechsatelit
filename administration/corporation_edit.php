<?php
if ($_SERVER[SCRIPT_URI] != "http://czechsatelit.sweb.cz/administration/"):
else:
{
	if (isset($_POST["btnFind_edit_corporation"])):
	{
		$sqlSelect =
			"SELECT * FROM corporations ".
			"WHERE ID='".$_POST["select_edit_corporation_ID"]."'";
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
							<td>name
							<td>abbr
							<td>language
							<td>web
							<td>super_name
						<tr>
							<td>
								<input type='hidden' name='select_edit_corporation_ID'
									value='<?php echo $result["ID"]; ?>''>
								<input type='text' name='txt_edit_corporation_ID' size=4 maxlength=4
									value='<?php echo $result["ID"]; ?>'>
							<td>
								<input type='text' name='txt_edit_corporation_name'
									value='<?php echo $result["name"]; ?>'>
							<td>
								<input type='text' name='txt_edit_corporation_abbr'
									value='<?php echo $result["abbr"]; ?>'>
							<td>
								<select name='txt_edit_corporation_language'>
		<?php
		foreach ($dbh->query("SELECT * FROM languages;") as $row)
		{
?>
									<option value='<?php echo $row["value"]; ?>'<?php echo (($row["value"]==$result["language"])?" selected='selected'":""); ?>>
										<?php echo $row["value"]."\n"; ?>
									</option>
<?php
		}
?>
								</select>
							<td>
								<input type='text' name='txt_edit_corporation_web'
									value='<?php echo $result["web"]; ?>'>
							<td>
								<select name='txt_edit_corporation_super_name'>
<?php
		foreach ($dbh->query("SELECT * FROM supercorporations ORDER BY ID;") as $row)
		{
?>
									<option value='<?php echo $row["name"]; ?>'<?php echo (($row["name"]==$result["super_name"])?" selected='selected'":""); ?>>
										<?php echo $row["name"]."\n"; ?>
									</option>
<?php
		}
?>
								</select>
					</table>
					<input type='submit' name='btnSubmit_edit_corporation' value='edit'><br>
				</form>
<?php
	}
	else:
	{
		if (isset($_POST["btnSubmit_edit_corporation"])):
		{
			$sqlSelect =
				"SELECT * FROM corporations ".
				"WHERE ID='".$_POST["select_edit_corporation_ID"]."'";
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
				"UPDATE corporations ".
				"SET ".
					"ID='".$_POST["txt_edit_corporation_ID"]."',".
					"name='".$_POST["txt_edit_corporation_name"]."',".
					"abbr='".$_POST["txt_edit_corporation_abbr"]."',".
					"language='".$_POST["txt_edit_corporation_language"]."',".
					"web='".$_POST["txt_edit_corporation_web"]."',".
					"super_name='".$_POST["txt_edit_corporation_super_name"]."' ".
				"WHERE ID='".$_POST["select_edit_corporation_ID"]."'";
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
				"SELECT * FROM corporations ".
				"WHERE ID='".$_POST["txt_edit_corporation_ID"]."'";
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
						" in table corporations has been edited to ".
						json_encode($result_new, JSON_UNESCAPED_UNICODE).
						".";
			}
		}
		else:
		{
?>
				<form action='/administration/#<?php echo basename(__FILE__, '.php'); ?>' method='post'>
					<select name='select_edit_corporation_ID'>
<?php
			foreach ($dbh->query("SELECT * FROM corporations ORDER BY ID;") as $row)
			{
?>
						<option value='<?php echo $row["ID"]; ?>'>
							<?php echo $row["name"]."\n"; ?>
						</option>
<?php
			}
?>
					</select><br>
					<input type='submit' name='btnFind_edit_corporation' value='choose'><br>
				</form>
<?php
		}
		endif;
	}
	endif;
}
endif;
?>

<?php
if ($_SERVER[SCRIPT_URI] != "http://czechsatelit.sweb.cz/administration/"):
else:
{
	if (isset($_POST["btnSubmit_add_corporation"])):
	{
		$sqlInsert =
			"INSERT INTO corporations (ID,name,abbr,language,web,super_name) ".
			"VALUES ".
			"(".
				"'".$_POST["txt_add_corporation_ID"]."',".
				"'".$_POST["txt_add_corporation_name"]."',".
				"'".$_POST["txt_add_corporation_abbr"]."',".
				"'".$_POST["txt_add_corporation_language"]."',".
				"'".$_POST["txt_add_corporation_web"]."',".
				"'".$_POST["txt_add_corporation_super_name"]."'".
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
			"SELECT * FROM corporations ".
			"WHERE ID='".$_POST["txt_add_corporation_ID"]."'";
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
					" has been inserted to table corporations.";
		}
	}
	else:
	{
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
							<td><input type='text' name='txt_add_corporation_ID' size=4 maxlength=4>
							<td><input type='text' name='txt_add_corporation_name'>
							<td><input type='text' name='txt_add_corporation_abbr'>
							<td>
								<select name='txt_add_corporation_language'>
<?php
		foreach ($dbh->query("SELECT * FROM languages;") as $row)
		{
?>
									<option value='<?php echo $row["value"]; ?>'>
										<?php echo $row["value"]."\n"; ?>
									</option>
<?php
		}
?>
								</select>
							<td><input type='text' name='txt_add_corporation_web'>
							<td>
								<select name='txt_add_corporation_super_name'>
<?php
		foreach ($dbh->query("SELECT * FROM supercorporations ORDER BY ID;") as $row)
		{
?>
									<option value='<?php echo $row["name"]; ?>'>
										<?php echo $row["name"]."\n"; ?>
									</option>
<?php
		}
?>
								</select>
					</table>
					<input type='submit' name='btnSubmit_add_corporation' value='add'><br>
				</form>
<?php
	}
	endif;
}
endif;
?>

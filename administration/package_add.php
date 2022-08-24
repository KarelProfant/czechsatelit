<?php
if ($_SERVER[SCRIPT_URI] != "http://czechsatelit.sweb.cz/administration/"):
else:
{
	if (isset($_POST["btnSubmit_add_package"])):
	{
		$sqlInsert =
			"INSERT INTO packages (ID,name,name_corporation,price_month,local_ID) ".
			"VALUES ".
			"(".
				"'".$_POST["txt_add_package_ID"]."',".
				"'".$_POST["txt_add_package_name"]."',".
				"'".$_POST["txt_add_package_name_corporation"]."',".
				"'".$_POST["txt_add_package_price_month"]."',".
				"'".$_POST["txt_add_package_local_ID"]."'".
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
			"SELECT * FROM packages ".
			"WHERE ID='".$_POST["txt_add_package_ID"]."'";
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
					" has been inserted to table packages.";
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
							<td>name_corporation
							<td>price_month
							<td>local_ID
						<tr>
							<td><input type='text' name='txt_add_package_ID'>
							<td><input type='text' name='txt_add_package_name'>
							<td>
								<select name='txt_add_package_name_corporation'>
<?php
		foreach ($dbh->query("SELECT * FROM corporations ORDER BY ID;") as $row)
		{
?>
									<option value='<?php echo $row["name"]; ?>'>
										<?php echo $row["name"]."\n"; ?>
									</option>
<?php
		}
?>
								</select>
							<td><input type='text' name='txt_add_package_price_month'>
							<td><input type='text' name='txt_add_package_local_ID' size=4 maxlength=4>
					</table>
					<input type='submit' name='btnSubmit_add_package' value='add'><br>
				</form>
<?php
	}
	endif;
}
endif;
?>

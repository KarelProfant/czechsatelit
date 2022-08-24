<?php
if ($_SERVER[SCRIPT_URI] != "http://czechsatelit.sweb.cz/administration/"):
else:
{
	if (isset($_POST["btnFind_edit_package"])):
	{
		$sqlSelect =
			"SELECT * FROM packages ".
			"WHERE ID='".$_POST["select_edit_package_ID"]."'";
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
							<td>name_corporation
							<td>price_month
							<td>local_ID
						<tr>
							<td>
								<input type='hidden' name='select_edit_package_ID'
									value='<?php echo $result["ID"]; ?>''>
								<input type='text' name='txt_edit_package_ID'
									value='<?php echo $result["ID"]; ?>'>
							<td>
								<input type='text' name='txt_edit_package_name'
									value='<?php echo $result["name"]; ?>'>
							<td>
								<select name='txt_edit_package_name_corporation'>
		<?php
		foreach ($dbh->query("SELECT * FROM corporations ORDER BY ID;") as $row)
		{
?>
									<option value='<?php echo $row["name"]; ?>'<?php echo (($row["name"]==$result["name_corporation"])?" selected='selected'":""); ?>>
										<?php echo $row["name"]."\n"; ?>
									</option>
<?php
		}
?>
								</select>
							<td>
								<input type='text' name='txt_edit_package_price_month'
									value='<?php echo $result["price_month"]; ?>'>
							<td>
								<input type='text' name='txt_edit_package_local_ID' size=4 maxlength=4
									value='<?php echo $result["local_ID"]; ?>'>
					</table>
					<input type='submit' name='btnSubmit_edit_package' value='edit'><br>
				</form>
<?php
	}
	else:
	{
		if (isset($_POST["btnSubmit_edit_package"])):
		{
			$sqlSelect =
				"SELECT * FROM packages ".
				"WHERE ID='".$_POST["select_edit_package_ID"]."'";
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
				"UPDATE packages ".
				"SET ".
					"ID='".$_POST["txt_edit_package_ID"]."',".
					"name='".$_POST["txt_edit_package_name"]."',".
					"name_corporation='".$_POST["txt_edit_package_name_corporation"]."',".
					"price_month='".$_POST["txt_edit_package_price_month"]."',".
					"local_ID='".$_POST["txt_edit_package_local_ID"]."' ".
				"WHERE ID='".$_POST["select_edit_package_ID"]."'";
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
				"SELECT * FROM packages ".
				"WHERE ID='".$_POST["txt_edit_package_ID"]."'";
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
						" in table packages has been edited to ".
						json_encode($result_new, JSON_UNESCAPED_UNICODE).
						".";
			}
		}
		else:
		{
?>
				<form action='/administration/#<?php echo basename(__FILE__, '.php'); ?>' method='post'>
					<select name='select_edit_package_ID'>
<?php
		$sqlSelect = "
SELECT p.ID,
       p.name,
       p.name_corporation
  FROM packages p
       JOIN
       corporations c ON p.name_corporation = c.name
 ORDER BY c.ID,
          p.local_ID;

";
		foreach ($dbh->query($sqlSelect) as $row)
		{
?>
						<option value='<?php echo $row["ID"]; ?>'>
							<?php echo $row["name"].", ".$row["name_corporation"]."\n"; ?>
						</option>
<?php
		}
?>
					</select><br>
					<input type='submit' name='btnFind_edit_package' value='choose'><br>
				</form>
<?php
		}
		endif;
	}
	endif;
}
endif;
?>

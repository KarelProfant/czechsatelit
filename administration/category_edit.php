<?php
if ($_SERVER[SCRIPT_URI] != "http://czechsatelit.sweb.cz/administration/"):
else:
{
	if (isset($_POST["btnFind_edit_category"])):
	{
		$sqlSelect =
			"SELECT * FROM categories ".
			"WHERE ID='".$_POST["select_edit_category_ID"]."'";
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
							<td>name_title
						<tr>
							<td>
								<input type='hidden' name='select_edit_category_ID'
									value='<?php echo $result["ID"]; ?>''>
								<input type='text' name='txt_edit_category_ID' size=4 maxlength=4
									value='<?php echo $result["ID"]; ?>'>
							<td>
								<input type='text' name='txt_edit_category_name'
									value='<?php echo $result["name"]; ?>'>
							<td>
								<input type='text' name='txt_edit_category_name_title'
									value='<?php echo $result["name_title"]; ?>'>
					</table>
					<input type='submit' name='btnSubmit_edit_category' value='edit'><br>
				</form>
<?php
	}
	else:
	{
		if (isset($_POST["btnSubmit_edit_category"])):
		{
			$sqlSelect =
				"SELECT * FROM categories ".
				"WHERE ID='".$_POST["select_edit_category_ID"]."'";
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
				"UPDATE categories ".
				"SET ".
					"ID='".$_POST["txt_edit_category_ID"]."',".
					"name='".$_POST["txt_edit_category_name"]."',".
					"name_title='".$_POST["txt_edit_category_name_title"]."' ".
				"WHERE ID='".$_POST["select_edit_category_ID"]."'";
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
				"SELECT * FROM categories ".
				"WHERE ID='".$_POST["txt_edit_category_ID"]."'";
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
						" in table categories has been edited to ".
						json_encode($result_new, JSON_UNESCAPED_UNICODE).
						".";
			}
		}
		else:
		{
?>
				<form action='/administration/#<?php echo basename(__FILE__, '.php'); ?>' method='post'>
					<select name='select_edit_category_ID'>
<?php
			foreach ($dbh->query("SELECT * FROM categories ORDER BY ID;") as $row)
			{
?>
						<option value='<?php echo $row["ID"]; ?>'>
							<?php echo $row["name"]."\n"; ?>
						</option>
<?php
			}
?>
					</select><br>
					<input type='submit' name='btnFind_edit_category' value='choose'><br>
				</form>
<?php
		}
		endif;
	}
	endif;
}
endif;
?>

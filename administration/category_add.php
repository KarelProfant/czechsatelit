<?php
if ($_SERVER[SCRIPT_URI] != "http://czechsatelit.sweb.cz/administration/"):
else:
{
	if (isset($_POST["btnSubmit_add_category"])):
	{
		$sqlInsert =
			"INSERT INTO categories (ID,name,name_title) ".
			"VALUES ".
			"(".
				"'".$_POST["txt_add_category_ID"]."',".
				"'".$_POST["txt_add_category_name"]."',".
				"'".$_POST["txt_add_category_name_title"]."'".
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
			"SELECT * FROM categories ".
			"WHERE ID='".$_POST["txt_add_category_ID"]."'";
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
					" has been inserted to table categories.";
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
							<td>name_title
						<tr>
							<td><input type='text' name='txt_add_category_ID' size=4 maxlength=4>
							<td><input type='text' name='txt_add_category_name'>
							<td><input type='text' name='txt_add_category_name_title'>
					</table>
					<input type='submit' name='btnSubmit_add_category' value='add'><br>
				</form>
<?php
	}
	endif;
}
endif;
?>

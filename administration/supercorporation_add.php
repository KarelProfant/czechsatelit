<?php
if ($_SERVER[SCRIPT_URI] != "http://czechsatelit.sweb.cz/administration/"):
else:
{
	if (isset($_POST["btnSubmit_add_supercorporation"])):
	{
		$sqlInsert =
			"INSERT INTO supercorporations (ID,name,abbr_detail) ".
			"VALUES ".
			"(".
				"'".$_POST["txt_add_supercorporation_ID"]."',".
				"'".$_POST["txt_add_supercorporation_name"]."',".
				"'".$_POST["txt_add_supercorporation_abbr_detail"]."'".
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
			"SELECT * FROM supercorporations ".
			"WHERE ID='".$_POST["txt_add_supercorporation_ID"]."'";
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
					" has been inserted to table supercorporations.";
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
							<td>abbr_detail
						<tr>
							<td><input type='text' name='txt_add_supercorporation_ID' size=4 maxlength=4>
							<td><input type='text' name='txt_add_supercorporation_name'>
							<td><input type='text' name='txt_add_supercorporation_abbr_detail'>
					</table>
					<input type='submit' name='btnSubmit_add_supercorporation' value='add'><br>
				</form>
<?php
	}
	endif;
}
endif;
?>

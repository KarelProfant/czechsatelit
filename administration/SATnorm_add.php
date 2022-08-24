<?php
if ($_SERVER[SCRIPT_URI] != "http://czechsatelit.sweb.cz/administration/"):
else:
{
	if (isset($_POST["btnSubmit_add_SATnorm"])):
	{
		$sqlInsert =
			"INSERT INTO SATnorms (value) ".
			"VALUES ".
			"(".
				"'".$_POST["txt_add_SATnorm_value"]."'".
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
			"SELECT * FROM SATnorms ".
			"WHERE value='".$_POST["txt_add_SATnorm_value"]."'";
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
					" has been inserted to table SATnorms.";
		}
	}
	else:
	{
?>
				<form action='/administration/#<?php echo basename(__FILE__, '.php'); ?>' method='post'>
					<table>
						<tr>
							<td>value
						<tr>
							<td><input type='text' name='txt_add_SATnorm_value' size=4 maxlength=4>
					</table>
					<input type='submit' name='btnSubmit_add_SATnorm' value='add'><br>
				</form>
<?php
	}
	endif;
}
endif;
?>

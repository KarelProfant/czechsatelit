<?php
if ($_SERVER[SCRIPT_URI] != "http://czechsatelit.sweb.cz/administration/"):
else:
{
	if (isset($_POST["btnSubmit_add_tv"])):
	{
		$sqlInsert =
			"INSERT INTO tvs ".
			"(".
				"name,".
				"quality,category,".
				"SLCZin,SLSKin,SLparam,".
				"FSCZin,FSSKin,FSparam,".
				"TELLYin,TELLYparam,".
				"DSKin,DSKparam,".
				"MSin,MSparam".
			") ".
			"VALUES ".
			"(".
				"'".$_POST["txt_add_tv_name"].",".
				"'".$_POST["txt_add_tv_quality"]."',".
				"'".$_POST["txt_add_tv_category"]."',".
				"'".(isset($_POST["txt_add_tv_SLCZin"])?"1":"0")."',".
				"'".(isset($_POST["txt_add_tv_SLSKin"])?"1":"0")."',".
				(($_POST["txt_add_tv_SLparam"]=="null")?"NULL":("'".$_POST["txt_add_tv_SLparam"]."'")).",".
				"'".(isset($_POST["txt_add_tv_FSCZin"])?"1":"0")."',".
				"'".(isset($_POST["txt_add_tv_FSSKin"])?"1":"0")."',".
				(($_POST["txt_add_tv_FSparam"]=="null")?"NULL":("'".$_POST["txt_add_tv_FSparam"]."'")).",".
				"'".(isset($_POST["txt_add_tv_TELLYin"])?"1":"0")."',".
				(($_POST["txt_add_tv_TELLYparam"]=="null")?"NULL":("'".$_POST["txt_add_tv_DCZparam"]."'")).",".
				"'".(isset($_POST["txt_add_tv_DSKin"])?"1":"0")."',".
				(($_POST["txt_add_tv_DSKparam"]=="null")?"NULL":("'".$_POST["txt_add_tv_DSKparam"]."'")).",".
				"'".(isset($_POST["txt_add_tv_MSin"])?"1":"0")."',".
				(($_POST["txt_add_tv_MSparam"]=="null")?"NULL":("'".$_POST["txt_add_tv_MSparam"]."'")).
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
			"SELECT * FROM tvs ".
			"WHERE name='".$_POST["txt_add_tv_name"]."'";
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
					" has been inserted to table tvs.";
		}
	}
	else:
	{
?>
				<form action='/administration/#<?php echo basename(__FILE__, '.php'); ?>' method='post'>
					<table>
						<tr>
							<td>name
							<td>quality
							<td>category
						<tr>
							<td><input type='text' name='txt_add_tv_name'>
							<td>
								<select name='txt_add_tv_quality'>
<?php
		foreach ($dbh->query("SELECT * FROM qualities ORDER BY value") as $row)
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
								<select name='txt_add_tv_category'>
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
								</select>
					</table>
					<table>
						<tr>
							<td>SLCZin
							<td>SLSKin
							<td>SLparam
						<tr>
							<td><input type="checkbox" name='txt_add_tv_SLCZin'>
							<td><input type="checkbox" name='txt_add_tv_SLSKin'>
							<td>
								<select name='txt_add_tv_SLparam'>
									<option value='null' selected>null</option>
<?php
		foreach ($dbh->query("SELECT * FROM parameters ORDER BY ID;") as $row)
		{
?>
									<option value='<?php echo $row["ID"]; ?>'>
										<?php echo $row["ID"]."\n"; ?>
									</option>
<?php
		}
?>
								</select>
						<tr>
							<td>FSCZin
							<td>FSSKin
							<td>FSparam
						<tr>
							<td><input type="checkbox" name='txt_add_tv_FSCZin'>
							<td><input type="checkbox" name='txt_add_tv_FSSKin'>
							<td>
								<select name='txt_add_tv_FSparam'>
									<option value='null' selected>null</option>
<?php
		foreach ($dbh->query("SELECT * FROM parameters ORDER BY ID;") as $row)
		{
?>
									<option value='<?php echo $row["ID"]; ?>'>
										<?php echo $row["ID"]."\n"; ?>
									</option>
<?php
		}
?>
								</select>
						<tr>
							<td>TELLYin
							<td>
							<td>TELLYparam
						<tr>
							<td><input type="checkbox" name='txt_add_tv_TELLYin'>
							<td>
							<td>
								<select name='txt_add_tv_TELLYparam'>
									<option value='null' selected>null</option>
<?php
		foreach ($dbh->query("SELECT * FROM parameters ORDER BY ID;") as $row)
		{
?>
									<option value='<?php echo $row["ID"]; ?>'>
										<?php echo $row["ID"]."\n"; ?>
									</option>
<?php
		}
?>
								</select>
						<tr>
							<td>
							<td>DSKin
							<td>DSKparam
						<tr>
							<td>
							<td><input type="checkbox" name='txt_add_tv_DSKin'>
							<td>
								<select name='txt_add_tv_DSKparam'>
									<option value='null' selected>null</option>
<?php
		foreach ($dbh->query("SELECT * FROM parameters ORDER BY ID;") as $row)
		{
?>
									<option value='<?php echo $row["ID"]; ?>'>
										<?php echo $row["ID"]."\n"; ?>
									</option>
<?php
		}
?>
								</select>
						<tr>
							<td>
							<td>MSin
							<td>MSparam
						<tr>
							<td>
							<td><input type="checkbox" name='txt_add_tv_MSin'>
							<td>
								<select name='txt_add_tv_MSparam'>
									<option value='null' selected>null</option>
<?php
		foreach ($dbh->query("SELECT * FROM parameters ORDER BY ID;") as $row)
		{
?>
									<option value='<?php echo $row["ID"]; ?>'>
										<?php echo $row["ID"]."\n"; ?>
									</option>
<?php
		}
?>
								</select>
					</table>
					<input type='submit' name='btnSubmit_add_tv' value='add'><br>
				</form>
<?php
	}
	endif;
}
endif;
?>

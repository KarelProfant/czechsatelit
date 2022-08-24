<!doctype html>
<html lang="cs">
	<head>
		<title>czechsatelit</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="Shortcut Icon" type="image/ico" href="/web/img/favicon.ico">
		<link rel="stylesheet" href="/web/css/side-menu.css">
		<link rel="stylesheet" href="/web/css/type.css">
		<link rel="stylesheet" href="/web/css/hp.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	</head>
	<body>
		<div id="layout">
<?php
include_once "web/php/menu_icon.php";
echo
	"\t\t\t<nav id='menu' class='pure-menu pure-menu-open'>\n";
include_once "web/php/menu1.php";
echo
	"\t\t\t</nav>\n";
include_once "web/php/header.php";
echo
	"\t\t\t<section>\n".
	"\t\t\t\t<article>\n".
	"\t\t\t\t\t<img src='/web/img/parabola.jpg' alt='paraboly' class='hppic'>\n".
	"\t\t\t\t\t<p>Na této stránce si můžete porovnat nabídku satelitní televize nebo si můžete zjistit parametry, na kterých se televize u poskytovatelů vysílají. Stačí kliknout na českou nebo slovenskou vlaječku. Můžete si také <a href='/list'>vyhledat televize podle jejich vlastností</a>.</p>";
include_once "web/php/connecttodb.php";
$sqlSelect1 = "SELECT name FROM supercorporations ORDER BY ID";
foreach ($dbh->query($sqlSelect1) as $row1)
{
	$sqlSelect2 =
		"SELECT name,language,web,abbr ".
		"FROM corporations ".
		"WHERE super_name='".$row1["name"]."' ".
		"ORDER BY language";
	$result = $dbh->prepare($sqlSelect2);
	echo
		"\t\t\t\t\t<div class='hppicslo'>\n".
		"\t\t\t\t\t\t<h2><img src='/web/img/corp/".
		str_replace(" ", "_", $row1["name"]).".svg' ".
		"alt='logo ".$row1["name"]."'></h2>\n".
		"\t\t\t\t\t\t<table>\n".
		"\t\t\t\t\t\t\t<tr>\n".
		"\t\t\t\t\t\t\t\t<td>web:\n";
	$result->execute();
	foreach ($result as $row2)
	{
		echo
			"\t\t\t\t\t\t\t\t<td>\n".
			"\t\t\t\t\t\t\t\t\t<a href='".$row2["web"]."' target='_blank'>\n".
			"\t\t\t\t\t\t\t\t\t\t<img src='/web/img/flag/".$row2["language"].
			".svg#vlajka_".$row2["language"]."' alt='web ".$row2["name"]."'>\n".
			"\t\t\t\t\t\t\t\t\t</a>\n";
	}
	echo
		"\t\t\t\t\t\t\t<tr>\n".
		"\t\t\t\t\t\t\t\t<td>ceník:\n";
	$result->execute();
	foreach ($result as $row2)
	{
		echo
			"\t\t\t\t\t\t\t\t<td>\n".
			"\t\t\t\t\t\t\t\t\t<a href='/pricelist/?corp=".$row2["abbr"]."'>\n".
			"\t\t\t\t\t\t\t\t\t\t<img src='/web/img/flag/".$row2["language"].
			".svg#vlajka_".$row2["language"]."' alt='ceník ".$row2["name"]."'>\n".
			"\t\t\t\t\t\t\t\t\t</a>\n";
	}
	if($row2["abbr"] != "MS")
	{
		echo
			"\t\t\t\t\t\t\t<tr>\n".
			"\t\t\t\t\t\t\t\t<td>parametry:\n";
		$result->execute();
		foreach ($result as $row2)
		{
			echo
				"\t\t\t\t\t\t\t\t<td>\n".
				"\t\t\t\t\t\t\t\t\t<a href='/parameters/?corp=".$row2["abbr"]."'>\n".
				"\t\t\t\t\t\t\t\t\t\t<img src='/web/img/flag/".$row2["language"].
				".svg#vlajka_".$row2["language"]."' alt='parametry ".$row2["name"]."'>\n".
				"\t\t\t\t\t\t\t\t\t</a>\n";
		}
	 }
	echo
	"\t\t\t\t\t\t</table>\n".
	"\t\t\t\t\t</div>\n";
}
echo
	"\t\t\t\t</article>\n".
	"\t\t\t</section>\n";
include_once "web/php/footer.php";
?>
<script>
$(document).ready(function () {
	$('article').find('a').click(function(){
			sessionStorage.setItem("package_ID", null);
			sessionStorage.setItem("previous_tvs", null);
			sessionStorage.setItem("previous_categories", null);
	});
});
</script>
		</div>
		<script src="/web/js/ui.js"></script>
	</body>
</html>

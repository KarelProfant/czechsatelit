<?php
include_once "../web/php/connecttodb.php";
include_once "../web/php/szn_function.php";
$correct_corp_input = false;
$local_corp = isset($_GET["_corp"]) ? $_GET["corp"] : '';
$local_corp = !empty($_GET["corp"]) ? $_GET["corp"] : '';
$sqlSelect = "
SELECT corporations.name,corporations.abbr,supercorporations.abbr_detail,super_name
FROM corporations
JOIN supercorporations
ON corporations.super_name=supercorporations.name
WHERE abbr='$local_corp'
LIMIT 1
";
if($local_corp != "")
{
	$result = $dbh->prepare($sqlSelect);
	$result->execute();
	if ($result)
	{
		$row = $result->fetch(PDO::FETCH_ASSOC);
		if ($row != null && $row["name"] != "Magiosat SK")
		{
			$correct_corp_input = true;
			$namecorp = $row["name"];
			$abbrcorp = $row["abbr"];
			$supercorp_name = $row["super_name"];
			$supercorp_abbr = $row["abbr_detail"];
		}
	}
}
if(!$correct_corp_input)
{
	header("Location: http://".$_SERVER['HTTP_HOST']."/404");
}
$title = "Parametry $namecorp";
?>
<!doctype html>
<html lang="cs">
	<head>
		<title><?php echo $title; ?> | czechsatelit</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="Shortcut Icon" type="image/ico" href="/web/img/favicon.ico">
		<link rel="stylesheet" href="/web/css/side-menu.css">
		<link rel="stylesheet" href="/web/css/type.css">
		<link rel="stylesheet" href="/web/css/parameters.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/cs.js"></script>
	</head>
	<body>
		<div id="layout">
<?php
include_once "../web/php/menu_icon.php";
echo
	"\t\t\t<nav id='menu' class='pure-menu pure-menu-open'>\n";
include_once "../web/php/menu1.php";
include_once "../web/php/menu2.php";
echo
	"\t\t\t</nav>\n";
include_once "../web/php/header.php";
echo
	"\t\t\t<section>\n".
	"\t\t\t\t<h1>$title</h1>\n".
	"\t\t\t\t<article>\n".
	"\t\t\t\t\t<select id='parameters_select' multiple='multiple' class='operator'>\n";
$sqlfind = "
SELECT *
FROM
(
SELECT name_tv,param_param
FROM
(
SELECT DISTINCT name_tv
FROM
(
SELECT ID
FROM
packages
WHERE name_corporation = '$namecorp'
)
JOIN
tvs_in_package
ON ID=ID_package
)
JOIN
tvs_in_param
ON name_tv = name_tv_param AND name_supercorp_param = '$supercorp_name'
)
JOIN
parameters
ON param_param = ID
ORDER BY name_tv ASC
";
$tvsfromdb = array();
$sth = $dbh->query($sqlfind);
while($row = $sth->fetch(PDO::FETCH_ASSOC))
{
	$row['name'] = $row['name_tv'];
	unset($row['name_tv']);
	$tvsfromdb[] = $row;
}
uasort($tvsfromdb, $sort_czech);
foreach ($tvsfromdb as $row)
{
	echo
		"\t\t\t\t\t\t<option value='".tv_name_to_web($row["name"])."'>".$row["name"]."</option>\n";
}
echo
	"\t\t\t\t\t</select>\n";
$groupedtvsfromdb = array();
foreach ($tvsfromdb as $a)
{
	$key = $a['ID'];
	if (isset($groupedtvsfromdb[$key]))
	{
		array_push($groupedtvsfromdb[$key]['tvs'], $a['name']);
	}
	else
	{
		$groupedtvsfromdb[$key]['param'] = $a['param_param'];
		$groupedtvsfromdb[$key]['pos'] = $a['pos'];
		$groupedtvsfromdb[$key]['SATnorm'] = $a['SATnorm'];
		$groupedtvsfromdb[$key]['freq'] = $a['freq'];
		$groupedtvsfromdb[$key]['pol'] = $a['pol'];
		$groupedtvsfromdb[$key]['SR'] = $a['SR'];
		$groupedtvsfromdb[$key]['tvs'] = array($a['name']);
	}
}
echo
	"\t\t\t\t\t<table id='parameters_tab'>\n".
	"\t\t\t\t\t\t<tr id='rowtab'>\n".
	"\t\t\t\t\t\t\t<th>parametry\n".
	"\t\t\t\t\t\t\t<th>televize\n";
asort($groupedtvsfromdb);
foreach ($groupedtvsfromdb as $freq)
{
	echo
		"\t\t\t\t\t\t<tr id='".$freq["param"]."'>\n".
		"\t\t\t\t\t\t\t<td>".
		$freq["pos"].", ".
		"DVB&#8209;S".($freq["SATnorm"]==2?"2":"").", ".
		$freq["freq"]."&nbsp;MHz, ".
		$freq["pol"].", ".
		$freq["SR"]."\n".
		"\t\t\t\t\t\t\t<td>\n";
	$i = 0;
	$sum = count($freq['tvs']);
	foreach ($freq['tvs'] as $tv)
	{
		$nametoweb = tv_name_to_web($tv);
		$nametoGET = tv_name_to_GET_method($nametoweb);
		echo
			"\t\t\t\t\t\t\t\t<span>".
			"<a href='/detail/?name=$nametoGET' id='$nametoweb' class='teltext'>".
			str_replace(" ", '&nbsp;', $tv)."</a>";
		if ($i != $sum-1)
		{
			echo ',';
		}
		echo
			"</span>\n";
		$i++;
	}
}
echo
	"\t\t\t\t\t</table>\n".
	"\t\t\t\t</article>\n".
	"\t\t\t</section>\n";
include_once "../web/php/footer.php";
?>
			<script src="/web/js/parameters.js"></script>
		</div>
		<script src="/web/js/ui.js"></script>
	</body>
</html>

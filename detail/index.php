<?php
include_once "../web/php/connecttodb.php";
include_once "../web/php/szn_function.php";
$nameindatabase = tv_webname_to_normal($_GET["name"]);
$namepic = tv_name_to_web($nameindatabase);
$sqlSelect = "
SELECT *
FROM tvs
WHERE tvs.name='$nameindatabase'
LIMIT 1";
$result = $dbh->prepare($sqlSelect);
$result->execute();
$flag = false;
if ($result) {
	$row = $result->fetch(PDO::FETCH_ASSOC);
	if($row["name"] != "")
	{
		$flag = true;
		$title = "Detail $nameindatabase";
	}
}
if(!$flag || substr_count($_GET["name"], ' ') > 0)
{
	header("Location: http://".$_SERVER['HTTP_HOST']."/404");
}
$namepic = (($row["quality"]=="SD")?$namepic:(trim(substr($namepic, 0, strrpos($namepic, '_')))));
$namepic = (($row["foreign_tv"]!=1)?$namepic:(trim(substr($namepic, 0, strrpos($namepic, '_')))));
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
		<link rel="stylesheet" href="/web/css/detail.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="/web/js/tooltip.js"></script>
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
	"\t\t\t\t\t<img src='/web/img/tv/$namepic.svg' alt='logo $nameindatabase' id='detail_tvlogo'>\n".
	"\t\t\t\t\t<p><b>rozlišení:</b> ".$row["quality"]."</p>\n".
	"\t\t\t\t\t<p><b>druh:</b> ".$row["category"]."</p>\n".
	"\t\t\t\t\t<table id='detail_paramtab'>\n".
	"\t\t\t\t\t\t<tr>\n".
	"\t\t\t\t\t\t\t<th>po&shy;s&shy;ky&shy;to&shy;va&shy;tel\n".
	"\t\t\t\t\t\t\t<span class='ref'>\n".
	"\t\t\t\t\t\t\t\t<img src='/web/img/info.svg' alt='info' class='ktooltip'>\n".
	"\t\t\t\t\t\t\t\t<span class='ktooltiptext'>seznam všech poskytovatelů satelitní televize</span>\n".
	"\t\t\t\t\t\t\t</span>\n".
	"\t\t\t\t\t\t\t<th><img src='/web/img/flag/CZ.svg' alt='vlajka CZ' class='detail_flag'>\n".
	"\t\t\t\t\t\t\t<span class='ref'>\n".
	"\t\t\t\t\t\t\t\t<img src='/web/img/info.svg' alt='info' class='ktooltip'>\n".
	"\t\t\t\t\t\t\t\t<span class='ktooltiptext'>česká nabídka poskytovatele<br><img src='/web/img/tick/YES.svg' alt='ano'> - televizi má v nabídce<br><img src='/web/img/tick/NO.svg' alt='ne'> - televizi nemá v nabídce</span>\n".
	"\t\t\t\t\t\t\t</span>\n".
	"\t\t\t\t\t\t\t<th><img src='/web/img/flag/SK.svg' alt='vlajka SK' class='detail_flag'>\n".
	"\t\t\t\t\t\t\t<span class='ref'>\n".
	"\t\t\t\t\t\t\t\t<img src='/web/img/info.svg' alt='info' class='ktooltip'>\n".
	"\t\t\t\t\t\t\t\t<span class='ktooltiptext'>slovenská nabídka poskytovatele<br><img src='/web/img/tick/YES.svg' alt='ano'> - televizi má v nabídce<br><img src='/web/img/tick/NO.svg' alt='ne'> - televizi nemá v nabídce</span>\n".
	"\t\t\t\t\t\t\t</span>\n".
	"\t\t\t\t\t\t\t<th>parametry\n".
	"\t\t\t\t\t\t\t<span class='ref'>\n".
	"\t\t\t\t\t\t\t\t<img src='/web/img/info.svg' alt='info' class='ktooltip'>\n".
	"\t\t\t\t\t\t\t\t<span class='ktooltiptext'>parametry, na kterých u poskytovatele televizi naladíte</span>\n".
	"\t\t\t\t\t\t\t</span>\n";
$sqlSelect_supercorp = "
SELECT *
  FROM (
           SELECT abbr_detail,
                  super_name,
                  abbr_CZ,
                  is_CZ,
                  CASE WHEN (corp_SK IS NULL) THEN NULL ELSE (
                          SELECT abbr
                            FROM corporations
                           WHERE name = corp_SK
                      )
                  END AS abbr_SK,
                  CASE WHEN (name_corporation = corp_SK) THEN 1 WHEN (corp_SK IS NULL) THEN NULL ELSE 0 END AS is_SK
             FROM (
                      SELECT super_name,
                             CASE WHEN (corp_CZ IS NULL) THEN NULL ELSE (
                                     SELECT abbr
                                       FROM corporations
                                      WHERE name = corp_CZ
                                 )
                             END AS abbr_CZ,
                             corp_CZ,
                             corp_SK,
                             CASE WHEN (name_corporation = corp_CZ) THEN 1 WHEN (corp_CZ IS NULL) THEN NULL ELSE 0 END AS is_CZ
                        FROM (
                                 SELECT super_name,
                                        corp_CZ,
                                        corp_SK
                                   FROM (
                                            SELECT temp1.super_name,
                                                   temp1.corp_CZ,
                                                   temp2.corp_SK
                                              FROM (
                                                       SELECT corporations.super_name,
                                                              corporations.name AS corp_CZ
                                                         FROM supercorporations
                                                              JOIN
                                                              corporations ON supercorporations.name = corporations.super_name
                                                        WHERE language = 'CZ'
                                                   )
                                                   AS temp1
                                                   LEFT OUTER JOIN
                                                   (
                                                       SELECT corporations.super_name,
                                                              corporations.name AS corp_SK
                                                         FROM supercorporations
                                                              JOIN
                                                              corporations ON supercorporations.name = corporations.super_name
                                                        WHERE language = 'SK'
                                                   )
                                                   AS temp2 ON temp1.super_name = temp2.super_name
                                            UNION
                                            SELECT temp2.super_name,
                                                   temp1.corp_CZ,
                                                   temp2.corp_SK
                                              FROM (
                                                       SELECT corporations.super_name,
                                                              corporations.name AS corp_SK
                                                         FROM supercorporations
                                                              JOIN
                                                              corporations ON supercorporations.name = corporations.super_name
                                                        WHERE language = 'SK'
                                                   )
                                                   AS temp2
                                                   LEFT OUTER JOIN
                                                   (
                                                       SELECT corporations.super_name,
                                                              corporations.name AS corp_CZ
                                                         FROM supercorporations
                                                              JOIN
                                                              corporations ON supercorporations.name = corporations.super_name
                                                        WHERE language = 'CZ'
                                                   )
                                                   AS temp1 ON temp1.super_name = temp2.super_name
                                        )
                                        JOIN
                                        supercorporations ON supercorporations.name = super_name
                                  ORDER BY supercorporations.ID
                             )
                             LEFT OUTER JOIN
                             (
                                 SELECT DISTINCT tvs_in_package.name_tv,
                                                 packages.name_corporation
                                   FROM tvs_in_package
                                        JOIN
                                        packages ON tvs_in_package.ID_package = packages.ID
                                  WHERE tvs_in_package.name_tv = '$nameindatabase'
                             )
                             ON name_corporation = corp_CZ
                  )
                  LEFT OUTER JOIN
                  (
                      SELECT DISTINCT tvs_in_package.name_tv,
                                      packages.name_corporation
                        FROM tvs_in_package
                             JOIN
                             packages ON tvs_in_package.ID_package = packages.ID
                       WHERE tvs_in_package.name_tv = '$nameindatabase'
                  )
                  ON name_corporation = corp_SK
                  JOIN
                  supercorporations ON supercorporations.name = super_name
       )
       LEFT OUTER JOIN
       (
           SELECT *
             FROM (
                      SELECT *
                        FROM tvs_in_param
                       WHERE name_tv_param = '$nameindatabase'
                  )
                  JOIN
                  parameters ON ID = param_param
       )
       ON super_name = name_supercorp_param;
";
$sth = $dbh->query($sqlSelect_supercorp);
while($row_supercorp = $sth->fetch(PDO::FETCH_ASSOC))
{
	echo
		"\t\t\t\t\t\t<tr>\n".
		"\t\t\t\t\t\t\t<td><img src='/web/img/corp/".
			tv_name_to_web($row_supercorp["super_name"]).".svg' ".
			"alt='logo ".$row_supercorp["super_name"]."'>\n";
	echo
		"\t\t\t\t\t\t\t\t<td>";
	if($row_supercorp["is_CZ"] != "")
	{
		$yes = $row_supercorp["is_CZ"];
		echo
			"<img src='/web/img/tick/".
			($yes?"YES":"NO").".svg' alt='".
			($yes?"ano":"ne")."'>";
	}
	echo "\n";
	echo
		"\t\t\t\t\t\t\t\t<td>";
	if($row_supercorp["is_SK"] != "")
	{
		$yes = $row_supercorp["is_SK"];
		echo
			"<img src='/web/img/tick/".
			($yes?"YES":"NO").".svg' alt='".
			($yes?"ano":"ne")."'>";
	}
	echo "\n";
	echo
		"\t\t\t\t\t\t\t<td>";
	$in = $row_supercorp["is_CZ"]+$row_supercorp["is_SK"];
	if($in == 0 || $row_supercorp["abbr_detail"] == "MS")
	{
		echo "<hr>";
	}
	else
	{
		echo
			$row_supercorp["pos"].", ".
			"DVB&#8209;S".($row_supercorp["SATnorm"]==2?"2":"").", ".
			$row_supercorp["freq"]."&nbsp;MHz, ".
			$row_supercorp["pol"].", ".
			$row_supercorp["SR"];
	}
	echo "\n";
}
echo
	"\t\t\t\t\t</table>\n";
$sqlSelect_pack_corp = "
SELECT DISTINCT name_corporation,abbr,ID_package,local_ID,name_package,price_month,corporations.ID,super_name
FROM tvs_in_package
JOIN packages
ON tvs_in_package.ID_package=packages.ID
JOIN corporations
ON packages.name_corporation=corporations.name
JOIN supercorporations
ON super_name=supercorporations.name
WHERE tvs_in_package.name_tv='$nameindatabase'
ORDER BY corporations.ID
";
$groupedpackagesfromdb = array();
$sth = $dbh->query($sqlSelect_pack_corp);
while($row = $sth->fetch(PDO::FETCH_ASSOC))
{
	$key = $row['ID'];
	if (!isset($groupedpackagesfromdb[$key]))
	{
		$groupedpackagesfromdb[$key]['name_corporation'] = $row['name_corporation'];
		$groupedpackagesfromdb[$key]['abbr'] = $row['abbr'];
		$groupedpackagesfromdb[$key]['super_name'] = $row['super_name'];
	}
	unset($row['ID']);
	unset($row['name_corporation']);
	unset($row['abbr']);
	unset($row['super_name']);
	$groupedpackagesfromdb[$key]['packages'][] = $row;
}
echo
	"\t\t\t\t\t\t\tbalíčky a parametry:".
	"\t\t\t\t\t\t\t<span class='ref'>\n".
	"\t\t\t\t\t\t\t\t<img src='/web/img/info.svg' alt='info' class='ktooltip'>\n".
	"\t\t\t\t\t\t\t\t<span class='ktooltiptext'>Přehled balíčků, ve kterých  poskytovatelé touto televizí nabízí. Lze si je rozkliknout a podívat se na jejich detail, stejně jako parametry, na kterých poskytovatel tuto televizi vysílá.</span>\n".
	"\t\t\t\t\t\t\t</span>\n".
	"\t\t\t\t\t<ul id='detail_package_list'>\n";
foreach($groupedpackagesfromdb as $row_pack_corp)
{
	echo
		"\t\t\t\t\t\t<li style=\"list-style-image:url('/web/img/nav/corp/".
		tv_name_to_web($row_pack_corp["super_name"]).".svg')\">".$row_pack_corp["name_corporation"]."\n".
		"\t\t\t\t\t\t<ul>\n".
		"\t\t\t\t\t\t\t<li><a href='/parameters?corp=".$row_pack_corp["abbr"]."'>parametry</a>\n".
		"\t\t\t\t\t\t\t<li>balíčky\n".
		"\t\t\t\t\t\t\t\t<ul>\n";
	usort($row_pack_corp['packages'], function ($row, $b) {return $row['local_ID'] > $b['local_ID'];});
	foreach($row_pack_corp['packages'] as $row_pack)
	{
		echo
			"\t\t\t\t\t\t\t\t<li><a href='/pricelist/?corp=".
				$row_pack_corp["abbr"]."' class='".$row_pack["ID_package"]."'>".$row_pack["name_package"].
				"</a>, cena: ".str_replace(" ", '&nbsp;', $row_pack["price_month"])." měsíčně\n";
	}
	echo
		"\t\t\t\t\t\t\t\t</ul>\n".
		"\t\t\t\t\t\t</ul>\n";
}
echo
	"\t\t\t\t\t</ul>\n".
	"\t\t\t\t</article>\n".
	"\t\t\t</section>\n";
include_once "../web/php/footer.php";
?>
			<script src="/web/js/detail.js"></script>
		</div>
		<script src="/web/js/ui.js"></script>
	</body>
</html>

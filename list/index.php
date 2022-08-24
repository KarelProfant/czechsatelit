<?php
include_once "../web/php/connecttodb.php";
include_once "../web/php/szn_function.php";
$title = "Vyhledávání televizí podle vlastností";
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
		<link rel="stylesheet" href="/web/css/list.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/cs.js"></script>
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
	"\t\t\t\t<article>\n";
include_once "../web/php/alert_loading.php";
$sth = $dbh->query("SELECT * FROM categories");
$categoriesfromdb = $sth->fetchAll(PDO::FETCH_COLUMN);
$sth = $dbh->query("SELECT * FROM qualities");
$qualitiesfromdb = $sth->fetchAll(PDO::FETCH_COLUMN);
$sqlSelect = "
SELECT *
FROM tvs
ORDER BY name
";
$tvsfromdb = array();
$sth = $dbh->query($sqlSelect);
while( $row = $sth->fetch(PDO::FETCH_ASSOC) ) {
	$tvsfromdb[$row["name"]] = $row;
}
uasort($tvsfromdb, $sort_czech);
echo
	"\t\t\t\t\t<p>podle druhu: \n".
	"\t\t\t\t\t\t<span class='ref'>\n".
	"\t\t\t\t\t\t\t<img src='/web/img/info.svg' alt='info' class='ktooltip'>\n".
	"\t\t\t\t\t\t\t<span class='ktooltiptext'>Klikněte do políčka a zvolte si druh televize ze seznamu. Seznam druhů si můžete zkrátit napsáním části názvu.</span>\n".
	"\t\t\t\t\t\t</span>\n".
	"\t\t\t\t\t\t<select id='list_select_categories' multiple='multiple' class='operator'>\n";
foreach ($categoriesfromdb as $row)
{
	echo
		"\t\t\t\t\t\t\t<option value='".$row."'>".$row."</option>\n";
}
echo
	"\t\t\t\t\t\t</select>\n".
	"\t\t\t\t\t\t<button id='list_select_categories_all'>Zvolit vše</button>\n".
	"\t\t\t\t\t\t<button id='list_select_categories_nothing'>Zrušit vše</button>\n".
	"\t\t\t\t\t</p>\n".
	"\t\t\t\t\t<p>podle kvality: \n".
	"\t\t\t\t\t\t<span class='ref'>\n".
	"\t\t\t\t\t\t\t<img src='/web/img/info.svg' alt='info' class='ktooltip'>\n".
	"\t\t\t\t\t\t\t<span class='ktooltiptext'>Klikněte do políčka a zvolte si kvalitu televize ze seznamu. Seznam kvalit si můžete zkrátit napsáním části názvu.</span>\n".
	"\t\t\t\t\t\t</span>\n".
	"\t\t\t\t\t\t<select id='list_select_qualities' multiple='multiple' class='operator'>\n";
foreach ($qualitiesfromdb as $row)
{
	echo
		"\t\t\t\t\t\t\t<option value='".$row."'>".$row."</option>\n";
}
echo
	"\t\t\t\t\t\t</select>\n".
	"\t\t\t\t\t\t<button id='list_select_qualities_all'>Zvolit vše</button>\n".
	"\t\t\t\t\t\t<button id='list_select_qualities_nothing'>Zrušit vše</button>\n".
	"\t\t\t\t\t</p>\n".
	"\t\t\t\t\t<p>podle jména: \n".
	"\t\t\t\t\t\t<span class='ref'>\n".
	"\t\t\t\t\t\t\t<img src='/web/img/info.svg' alt='info' class='ktooltip'>\n".
	"\t\t\t\t\t\t\t<span class='ktooltiptext'>Klikněte do políčka a napište část jména televize.</span>\n".
	"\t\t\t\t\t\t</span>\n".
	"<input type='text' id='list_select_name' onkeyup='change_items()' placeholder='Zvolte jméno.'>".
	"\t\t\t\t\t</p>\n";
foreach ($tvsfromdb as $row)
{
	$normalname = $row["name"];
$sqlSelect_supercorp = "
SELECT
    super_name,
    is_CZ,
    case
        when (name_corporation = corp_SK) then 1
        when (corp_SK IS NULL) then NULL
        else 0 end as is_SK
FROM
(
    SELECT
        super_name,
        corp_SK,
        case
        when (name_corporation = corp_CZ) then 1
        when (corp_CZ IS NULL) then NULL
        else 0 end as is_CZ
    FROM
    (
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
        SELECT DISTINCT tvs_in_package.name_tv, packages.name_corporation
        FROM tvs_in_package
        JOIN packages
        ON tvs_in_package.ID_package = packages.ID
        WHERE tvs_in_package.name_tv = '$normalname'
    )
    ON name_corporation = corp_CZ
)
LEFT OUTER JOIN
(
    SELECT DISTINCT tvs_in_package.name_tv, packages.name_corporation
    FROM tvs_in_package
    JOIN packages
    ON tvs_in_package.ID_package = packages.ID
    WHERE tvs_in_package.name_tv = '$normalname'
)
ON name_corporation = corp_SK
";
	$tablefromdb = array();
	$sth = $dbh->query($sqlSelect_supercorp);
	while( $row2 = $sth->fetch(PDO::FETCH_ASSOC) ) {
		$tablefromdb[] = $row2;
	}
	$tvsfromdb[$row["name"]]["table"] = array();
	$tvsfromdb[$row["name"]]["table"][] = $tablefromdb;
}
foreach ($tvsfromdb as $row)
{
	$normalname = $row["name"];
	$nametoweb = tv_name_to_web($normalname);
	$nametoGET = tv_name_to_GET_method($nametoweb);
	$namepic = ($row["quality"]=="SD"?$nametoweb:(trim(substr($nametoweb, 0, strrpos($nametoweb, '_')))));
	$namepic = ($row["foreign_tv"]!=1?$namepic:(trim(substr($namepic, 0, strrpos($namepic, '_')))));
	echo
		"\t\t\t\t<a href='/detail?name=$nametoGET' style='display:none'>\n".
		"\t\t\t\t\t<div id='$nametoweb' ".
		"class='list_item ".$row["category"]." ".$row["quality"]."'>\n".
		"\t\t\t\t\t\t<img src='/web/img/tv/$namepic.svg".
		"' alt='logo $normalname'>\n".
		"\t\t\t\t\t\t<table>\n".
		"\t\t\t\t\t\t\t<tr>\n".
		"\t\t\t\t\t\t\t\t<td>\n".
		"\t\t\t\t\t\t\t\t<td><img src='/web/img/flag/CZ.svg' alt='vlajka CZ'>\n".
		"\t\t\t\t\t\t\t\t<td><img src='/web/img/flag/SK.svg' alt='vlajka SK'>\n";
	foreach ($row["table"][0] as $row2)
	{
		echo
			"\t\t\t\t\t\t\t<tr>\n".
			"\t\t\t\t\t\t\t\t<td><img src='/web/img/corp/".
				tv_name_to_web($row2["super_name"]).".svg' ".
				"alt='logo ".$row2["super_name"]."'>\n";
		echo "\t\t\t\t\t\t\t\t<td>";
		if($row2["is_CZ"] != "")
		{
			$yes = $row2["is_CZ"];
			echo
				"<img src='/web/img/tick/".
				($yes?"YES":"NO").".svg' alt='".
				($yes?"ano":"ne")."'>";
		}
		echo "\n";
		echo "\t\t\t\t\t\t\t\t<td>";
		if($row2["is_SK"] != "")
		{
			$yes = $row2["is_SK"];
			echo
				"<img src='/web/img/tick/".
				($yes?"YES":"NO").".svg' alt='".
				($yes?"ano":"ne")."'>";
		}
		echo "\n";
	}
	echo
		"\t\t\t\t\t\t</table>\n".
		"\t\t\t\t\t\t<p>".$row["name"]."</p>\n".
		"\t\t\t\t\t</div>\n".
		"\t\t\t\t</a>\n";
}
echo
	"\t\t\t\t</article>\n".
	"\t\t\t</section>\n";
include_once "../web/php/footer.php";
?>
			<script src="/web/js/list.js"></script>
		</div>
		<script src="/web/js/ui.js"></script>
	</body>
</html>

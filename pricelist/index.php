<?php
include_once "../web/php/connecttodb.php";
$sqlSelect = "
SELECT name
FROM corporations
WHERE abbr='".$_GET["corp"]."'
LIMIT 1
";
$result = $dbh->prepare($sqlSelect);
$result->execute();
$flag = false;
if ($result) {
	$row = $result->fetch(PDO::FETCH_ASSOC);
	$corp = $row["name"];
	if($corp != "")
	{
		$flag = true;
		$title = "Ceník ".$corp;
	}
}
if(!$flag)
{
	header("Location: http://".$_SERVER['HTTP_HOST']."/404");
}
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
		<link rel="stylesheet" href="/web/css/pricelist.css">
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
	"\t\t\t\t<article>\n";
include_once "../web/php/alert_loading.php";
$sqlSelect1 = "
SELECT local_ID,ID_package,name_package,price_month,category,name_tv,quality,foreign_tv
FROM
(
SELECT * FROM packages WHERE name_corporation='$corp'
)
JOIN tvs_in_package ON ID_package=ID
JOIN tvs ON name_tv=tvs.name
ORDER BY local_ID,category,name_tv
";
include_once "../web/php/szn_function.php";
$tvsfromdb = array();
$sth = $dbh->query($sqlSelect1);
while($row = $sth->fetch(PDO::FETCH_ASSOC))
{
	$key = $row["local_ID"];
	$category = $row["category"];
	$tv = $row["name_tv"];
	$quality = $row["quality"];
	$foreign = $row["foreign_tv"];
	if (isset($tvsfromdb[$key]))
	{
		if (isset($tvsfromdb[$key]['categories'][$category]))
		{
			array_push($tvsfromdb[$key]['categories'][$category], array("name"=>$tv,"quality"=>$quality,'foreign'=>$foreign));
		}
		else
		{
			$tvsfromdb[$key]['categories'][$category] = array(array("name"=>$tv,"quality"=>$quality,'foreign'=>$foreign));
		}
	}
	else
	{
		unset($row["category"]);
		unset($row["name_tv"]);
		unset($row["quality"]);
		unset($row["foreign"]);
		$tvsfromdb[$key] = $row;
		$tvsfromdb[$key]['categories'][$category] = array(array("name"=>$tv,"quality"=>$quality,'foreign'=>$foreign));
	}
}
echo
	"\t\t\t\t\t<p>Přehled balíčků:".
	"\t\t\t\t\t\t<span class='ref'>\n".
	"\t\t\t\t\t\t<img src='/web/img/info.svg' alt='info' class='ktooltip'>\n".
	"\t\t\t\t\t\t<span class='ktooltiptext'>Vyberte si balíček kliknutím na jeho název. Vybraný balíček je modře podbarvený.</span>\n".
	"\t\t\t\t\t</span>\n".
	"\t\t\t\t\t</p>".
	"\t\t\t\t\t<div id='pricelist_packagelist' style='display:none'>\n";
foreach ($tvsfromdb as $row)
{
	echo
		"\t\t\t\t\t\t<a href='#' class='pricelist_package ".$row["ID_package"]."' data-toggle='#".$row["ID_package"]."'><p>".
		$row["name_package"]."</p><p>".$row["price_month"]."</p></a>\n";
}
echo
	"\t\t\t\t\t</div>\n".
	"\t\t\t\t\t<p>Televize v balíčku rozdělené podle druhů:</p>";
foreach ($tvsfromdb as $package)
{
	echo
		"\t\t\t\t\t<div class='pay' id='".$package["ID_package"]."' style='display:none'>\n";
	foreach ($package["categories"] as $key => $category)
	{
		echo
			"\t\t\t\t\t\t<div class='category'><p>$key</p>\n";
		uasort($category, $sort_czech);
		foreach ($category as $tv)
		{
			$tvname = $tv["name"];
			$namepic = tv_name_to_web($tvname);
			$nametoGET = tv_name_to_GET_method($namepic);
			$namepic = ($tv["quality"]=="SD"?$namepic:(trim(substr($namepic, 0, strrpos($namepic, '_')))));
			$namepic = ($tv["foreign"]!=1?$namepic:(trim(substr($namepic, 0, strrpos($namepic, '_')))));
			echo
				"\t\t\t\t\t\t\t<div class='logo_list'>\n".
				"\t\t\t\t\t\t\t\t<a href='/detail/?name=$nametoGET'>\n".
				"\t\t\t\t\t\t\t\t\t<figure>\n".
				"\t\t\t\t\t\t\t\t\t\t<div class='logo_list_pic'>\n".
				"\t\t\t\t\t\t\t\t\t\t\t<img src='/web/img/tv/$namepic.svg' alt='$tvname'>\n".
				"\t\t\t\t\t\t\t\t\t\t</div>\n".
  			"\t\t\t\t\t\t\t\t\t\t<figcaption>$tvname</figcaption>\n".
				"\t\t\t\t\t\t\t\t\t</figure>\n".
				"\t\t\t\t\t\t\t\t</a>\n".
				"\t\t\t\t\t\t\t</div>\n";
		}
		echo
			"\t\t\t\t\t\t</div>\n";
	}
	echo
		"\t\t\t\t\t</div>\n";
}
?>
					<script src="/web/js/pricelist.js"></script>
				</article>
			</section>
			<?php include_once "../web/php/footer.php"; ?>
		</div>
		<script src="/web/js/ui.js"></script>
	</body>
</html>

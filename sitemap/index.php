<!doctype html>
<html lang="cs">
	<head>
		<title>Mapa webu | czechsatelit</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="Shortcut Icon" type="image/ico" href="/web/img/favicon.ico">
		<link rel="stylesheet" href="/web/css/side-menu.css">
		<link rel="stylesheet" href="/web/css/type.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
	"\t\t\t\t<h1>Mapa webu</h1>\n".
	"\t\t\t\t<article>\n".
	"\t\t\t\t\t<p><a href='../'>Hlavní stránka</a></p>\n".
	"\t\t\t\t\t<p><a href='../copyright/'>copyright</a></p>\n".
	"\t\t\t\t\t<p>Mapa webu</p>\n".
	"\t\t\t\t\t<p><a href='../list'>Vyhledávání televizí podle vlastností</a></p>\n".
	"\t\t\t\t\t<p>Poskytovatelé:</p>\n".
	"\t\t\t\t\t<ul class='list'>\n";
$sqlSelect = "SELECT name,abbr FROM corporations ORDER BY ID";
foreach ($dbh->query($sqlSelect) as $row)
{
	echo
		"\t\t\t\t\t\t<li>".$row["name"]."\n".
		"\t\t\t\t\t\t\t<ul>\n".
		"\t\t\t\t\t\t\t\t<li><a href='/pricelist/?corp=".$row["abbr"]."'>ceník</a>\n";
	if($row["name"] != "Magiosat SK")
		echo
			"\t\t\t\t\t\t\t\t<li><a href='/parameters/?corp=".$row["abbr"]."'>parametry</a>\n";
	echo
		"\t\t\t\t\t\t\t</ul>";
}
echo
	"\t\t\t\t\t</ul>";
?>
				</article>
			</section>
			<?php include_once "../web/php/footer.php"; ?>
			<script src="/web/js/sitemap.js"></script>
		</div>
		<script src="/web/js/ui.js"></script>
	</body>
</html>

<script>
$(document).ready(function () {
	$('#menu2').find('li').click(function(){
			sessionStorage.setItem("package_ID", null);
			sessionStorage.setItem("previous_tvs", null);
	});
});
</script>
<?php
if (!isset($_GET["corp"]))
	$_GET["corp"] = "";
echo
	"\t\t\t\t<p>Poskytovatelé:</p>\n".
	"\t\t\t\t<ul id='menu2'>\n";
include_once "connecttodb.php";
$sqlSelect_menu2 = "SELECT * FROM corporations ORDER BY ID";
foreach ($dbh->query($sqlSelect_menu2) as $row_menu2)
{
	echo
		"\t\t\t\t\t<li style=\"list-style-image:url('/web/img/nav/corp/".
		str_replace(" ", "_", $row_menu2["super_name"]).".svg')\">".$row_menu2["name"]."\n".
		"\t\t\t\t\t\t<ul>\n".
		"\t\t\t\t\t\t\t<li".
			"><a href='/pricelist/?corp=".$row_menu2["abbr"]."' title='ceník ".
			$row_menu2["name"]."'".
			((($_GET["corp"]==$row_menu2["abbr"]) && ($_SERVER["SCRIPT_URL"]=="/pricelist/"))?
			" class='pure-menu-selected'":"").">ceník</a>\n";
	if($row_menu2["abbr"] != "MS")
	echo
		"\t\t\t\t\t\t\t<li".
			"><a href='/parameters/?corp=".$row_menu2["abbr"]."' title='parametry ".
			$row_menu2["name"]."'".
			((($_GET["corp"]==$row_menu2["abbr"]) && ($_SERVER["SCRIPT_URL"]=="/parameters/"))?
			" class='pure-menu-selected'":"").">parametry</a>\n".
	"\t\t\t\t\t\t</ul>\n";
}
echo
	"\t\t\t\t</ul>\n";
?>

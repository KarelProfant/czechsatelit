<?php
echo
	"\t\t\t\t<a class='pure-menu-heading' ".
	"href='/'><img src='/web/img/nav/home.svg' alt='ikonka domu'></a>\n".
	"\t\t\t\t<p>Druhy programů:</p>\n".
	"\t\t\t\t<ul id='menu1'>\n";
include_once "connecttodb.php";
$sqlSelect_menu1 = "SELECT * FROM categories ORDER BY value";
foreach ($dbh->query($sqlSelect_menu1) as $row_menu1)
{
	echo
		"\t\t\t\t\t<li style=\"list-style-image:url('/web/img/nav/type/".
		$row_menu1["value"].".png')\">".
		"<a href='/list/'>".$row_menu1["value"]."</a>\n";
}
echo
	"\t\t\t\t\t<li style=\"list-style-image:url('/web/img/nav/type/všechny.png')\">".
		"<a href='/list/'>všechny</a>\n".
	"\t\t\t\t</ul>\n";
?>
<script>
$(document).ready(function () {
	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);
	$('#menu1').find('li').click(function(){
		sessionStorage.setItem("previous_qualities", JSON.stringify('all'));
		var name = this.getElementsByTagName('a')[0].innerHTML;
		if (name == "všechny")
		{
			//Všechny kategorie do pole.
			var sel = $('#menu1').find('li');
			all_categories = []
			for (var i=0, n=sel.length-1;i<n;i++)
			{
				all_categories.push(sel[i].getElementsByTagName('a')[0].innerHTML);
			}
			sessionStorage.setItem("previous_categories", JSON.stringify(all_categories));
		}
		else
		{
			sessionStorage.setItem("previous_categories", JSON.stringify(name));
		}
	});
});
</script>
<?
echo "\n";
?>

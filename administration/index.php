<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Web administraion</title>
<style>
nav {
	float: left;
	margin: 0;
	padding: 1em;
	border-right: 1px solid gray;
}
article {
	padding: 1em;
	overflow: hidden;
}
.zalozky-kompletmenu {
	padding: 1em;
	float: left;
}
.zalozky-menu {
	overflow: hidden;
	margin: 0;
	padding: 0;
	list-style: none;
}
.zalozky-menu li {
	float: left;
	padding-bottom: 0;
	margin-right: 0.5em;
}
.zalozky-menu a {
	position: relative;
	background-color: LightSkyBlue;
	padding: 0.1em;
	float: left;
	text-decoration: none;
	color: White;
	font-family: "Times New Roman", Times, serif;
}
.zalozky-menu a:hover,
.zalozky-menu a:focus {
	background-color: DeepSkyBlue;
	color: White;
}
.zalozky-menu #current a {
	background-color: DodgerBlue;
	color: White;
	z-index: 3;
	box-sizing: border-box;
}
.zalozky-content {
	padding: 1em;
}
div {
	display: none;
}
.zalozky-kompletmenu div,
.zalozky-content div {
	display: block;
}
#logout {
	position: relative;
	background-color: LightSkyBlue;
	padding: 0.1em;
	float: left;
	text-decoration: none;
	color: White;
	border: none;
	font-size: 1em;
	font-family: "Times New Roman", Times, serif;
	cursor: pointer;
}
</style>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">
// copyright: http://cssblog.antee.cz/blog/zalozky
    $(document).ready(
        function() {
            $(".zalozky-menu a").click(
                function(e) {
                    e.preventDefault();
                    if ($(this).closest("li").attr("id") != "current") {
                        $(".zalozky-content").find("div[id^='tab']").hide();
                        $(".zalozky-menu li").attr("id", "");
                        $(this).parent().attr("id", "current");
                        $('#tab-' + $(this).parent().attr('name')).fadeIn();
                        window.location.hash = "#" + $(this).parent().attr("name");
                    }
                }
            );
            $(".zalozky-content").find("[id^='tab']").hide();
            var anchor = window.location.hash;
            if (anchor) {
                anchor = anchor.substr(1);
                var element = window.document.getElementsByName(anchor)[0];
                if (element) {
                    $(".zalozky-menu li").attr("id","");
                    element.id = "current";
                    $(".zalozky-content #tab-" + anchor).fadeIn();
                } else {
                    $(".zalozky-menu li:first").attr("id", "current");
                    $(".zalozky-content div:first").fadeIn();
                }
            } else {
                $(".zalozky-menu li:first").attr("id", "current");
                $(".zalozky-content div:first").fadeIn();
            }
        }
    );
</script>
	</head>
	<body>
<?php
function check_login($username,$password)
{
	$database = array("adminKarel"=>"1qvcei4i");
	$find = array_search($username,(array_keys($database)));
	if($find === false)
	{
		return false;
	}
	else
	{
		if($database[$username] == $password)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
$again = false;
if (isset($_POST['logout']))
{
	session_destroy();
	$again = true;
}
else if (isset($_POST['submit']))
{
	$username=$_POST['username'];
	$password=$_POST['password'];
	if (!check_login($username,$password))
	{
		$again = true;
		echo
			"<script type='text/javascript'>".
			"alert('Username or password invalid!')".
			"</script>";
	}
	else
	{
		session_start();
	}
}
if ((session_status() == PHP_SESSION_NONE) && !count($_POST))
{
	$again = true;
}
if ($again == true):
?>
		<form method='post'>
			<h1>Admin login</h1>
			<table>
				<tr>
					<td>Username:
					<td><input name='username' type='text' id='username'>
				<tr>
					<td>Password:
					<td><input name='password' type='password' id='password'>
			</table>
			<input type='submit' name='submit' value='Login'>
			<input type='reset' name='reset' value='reset'>
		</form>
<?php
else:
include_once "../web/php/connecttodb.php";
?>
		<nav class="zalozky-kompletmenu">
			<div>
				<ul class="zalozky-menu">
					<li name="home"><a href="#">home</a></li>
					<li>
						<form method='post'>
							<input type='submit' name='logout' value='logout' id='logout'
								onmouseover="this.style.backgroundColor='DeepSkyBlue';return true;"
								onmouseout="this.style.backgroundColor='LightSkyBlue';return true;">
						</form>
					</li>
				</ul>
			</div>
<?php
$sections =
	Array(
		"category",
		"corporation",
		"language",
		"package",
		"parameter",
		"polarization",
		"position",
		"quality",
		"SATnorm",
		"supercorporation",
		"tv"
	);
$sections_do = Array("add", "edit", "delete");
for($i = 0; $i < count($sections); $i++)
{
	echo "\t\t\t<div>$sections[$i]\n";
	echo "\t\t\t\t<ul class='zalozky-menu'>\n";
	for($j = 0; $j < count($sections_do); $j++)
	{
		echo
			"\t\t\t\t\t<li name='$sections[$i]_$sections_do[$j]'>\n".
			"\t\t\t\t\t\t<a href='#'>$sections_do[$j]</a>\n".
			"\t\t\t\t\t</li>\n";
	}
	echo "\t\t\t\t</ul>\n";
	echo "\t\t\t</div>\n";
}
?>
		</nav>
		<article class="zalozky-content">
			<div id="tab-home">
				Hello!
			</div>
<?php
for($i = 0; $i < count($sections); $i++)
{
	for($j = 0; $j < count($sections_do); $j++)
	{
		echo "\t\t\t<div id='tab-$sections[$i]_$sections_do[$j]'>\n";
		echo "\t\t\t\t<h1>$sections[$i] $sections_do[$j]</h1>\n";
		include_once $sections[$i]."_".$sections_do[$j].".php";
		echo "\t\t\t</div>\n";
	}
}
?>
			<form method='post'>
				<input type='submit' name='dontclosesession' value='next demand'>
			</form>
		</article>
<?php
endif;
?>
	</body>
</html>

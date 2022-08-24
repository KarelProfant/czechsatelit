<!doctype html>
<html lang="cs">
	<head>
		<title>Copyright | czechsatelit</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="Shortcut Icon" type="image/ico" href="/web/img/favicon.ico">
		<link rel="stylesheet" href="/web/css/side-menu.css">
		<link rel="stylesheet" href="/web/css/type.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	</head>
	<body>
		<div id="layout">
<?php include_once "../web/php/menu_icon.php"; ?>
			<nav id="menu" class="pure-menu pure-menu-open">
<?php include_once "../web/php/menu1.php"; ?>
<?php include_once "../web/php/menu2.php"; ?>
			</nav>
<?php include_once "../web/php/header.php"; ?>
			<section>
				<h1>Copyright</h1>
				<article>
					<img src="/web/img/parabola.jpg" alt="paraboly" class="hppic" style="max-width: 100%">
					<p>
						<a href="http://byznys.lidovky.cz/televizi-pres-satelit-ci-kabel-prijima-uz-vic-nez-polovina-cechu-p8l-/media.aspx?c=A090803_134841_ln-media_aus" target="_blank">
							parabola v soumraku
						</a>
						,
						<a href="http://www.anteny-kladno.cz/" target="_blank">
							parabola na streše
						</a>
						,
						<a href="http://www.digizone.cz/clanky/piratsky-prijem-satelitni-platformy-digi-tv/" target="_blank">
							parabola na chatrči
						</a>
						,
						<a href="http://www.soundastic.tym.sk/pics/P1030265_TnT_omsenie.jpg" target="_blank">
							parabola na stromě
						</a>
						,
						<a href="http://byznys.ihned.cz/zpravodajstvi-cesko/c1-56038980-digitalni-televize-bez-poplatku-chce-penize-pres-milion-cechu-ceka-nemile-prekvapeni" target="_blank">
							parabola na štítu
						</a>
						,
						<a href="https://novadigitv.cz/" target="_blank">
							punkáč
						</a>
					</p>
					<p>
						<a href="https://www.svgrepo.com/svg/18599/menu" target="_blank">
							<img src="/web/img/nav/click.svg" alt="menu tlačítko">
						</a>
					</p>
					<p>
						<a href="https://www.svgrepo.com/svg/52943/home" target="_blank">
							<img src="/web/img/nav/home.svg" alt="home">
						</a>
					</p>
					<p>
						<a href="http://www.iconninja.com/yes-circle-mark-check-correct-tick-success-icon-459" target="_blank">
							<img src='http://czechsatelit.sweb.cz/web/img/tick/YES.svg#Layer_1' alt='ano' width='30em' height='30em'>
						</a>
						<a href="http://www.iconninja.com/invalid-circle-close-delete-cross-x-incorrect-icon-463" target="_blank">
							<img src='http://czechsatelit.sweb.cz/web/img/tick/NO.svg#Layer_1' alt='ne' width='30em' height='30em'>
						</a>
					</p>
					<p>
						<a href="https://codepen.io/nikhil8krishnan/pen/rVoXJa" target="_blank">
							<img src='../web/img/loading.svg' alt="načítání" width='100em'>
						</a>
					</p>
					<p>
						<a href="https://www.svgrepo.com/svg/60892/info" target="_blank">
							<img src='../web/img/info.svg' alt="info" width='100em'>
						</a>
					</p>
					<br>
					<a href="http://icons.mysitemyway.com/category/glossy-black-comment-bubbles-icons/" target="_blank">
<?php
include_once "../web/php/connecttodb.php";
$sqlSelect = "
SELECT *
  FROM categories
 ORDER BY value;
";
foreach ($dbh->query($sqlSelect) as $row)
{
?>
						<img src='/web/img/nav/type/<?php echo $row["value"]; ?>.png' alt='<?php echo $row["value"]; ?>'>
<?php
}
?>
					</a>

					<br>

					<a href="https://logos.fandom.com/wiki/Logopedia" target="_blank">většina log v svg</a>

					<br>

					<a href="https://purecss.io/menus/" target="_blank">menu</a>

					<br>

					<a href="https://select2.org/" target="_blank">vyhledávání</a>
				</article>
			</section>
<?php include_once "../web/php/footer.php"; ?>
		</div>
		<script src="/web/js/ui.js"></script>
	</body>
</html>

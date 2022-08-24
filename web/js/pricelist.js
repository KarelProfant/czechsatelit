$(document).ready(function () {
	//Zobrazí upozornění.
	document.getElementById('alert').style.display='block';
	//Načtení pamatováka.
	var stored = sessionStorage.getItem("package_ID");
	//Pokud je pamatovák prázdný, zvol první balíček.
  if (stored == 'null')
	{
    $(".pricelist_package:first").click();
  }
	//Zvol balíček z pamatováku.
	else
	{
    $("."+stored).click();
  }
	//Zobrazí seznam balíčků.
  document.getElementById('pricelist_packagelist').style.display='block';
	//Zobrazí upozornění.
  document.getElementById('alert').style.display='none';
});
$("a[data-toggle]").on("click", function(e) {
  e.preventDefault();  // prevent navigating
	//Id balíčku ke zobrazení.
  var selector = $(this).data("toggle");
	//Všechny balíčky skryje.
  $(".pay").hide();
	//Zvolený balíček zobrazí.
  $(selector).show();
	//Odstraní podbarvení u všech balíčků.
  $(".pricelist_package").css("background-color", "transparent");
	//Podbarví zvolený balíček.
  $(this).css("background-color", "Paleturquoise");
	//Zapíše zvolený balíček do pamatováku.
	sessionStorage.setItem("package_ID",$(selector)[0].id);
});

$(document).ready(function () {
	//inicializace vyhledávání
	$('#parameters_select').select2({
		placeholder: 'Zobrazeno všechno.',
		allowClear: true,
		language: "cs"
	});
	//Přístup z detailu televize.
	var storedArray = JSON.parse(sessionStorage.getItem("previous_tvs"));
	storedArray = Array.isArray(storedArray)?storedArray:Array(storedArray);
	if (storedArray != null)
	{
		//Nastaví ji jako zvolenou.
		$('#parameters_select').val(storedArray);
		//Dá o tom vědět vyhledávači.
		$('#parameters_select').trigger('change');
	}
});
$('#parameters_select').on('change', function (e)
{
	//Označené televize v proměnné.
	var selected = $('#parameters_select').find(':selected')
	var selecled_length = selected.length;
	all_selected_tvs = []
	for (var i=0, n=selecled_length;i<n;i++)
	{
		all_selected_tvs.push(selected[i].value);
	}
	//Zobraz všechny řádky.
	const rowtabArray = Array.from($('#parameters_tab').find('tr'))
	rowtabArray.forEach(rowtab => rowtab.style.display='table-row')
	//Zprůhledni pozadí u každé televize
	const teltexttabArray = Array.from($('#parameters_tab').find('a'))
	teltexttabArray.forEach(rowtab => rowtab.style.background='transparent')
	//Pokud není zvoleno nic, tak je již zobrazeno vše, jinak jsou vymazány všechny řádky tabulky kromě prvního.
	if (selected.length != 0)
	{
		rowtabArray.forEach(rowtab => rowtab.style.display='none')
		$('#rowtab')[0].style.display='table-row'
	}
	//Obarví pozadí zvolených televizí a zobrazí jejich řádky tabulky.
	Array.from(selected, child =>
	{
		document.getElementById(child.value).style.background = "yellow"
		document.getElementById(child.value).parentNode.parentNode.parentNode.style.display='table-row'
	});
	//Zápis do pamatováka.
	window.sessionStorage.setItem("previous_tvs", JSON.stringify(all_selected_tvs));
});

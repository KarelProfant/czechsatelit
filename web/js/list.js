//Všechny kategorie do pole.
var sel = $('#list_select_categories').find('option');
var all_categories = []
for (var i=0, n=sel.length;i<n;i++)
{
	all_categories.push(sel[i].value);
}
//Všechny kvality do pole.
var sel = $('#list_select_qualities').find('option');
var all_qualities = []
for (var i=0, n=sel.length;i<n;i++)
{
	all_qualities.push(sel[i].value);
}
$(document).ready(function () {
	document.getElementById('alert').style.display='block';
	//inicializace vyhledávání
	$('#list_select_categories').select2({
		placeholder: 'Vyberte druh.',
		allowClear: false,
		language: "cs"
	});
	$('#list_select_qualities').select2({
		placeholder: 'Vyberte kvalitu.',
		allowClear: false,
		language: "cs"
	});
	//Přístup s pamatovákem.
	var storedArray_categories = JSON.parse(sessionStorage.getItem("previous_categories"));
	storedArray_categories = Array.isArray(storedArray_categories)?storedArray_categories:Array(storedArray_categories);
	if (storedArray_categories != null)
	{
		//Nastaví je jako zvolené.
		$('#list_select_categories').val(storedArray_categories);
		//Dá o tom vědět vyhledávači.
		$('#list_select_categories').trigger('change');
	}
	var storedArray_qualities = JSON.parse(sessionStorage.getItem("previous_qualities"));
	storedArray_qualities = Array.isArray(storedArray_qualities)?storedArray_qualities:Array(storedArray_qualities);
	if (storedArray_qualities != null)
	{
		if (storedArray_qualities == 'all')
		{
			$('#list_select_qualities_all').click();
		}
		else
		{
			//Nastaví je jako zvolené.
			$('#list_select_qualities').val(storedArray_qualities);
			//Dá o tom vědět vyhledávači.
			$('#list_select_qualities').trigger('change');
		}
	}
	document.getElementById('alert').style.display='none';
});
$('#list_select_categories').on('change', function (e)
{
	//Označené druhy v proměnné.
	var selected = $('#list_select_categories').find(':selected')
	var selecled_length = selected.length;
	all_selected_categories = []
	for (var i=0, n=selecled_length;i<n;i++)
	{
		all_selected_categories.push(selected[i].value);
	}
	//Změní položky.
	change_items();
	//Zápis do pamatováka.
	window.sessionStorage.setItem("previous_categories", JSON.stringify(all_selected_categories));
});
$('#list_select_qualities').on('change', function (e)
{
	//Označené druhy v proměnné.
	var selected = $('#list_select_qualities').find(':selected')
	var selecled_length = selected.length;
	all_selected_qualities = []
	for (var i=0, n=selecled_length;i<n;i++)
	{
		all_selected_qualities.push(selected[i].value);
	}
	//Změní položky.
	change_items();
	//Zápis do pamatováka.
	window.sessionStorage.setItem("previous_qualities", JSON.stringify(all_selected_qualities));
});
document.getElementById('list_select_categories_all').onclick = function() {
	//Nastaví všechny kategorie jako zvolené a dá o tom vědět vyhledávači.
	$('#list_select_categories').val(all_categories).trigger('change');
};
document.getElementById('list_select_categories_nothing').onclick = function() {
	//Nastaví všechny kategorie jako nezvolené a dá o tom vědět vyhledávači.
	$('#list_select_categories').val(null).trigger('change');
};
document.getElementById('list_select_qualities_all').onclick = function() {
	//Nastaví všechny kvality jako zvolené a dá o tom vědět vyhledávači.
	$('#list_select_qualities').val(all_qualities).trigger('change');
};
document.getElementById('list_select_qualities_nothing').onclick = function() {
	//Nastaví všechny kvality jako nezvolené a dá o tom vědět vyhledávači.
	$('#list_select_qualities').val(null).trigger('change');
};
function change_items()
{
	//Označené druhy v proměnné.
	var selected = $('#list_select_categories').find(':selected')
	var selecled_length = selected.length;
	all_selected_categories = []
	for (var i=0, n=selecled_length;i<n;i++)
	{
		all_selected_categories.push(selected[i].value);
	}
	//Označené kvality v proměnné.
	var selected = $('#list_select_qualities').find(':selected')
	var selecled_length = selected.length;
	all_selected_qualities = []
	for (var i=0, n=selecled_length;i<n;i++)
	{
		all_selected_qualities.push(selected[i].value);
	}
  var input, filter, li, a, i, txtValue;
  input = document.getElementById("list_select_name");
  filter = input.value.toUpperCase();
  li = document.getElementsByClassName("list_item");
	var blue = true;
  for (i = 0; i < li.length; i++)
	{
    a = li[i].getElementsByTagName("p")[0];
    txtValue = a.textContent || a.innerText;
    if
		(
			(txtValue.toUpperCase().indexOf(filter) > -1) && //Filtr jména.
			all_selected_categories.includes(li[i].className.split(" ")[1]) &&//Filtr druhu.
			all_selected_qualities.includes(li[i].className.split(" ")[2]) //Filtr kvality.
		)
		{
      li[i].parentElement.style.display = "block";
			li[i].style.backgroundColor = (blue?"Paleturquoise":"PaleGreen");
			blue = !blue;
    }
		else
		{
      li[i].parentElement.style.display = "none";
    }
  }
}

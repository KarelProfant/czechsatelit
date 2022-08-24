$(document).ready(function () {
	//Data do pamatováku pro odkazy na parametry a balíčky.
	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);
	const name = urlParams.get('name')
	$('#detail_package_list').find('a').click(function(){
		sessionStorage.setItem("previous_tvs", JSON.stringify(name));
		sessionStorage.setItem("package_ID", $(this).attr('class'));
	});
});

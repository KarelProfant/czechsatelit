//Data do pamatováku pro odkazy na parametry a balíčky.
$(document).ready(function () {
	$('.list').find('a').click(function(){
			sessionStorage.setItem("package_ID", null);
			sessionStorage.setItem("previous_tvs", null);
	});
});

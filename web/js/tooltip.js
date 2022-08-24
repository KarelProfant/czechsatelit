$(document).ready(function () {
	$(".ktooltip").mouseover(function(e) {
		var tooltip = $(this).siblings('.ktooltiptext'); // Get tooltip element (ktooltiptext)
		var arrow = tooltip[0].children[0]; // Get arrow element
		var tooltip_rect = tooltip[0].getBoundingClientRect(); // Get calculated tooltip coordinates and size
		// Put tooltip over the text
		var tipY = -tooltip_rect.height - 10; // 5px on the top of the text
		tooltip.css({top: tipY}); // Position tooltip
		// Try to put right of the text
		var tipX = -15; // 0px on the right of the text
		tooltip.css({left: tipX}); // Position tooltip
		// Check if tooltip fits in window on right
		var tooltip_rect = tooltip[0].getBoundingClientRect(); // Get calculated tooltip coordinates and size
		if ((tooltip_rect.x + tooltip_rect.width) > $(window).width())
		{
			// Try to put left of the text
			tipX = -tooltip_rect.width + $(this).outerWidth() + 15;
		}
		tooltip.css({left: tipX}); // Position tooltip
		//Check if tooltip fits in window on left
		var tooltip_rect = tooltip[0].getBoundingClientRect(); // Get calculated tooltip coordinates and size
		if(tooltip_rect.x < 0)
		{
			tipX += -tooltip_rect.x + 5; // 0px on the right of the text
		}
		tooltip.css({left: tipX}); // Position tooltip
		tooltip.css({visibility:'visible'});
		var tooltip_rect = tooltip[0].getBoundingClientRect(); // Get calculated tooltip coordinates and size
		arrow.style.left = Math.round(this.getBoundingClientRect().x-tooltip_rect.x-5).toString() + "px";
	});
	$(".ktooltip").mouseout(function(e) {
		var tooltip = $(this).siblings('.ktooltiptext'); // Get tooltip element (ktooltiptext)
		tooltip.css({visibility:'hidden'});
	});
	$('.ktooltiptext').prepend($('<div/>').addClass("close"));
	$('.ktooltiptext').prepend($('<div/>').addClass("arrow"));
	$(".close").click(function(e) {
		this.parentElement.style.visibility = 'hidden';
	});
});

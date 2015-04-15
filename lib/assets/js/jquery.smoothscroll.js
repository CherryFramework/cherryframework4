// smooth mousewheel scroll
if (window.addEventListener) window.addEventListener('DOMMouseScroll', wheelEvent, false);
window.onmousewheel = document.onmousewheel = wheelEvent;

function wheelEvent(event) {
	var delta = 0;
	if (event.wheelDelta) delta = event.wheelDelta / 120;
	else if (event.detail) delta = -event.detail / 3;

	wheelHandle(delta);
	if (event.preventDefault) event.preventDefault();
	event.returnValue = false;
}

function wheelHandle(delta) {
	var
		time = 500 // delay time
	,	distance = 350 // delta point
	;
	// Dom where it will apply
	jQuery('html, body').stop().animate({
		scrollTop: jQuery(window).scrollTop() - (distance * delta)
	}, time );
}
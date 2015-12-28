$doc.ready(function() {

	// Make canvas content as tall as possible
	var $main = $('#main'), height = Math.max($doc.height(), $(window).height());

	if($main.height() < height)
		$main.height(height);

});

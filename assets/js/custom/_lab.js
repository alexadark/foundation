(function($) {
	$(
		'.blog .tease-post:nth-child(3),.blog .tease-post:nth-child(4), .blog .tease-post:nth-child(5)'
	).addClass('tease-post--small')
	$('.tease-post--small').wrapAll("<div class='small-posts-wrapper'/>")

	/*<a href="http://foundationnew.wpengine.com/wp-content/uploads/2019/05/GreenSock-Cheatsheet-4.pdf" class="button button--green" download="">Download now
	<img src="/wp-content/themes/foundation-theme/assets/img/dl-green.svg" alt=""></a>*/
})(jQuery);

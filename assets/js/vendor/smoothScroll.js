function smoothScroll(){
	$("a[href^='#']").on('click', function(event) {
		if (this.hash !== "") {
			event.preventDefault();
			if (this.hash == "#masthead") {
				$('html, body').animate({
					scrollTop: 0
				}, 800, function(){
				});
			} else {
				let hash = this.hash;
				$('html, body').animate({
					scrollTop: $(hash).offset().top
				}, 800, function(){
				});
			}
		};
	});
}

function slideDown(){
    let counter = 1;
    $('section').each(function(){
        counter++;
        let toDown          = $(this).find('.arrow-to-next');
        let sectionNextName = 'section[data-id="section-' + counter + '"]';
        let sectionNextId   = $(sectionNextName).attr('id');
        toDown.attr('href', '#' + sectionNextId);
    });
}

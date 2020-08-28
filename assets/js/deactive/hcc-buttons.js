jQuery( document ).ready(function($) {
    const switcher   = $('.switcher');
    const ButtonWrap = $('.contact-button-wrap');
  
    if($("*").is( switcher )){ 
      //switcherTheme( switcher );
    }
    
    
    if($("*").is( ButtonWrap )){ 
      //FeedBackButton( ButtonWrap ); //Enable contact button
    }
});

function switcherTheme( switcher ){
    switcher.on('click', function(){
        let ButtonWrap = $('.contact-button-wrap');
        ButtonWrap.removeClass('active');
        ButtonWrap.find('.button-tel').removeClass('active');
        ButtonWrap.find('.buttons-socials').removeClass('active');
    });
    switcher.find('.light-theme').on('click', function(){
            switcher.removeClass('moon').addClass('sun');
            $('section').removeClass('dark-theme').addClass('light-theme');
            switcher.attr('data-theme', 'light-theme');
    });
    switcher.find('.dark-theme').on('click', function(){
            switcher.removeClass('sun').addClass('moon');
            $('section').removeClass('light-theme').addClass('dark-theme');
            switcher.attr('data-theme', 'dark-theme');
    });
}

function FeedBackButton( container ){
    let button = container.find('.button-tel');
    button.on('click', function(){
       container.toggleClass('active'); 
       $(this).toggleClass('active'); 
       $(this).siblings('.buttons-socials').toggleClass('active');
    });
    container.find('.one-social').on('click', function(e){
            if( $(this).hasClass('message') ){
                e.preventDefault();
                if( customModalStatus !== 'false' && customModalStatus !== 0 ) {
                  showStronglyForm( $('.modal-form') );
                }
            }
            setTimeout( hideFeedBackInner, 200, container );
    });
    container.on('click', function(e){
            hideFeedBackInner( container );
    }).on('click', 'div', function(e) {
            e.stopPropagation();
    });
}

function hideFeedBackInner( ButtonWrap ){
       ButtonWrap.removeClass('active'); 
       ButtonWrap.find('.button-tel').removeClass('active'); 
       ButtonWrap.find('.buttons-socials').removeClass('active');
}

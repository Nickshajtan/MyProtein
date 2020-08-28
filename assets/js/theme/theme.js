/**
*  Theme js functions
*
*/

jQuery( document ).ready(function($) {
    Loader(); //site preloader
    StickyHeader();
    SectionListWrapper();
    overlayHide();
    mobileMenu();
    fancyboxInitial(); //Including Fancybox
  
    $reviews();
});

function SectionListWrapper() {
  $('section').find('ol>li').wrapInner("<span></span>");
}

function fancyboxInitial(){
    try{
        $('.fancybox').fancybox({protect: true, cyclic:true});
    }
    catch(e){
          console.log('Problem with Fancybox jQuery plugin' + e);
    }   
}

function overlayHide(){
    $('.overlay').on('click', function(){
        $(this).removeClass('on');
        $('body').removeClass('noscroll modal-open');
        $('.burger').removeClass('active');
        $('#masthead').removeClass('opened').addClass('closed');
    });
}

function StickyHeader(){
  const nav    = $('#masthead');
  let mywindow = $(window);
  let mypos    = mywindow.scrollTop();
  let up       = false;
  let newscroll;
  if ( $(window).width() > 1200 ) {
      $(window).scroll(function () {
          newscroll = mywindow.scrollTop();
          if ($(this).scrollTop() > 0) {
              nav.addClass("sticky");
          }else{
              nav.removeClass("sticky");
          }
          mypos = newscroll;
      });
  }
}

function mobileMenu( Burger, ButtonWrap ){
    
    const MenuBurger = ( typeof(Burger) === 'undefined' ) ? $('.burger') : Burger;  
    const header     = $('#masthead');
    const overlay    = $('.overlay');
  
    MenuBurger.on('click', function(){
        $(this).toggleClass('active');
        header.toggleClass('opened closed');
        $('body').toggleClass('noscroll modal-open');
        overlay.toggleClass('on');
      
        if (typeof ButtonWrap !== 'undefined' && typeof ButtonWrap !== false ) {
          ButtonWrap.removeClass('active'); 
          ButtonWrap.find('.button-tel').removeClass('active'); 
          ButtonWrap.find('.buttons-socials').removeClass('active');
        }
    });
        
    $('nav').find('.inside-link').on('click',function(){
            MenuBurger.removeClass('active');
            header.removeClass('opened');
            $('body').removeClass('noscroll modal-open');
            overlay.removeClass('on');
    });
}


let $reviews = function() {
  $('.reviews-section').find('article').each(function(){
    $(this).on('hover', function(){
      console.log('hover');
      $(this).addClass('col-lg-9 col-xl-6').removeClass('col-lg-4 col-xl-3');
    });
    $(this).on('mouseleave', 'article', function(){
      console.log('hover');
      $(this).addClass('col-lg-4 col-xl-3').removeClass('col-lg-9 col-xl-6');
    });
    
  });
};

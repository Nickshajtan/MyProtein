jQuery( document ).ready(function($) {
  waterweellCarousel(); //  Waterweell jQuery slider
  SlickCarousel(); //  Slick jQuery slider
});

//  Slick jQuery slider
function SlickCarousel(){
      try{
          const SlickSlider = $('.slick-slider');
          if($("div").is( SlickSlider )){
                
                SlickSlider.each(function(){
                   $(this).slick({
                        infinite: false,
                        arrows: true,
                        dots: false,
                        prevArrow:"<button type='button' class='slick-prev pull-left'><img src='" + hcc_js_custom_params.theme_url + "img/icons/arrow-left.svg'></button>",
                        nextArrow:"<button type='button' class='slick-next pull-right'><img src='" + hcc_js_custom_params.theme_url + "img/icons/arrow-right.svg'></button>",
                        appendArrows: $('.slider-navigation'),
                        slidesToShow: 1,
                        autoplay: true,
                        autoplaySpeed: 8000,
                   }); 
                }); 
                
            }
      }
      catch(e){
          console.log('Problem with Slick jQuery plugin'+ e);
      }   
}

//  Waterweell jQuery slider
function waterweellCarousel(){
      try{
          let waterwallSlider = $('.waterwall-slider');
          let reviewsWrap     = $('.reviews-wrap');
          
          if($("div").is( waterwallSlider )){
                
                waterwallSlider.each(function(){
                   var nextArrow  = reviewsWrap.find('.review-next');
                   var prevArrow  = reviewsWrap.find('.review-prev');
                   var carousel   = $(this).waterwheelCarousel({
                        startingItem:1,
                        opacityMultiplier:1,
                        flankingItems:2,
                        linkHandling:1,
                        keyboardNav:true,
                        imageNav:false,
                    });
                    if(nextArrow){
                          nextArrow.on('click', function(){
                              carousel.next();
                              return false;
                          });
                    }
                    if(prevArrow){
                          prevArrow.on('click', function(){
                              carousel.prev();
                              return false;
                          });
                    }
          
                }); 
                
          }
          
      }
      catch(e){
          console.log('Problem with Waterweell jQuery plugin' + e);
      }   
}
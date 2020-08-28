jQuery( document ).ready(function($) {
    //Loader();
});

// Preloader
function Loader(){
    $(function(){
        $preloader = $('.loaderArea'),
        $loader    = $preloader.find('.loader');
        $loader.fadeOut();
        $preloader.delay(450).fadeOut('slow');
        //Modal form. Show & Hide
        if( customModalStatus !== 'false' && customModalStatus !== 0 ) {
            modalForms(); 
        }
    });
}

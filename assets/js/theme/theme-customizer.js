jQuery(function( $ ) {
   
   try{
       if( false ){
        //Links
        wp.customize( 'hcc_link_color', function( value ) {
            value.bind( function( to ) {
                $( 'a' ).css( 'color', to );
            } );
        });
        //Color scheme
        wp.customize( 'hcc_color_scheme', function( value ) {
		  value.bind( function( to ) {
                if ( 'inverse' === to ) {
                    $( 'body' ).css({ // в данном примере мы меняем только цвет фона и текста
                        'background-color': '#000', // черный фон
                        'color':      '#fff' // белый текст
                    });
                } else {
                    $( 'body' ).css({
                        'background-color': '#fff', // белый фон
                        'color':      '#000' // черный цвет текста
                    });
                }
            });
        });
        //Fonts
        var sFont;
        wp.customize( 'hcc_font', function( value ) {
            value.bind( function( to ) {
                switch( to.toString().toLowerCase() ) {
                    case 'arial':
                        sFont = 'Arial, Helvetica, sans-serif';
                        break;
                    case 'courier':
                        sFont = 'Courier New, Courier';
                        break;
                    default:
                        sFont = 'Arial, Helvetica, sans-serif';
                        break;
                }
                $( 'body' ).css({
                    fontFamily: sFont 
                });
            });
        });
        //Background
        wp.customize( 'hcc_background_image', function( value ) {
            value.bind( function( to ) {
                0 === $.trim( to ).length ? $( 'body' ).css( 'background-image', '' ) : $( 'body' ).css( 'background-image', 'url( ' + to + ')' );
            });
        });
        //Header
        wp.customize( 'hcc_display_header', function( value ) {
            value.bind( function( to ) {
                false === to ? $( '#header' ).hide() : $( '#header' ).show();
            } );
        });
        wp.customize( 'hcc_header_background_image', function( value ) {
            value.bind( function( to ) {
                0 === $.trim( to ).length ? $( 'header' ).css( 'background-image', '' ) : $( 'header' ).css( 'background-image', 'url( ' + to + ')' );
            });
        });
   }
   }
   catch(e){
        console.log('Problem with WP customizer JS');
   }
    
});
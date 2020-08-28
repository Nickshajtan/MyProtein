jQuery( document ).ready(function($) {
  //iasInitial( elem );
  //WaipointsInitial( name );
});

function iasInitial( elem ){
    try{
        let name            = elem.attr('data-ias');
        if( typeof name ==="undefined" || name === null || name === '' ){
            return false;
        }
        let containerClass  = name + '-container';
        let container       = elem.find('.ias-container').addClass( containerClass );
        containerClass      = '.' + containerClass;
        let itemClass       = name + '-item';
        let item            = elem.find('.ias-item').addClass( itemClass );
        itemClass           = '.' + itemClass;
        let paginationClass = 'pagination-' + name;
        let pagination      = elem.find('.pagination').addClass( paginationClass );
        paginationClass     = '.pagination.' + paginationClass;
        let nextClass       = 'next-' + name;
        let next            = pagination.find('.next.page-numbers').addClass( nextClass );
        nextClass           = '.page-numbers.' + nextClass;
          
        var ias = $.ias( {
                      container:  containerClass,
                      item:       itemClass,
                      pagination: paginationClass,
                      next:       nextClass,
                     //loader      : "<img src='/img/loading.gif'>",
        });
        
        console.log( ias );

        ias.extension( new IASTriggerExtension( { offset: 1 } ) );
        ias.extension( new IASSpinnerExtension() );
        ias.extension( new IASNoneLeftExtension() );
            
    }
    catch(e){
          console.log('Problem with Ias jQuery plugin');
    }   
}

function WaipointsInitial( name ){
        try{
            let data            = name.attr('data-ias');
            let paginationClass = data + '-next';
            let itemClass       = data + '-item';
            let item            = name.find('.infinite-item').addClass(itemClass);
            itemClass           = '.' + itemClass;
            let paginationNext  = name.find('.next.page-numbers').addClass(paginationClass);
            paginationClass     = '.' + paginationClass;
            var infinite = new Waypoint.Infinite({
              element: name.find('.infinite-container')[0],
              container: 'auto',
              items: itemClass,
              loadingClass: 'infinite-loading',
              more: paginationClass,
              offset: 'bottom-in-view',
              onBeforePageLoad: $.noop,
              onAfterPageLoad: $.noop
            }); 
        }  
        catch(e){
            console.log('Problem with Waipoints jQuery plugin');
        }
}
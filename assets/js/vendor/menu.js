/*
*  Menu active links
*
*/

jQuery(function ($){
    
    let location = window.location.href;
    let cur_url  = location.split('/').pop();
    let lastId;
    let header        = $("#masthead");
    let topMenu       = header.find('.menu'),
        topMenuHeight = header.outerHeight()+15,
        menuItems     = topMenu.find("a.inside-link"),
        menuItemsAll  = topMenu.find('a');
    
    if( menuItemsAll.length ){
        LoadActiveLinks( topMenu, menuItemsAll );
    }
    if( menuItems.length ){
        ScrollActiveLinks( menuItems, menuItemsAll, topMenuHeight );   
    }
    
    function ScrollActiveLinks( menuItems, menuItemsAll, topMenuHeight ){
        
        try{
            let isResizeble = true;
            let scrollItems   = menuItems.map(function(){
                  let item = $($(this).attr("href").split('/').pop());
                  if (item.length){ 
                      return item; 
                  }
            });
            $(window).one('mousewheel', function(){
                if(isResizeble) {
                    menuItemsAll.removeClass("current-link").parent().filter('.menu-item-type-custom').removeClass("current-menu-item");
                    isRezeble = false;
                }
            });
            $(window).on('scroll', function(){
                setTimeout(
                    function() { menuItemsAll.blur() }, 1000
                );

                let fromTop = $(this).scrollTop()+topMenuHeight;
                var cur     = scrollItems.map(function(){
                    if ($(this).offset().top < fromTop){
                        return this;
                    }
                });
                cur    = cur[cur.length-1];
                let id = cur && cur.length ? cur[0].id : "";
                if( id === ""){
                    menuItems.removeClass("current-link").parent().removeClass("current-menu-item");
                }
                if(lastId !== id){
                   lastId = id;
                   menuItems.removeClass("current-link").parent().removeClass("current-menu-item").end().filter("[href='#"+id+"']").addClass('current-link').parent().addClass("current-menu-item");
                }
            });    
        }
        catch(e){
            console.log('Problem with menu Scroll Active Links script');
        }
        
    }
    
    function LoadActiveLinks( topMenu, menuItemsAll ){
       try{
            let isResizeble = true;
            if(isResizeble) {
                menuItemsAll.removeClass("current-link").parent().filter('.menu-item-type-custom').removeClass("current-menu-item");
                isRezeble = false;
            }
            topMenu.find('li').each(function(){
                let link = $(this).find('a').attr('href');
                if(cur_url == link){
                    $(this).find('a').addClass('current-link');
                }
            });
       }
       catch(e){
           console.log('Problem with menu Load Active Links script');
       }
    }
});
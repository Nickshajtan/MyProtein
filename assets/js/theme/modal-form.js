jQuery( document ).ready(function($) {
    //modalForms();
});

function modalForms(){
    let href = window.location.href.toLowerCase();
    if( is_404_url !== 'true' && href.indexOf( cfThankYou.toLowerCase() ) === -1 ){
        let modalForm = $('.modal-form');
        //Out
        if ( $(window).width() > 1200 ) {
                    setTimeout( showFormOut, 500, modalForm );
        }
        setInterval(showFormOut, 59000, modalForm);
        //Once
        setTimeout(showForm, 60000, modalForm);    
    }
    
    //Esc
    $(document).keydown(function(eventObject){
                if (eventObject.which == 27){ 
                            hideForm( $('.modal-form') ); 
                }
    });
    //click out form close
    $('.modal-wrapper').on('click', function(e){
            hideForm( $('.modal-form') );  
    }).on('click', 'div', function(e) {
            e.stopPropagation();
    });
    //click on close icon
    $('.modal').find('.closer').on('click', function(){
            hideForm( $('.modal-form') );
    });
}

function showForm(form){
  try {
    if( !$('.modal-error').hasClass('show-visible') && !$('form').hasClass('on-focus') && !$('.contact-button-wrap').hasClass('active') ){
        var header  = $('#masthead');
        if( !header.hasClass('opened') && !$('.contact-button-wrap').hasClass('active') ){
                if($("*").is( form )){
                  form.addClass('show-visible');
                  $('body').addClass('noscroll modal-open');
                }
        }
    }
  }
  catch(e) {
    console.log('Problem with showForm script ' + e);
  }
}

function showStronglyForm(form){
  try {
    const header  = $('#masthead');
    if( !header.hasClass('opened') ){
            if($("*").is( form )){
                $(form).addClass('show-visible');
                $('body').addClass('noscroll modal-open');
            }
   }
  }
  catch(e) {
    console.log('Problem with showStronglyForm script ' + e);
  }
}

function hideForm( el ){
  try {
    
    const form = (typeof form === 'undefined') ? $('.modal-form') : el;
  
    if($("*").is( form )){
      let $form      = form.find('form');
      let $input     = $form.find('input');
      let $textarea  = $form.find('textarea');
      let $group     = $form.find('.validation-group');
      $('.modal').removeClass('show-visible');
      $form.removeClass('validated-success validated-unsuccess was-validated ');
      $group.removeClass('validated-invalid validated-valid validated-warning group-was-validated');
      $group.find('.form-element-validation').removeClass('element-was-validated');
      $input.not('[type=submit]').val('');
      $textarea.val('');
    }
  
    $('body').removeClass('noscroll modal-open');
    $('.overlay').removeClass('on');
    
    if( typeof hideFeedBackInner === 'function' ) {
      hideFeedBackInner(); 
    }
  }
  catch(e) {
    console.log('Problem with hideForm script ' + e);
  }
}

function hideThisForm(el){
  try {

    const form = (typeof form === 'undefined') ? $('.modal-form') : el;

    if($("*").is( form )){
        let $form      = $(this).find('form');
        let $input     = $(this).find('input');
        let $textarea  = $(this).find('textarea');
        let $group     = $(this).find('.validation-group');
        form.removeClass('show-visible');
        $form.removeClass('validated-success validated-unsuccess was-validated ');
        $group.removeClass('validated-invalid validated-valid validated-warning group-was-validated');
        $group.find('.form-element-validation').removeClass('element-was-validated');
        $input.not('[type=submit]').val('');
        $textarea.val('');
    }

    $('body').removeClass('noscroll modal-open');
    $('.overlay').removeClass('on');

    if( typeof hideFeedBackInner === 'function' ) {
      hideFeedBackInner(); 
    }
  }
  catch(e) {
    console.log('Problem with hideThisForm script ' + e);
  }
}

function showFormOut(form){
        if( !$('.modal-error').hasClass('show-visible') && !$('.contact-button-wrap').hasClass('active') && !$('form').hasClass('on-focus') ){
            $(document).on('mouseleave', function(e){
                    if ( e.clientY < 0 ) {
                                    showForm(form);
                    }     
                    $(this).off('mouseleave');
            });
        }
}
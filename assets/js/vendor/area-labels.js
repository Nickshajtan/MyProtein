jQuery( document ).ready(function($) {
  ElsAreaLabelledby( document.find('a') );
  ElsAreaLabelledby( document.find('input') );
  ElAreaLabel($('.close, #close'), 'Close');
  ElAreaLabel($('.open, #open'), 'Open');
});

// Els = array of DOM els
function ElsAreaLabelledby(els) {
  els.each(function(){
    let attr = $(this).attr('aria-labelledby');
    let text = $(this).text();
    
    if( typeof attr === 'undefined' && typeof text !== 'undefined' ) {
      $(this).attr('aria-labelledby', text);
    }
  });
}

// Single DOM el
function ElAreaLabel(el, text) {
  let attr = el.attr('aria-labelledby');
  
  if( typeof attr === 'undefined' && typeof text !== 'undefined' ) {
    el.attr('aria-label', text);
  }
}

jQuery( document ).ready(function($) {
  const wpcf7Elm = document.querySelectorAll( '.wpcf7' );
});

/*
 * Form was send on server, but was stopped because has incorrect values
 *
 */
function hcc_wpcf7_invalid( form ) {
  try {
    if( typeof form !== 'object' ) {
      throw new Error('Can not start with out element');
      return false;
    }
    
    form.on('wpcf7invalid', function(e){
      // Paste your code here
    });
  }
  catch(e) {
    console.log(e);
  }
}

/*
 * Form was send on server, but stopped via spam
 *
 */
function hcc_wpcf7_spam( form ) {
  try {
    if( typeof form !== 'object' ) {
      throw new Error('Can not start with out element');
      return false;
    }
    
    form.on('wpcf7spam', function(e){
      // Paste your code here
    });
  }
  catch(e) {
    console.log(e);
  }
}

/*
 * Form was successfuly send on server
 *
 */
function hcc_wpcf7_mailsent( form ) {
  try {
    if( typeof form !== 'object' ) {
      throw new Error('Can not start with out element');
      return false;
    }
    
    form.on('wpcf7mailsent', function(e){
      // Paste your code here
    });
  }
  catch(e) {
    console.log(e);
  }
}

/*
 * Form was successfuly send on server, but crushed
 *
 */
function hcc_wpcf7_mailfailed( form ) {
  try {
    if( typeof form !== 'object' ) {
      throw new Error('Can not start with out element');
      return false;
    }
    
    form.on('wpcf7mailfailed', function(e){
      // Paste your code here
    });
  }
  catch(e) {
    console.log(e);
  }
}

/*
 * Form was successfuly send on server
 *
 */
function hcc_wpcf7_submit( form ) {
  try {
    if( typeof form !== 'object' ) {
      throw new Error('Can not start with out element');
      return false;
    }
    
    form.on('wpcf7submit', function(e){
      // Paste your code here
    });
  }
  catch(e) {
    console.log(e);
  }
}

/*
 * Before submiting
 *
 */
function hcc_wpcf7_beforesubmit( form ) {
  try {
    if( typeof form !== 'object' ) {
      throw new Error('Can not start with out element');
      return false;
    }
    
    form.on('wpcf7beforesubmit', function(e){
      // Paste your code here
    });
  }
  catch(e) {
    console.log(e);
  }
}


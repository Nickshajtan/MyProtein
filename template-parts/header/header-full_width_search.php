<?php
/*
 * Display the widgets for Search area
 *
 *
 */
if( is_active_sidebar( 'Search' ) ) : ?>
	    <div class="container-fluid full-width-search">
	      <div class="row-fluid">
	        <div class="col-12">
	           <?php dynamic_sidebar( 'Search' ); ?>
	        </div>
	      </div>
	    </div>
<?php endif; ?>

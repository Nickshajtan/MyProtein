<?php
/*
 * Filters the array of arguments used when generating the search form
 *
 */

add_filter( 'search_form_args', function( $args ){
  return $args;
});

/*
 * Filters the query arguments for a search request.
 * Enables adding extra arguments or setting defaults for a post search request
 *
 */

add_filter( 'rest_post_search_query', function( $query_args, $request ){
  return $query_args;
});

/*
 * Filters the prefix that indicates that a search term should be excluded from results.
 *
 */

add_filter( 'wp_query_search_exclusion_prefix', function( $exclusion_prefix ){
  return $exclusion_prefix;
});

/*
 * Filters the minimum number of characters required to fire a tag search via Ajax.
 *
 */

add_filter( 'term_search_min_chars', function( $characters, $tax, $s  ){
  return $characters;
}, 10, 3);

/*
 * Filters stopwords used when parsing search terms.
 *
 */

add_filter( 'wp_search_stopwords', function( $stopwords ){
  return $stopwords;
});

/*
 * Filters the ORDER BY used when ordering search results.
 *
 */
/*
add_filter( 'posts_search_orderby', function( $search_orderby, $this ){
  return $search_orderby;
}, 10, 2);
*/

/*
 * Filters the HTML format of the search form.
 *
 */

add_filter( 'search_form_format', function( $format, $args ){
  return $format;
}, 10, 2);

/*
 * Filters the search SQL that is used in the WHERE clause of WP_Query.
 *
 */

add_filter( 'posts_search', function( $search, $args ){
  return $search;
}, 10, 2);

/*
 * Filters the HTML output of the search form.
 *
 */

add_filter( 'get_search_form', function( $form, $args ){
  return $form;
}, 10, 2);

/*
 * Filters the contents of the search query variable
 *
 */

add_filter( 'get_search_query', function( $search ){
  return $search;
});

/*
 * Filters rewrite rules used for search archives.
 * Likely search-related archives include /search/search+query/ as well as pagination and feed paths for a search.
 *
 */

add_filter( 'search_rewrite_rules', function( $search_rewrite ){
  return $search_rewrite;
});

/*
 * Fires before the search form is retrieved, at the start of get_search_form().
 *
 */

//add_action( 'pre_get_search_form', function( $args ){});
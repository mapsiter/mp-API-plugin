<?php
// Include additional table cells in the search query
function mp_be_test_search_all_columns($search, $wp_query) {
  if (!is_admin() || !$wp_query->is_search() || $wp_query->query_vars['post_type'] !== 'mp_be_test') {
    return $search;
  }

  $search_terms = $wp_query->get('s');
  if (empty($search_terms)) {
    return $search;
  }

  global $wpdb;
  $search = '';
  $search_terms = explode(' ', $search_terms);
  foreach ($search_terms as $term) {
    $term = $wpdb->esc_like($term);
    $search .= $wpdb->prepare(" AND ({$wpdb->posts}.post_title LIKE %s OR {$wpdb->posts}.post_content LIKE %s OR {$wpdb->postmeta}.meta_value LIKE %s)", "%{$term}%", "%{$term}%", "%{$term}%");
  }

  add_filter('posts_join_request', 'mp_be_test_search_join' );
  add_filter('posts_groupby', 'mp_be_test_search_groupby' );

  return $search;
}
add_filter('posts_search', 'mp_be_test_search_all_columns', 10, 2);

// Include custom field values
function mp_be_test_search_join($join){
  if (!is_search() || get_query_var('post_type') !== 'mp_be_test'){
    return $join;
  }

  global $wpdb;
  $join .= " LEFT JOIN {$wpdb->postmeta} ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id";
  return $join;
}

// Group the results by the ID field
function mp_be_test_search_groupby($groupby) {
  if (!is_search() || get_query_var('post_type') !== 'mp_be_test') {
    return $groupby;
  }

  global $wpdb;
  return "{$wpdb->posts}.ID";
}
?>

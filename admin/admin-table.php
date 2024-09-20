<?php
// Register MP BE Test post type
function mp_be_test_register_post_type() {
  register_post_type('mp_be_test', [
    'labels' => [
      'name' => 'MP BE Tests',
      'singular_name' => 'MP BE Test'
    ],
    'public' => true,
    'has_archive' => false,
  ]);
}
add_action('init', 'mp_be_test_register_post_type');

// Create posts from API data
function mp_be_test_create_posts_from_api() {
  // Fetch the data from the api-endpoint
  $data = get_table_data_non_ajax();

  if (!$data) {
    return;
  }
  $data = json_decode($data, true);

  // Keep track of the IDs of the posts that are returned from the API
  $api_post_ids = array_column($data['data']['rows'], 'id');

  // Get all the existing posts
  $existing_posts = get_posts([
    'post_type' => 'mp_be_test',
    'numberposts' => -1,
  ]);

  // Delete any posts that are not in the list of IDs returned from the API
  foreach ($existing_posts as $post) {
    $post_id = intval(get_post_meta($post->ID, 'id', true));
    if (!in_array($post_id, $api_post_ids)) {
      wp_delete_post($post->ID, true);
    }
  }

  // Loop through the rows and create a new post for each row
  foreach ($data['data']['rows'] as $row) {
    $title = $row['fname'] . ' ' . $row['lname'];

    // Check if a post with this title already exists
    $existing_post = get_page_by_title($title, OBJECT, 'mp_be_test');

    // If the post exists, update it. Otherwise, create a new one.
    if (null !== $existing_post) {
      $post_id = wp_update_post([
        'ID' => $existing_post->ID,
        'post_type' => 'mp_be_test',
        'post_title' => $title,
        'post_status' => 'publish',
      ]);
    } else {
      $post_id = wp_insert_post([
        'post_type' => 'mp_be_test',
        'post_title' => $title,
        'post_status' => 'publish',
      ]);
    }

    // Store the fields as post meta data
    update_post_meta($post_id, 'id', sanitize_text_field($row['id']));
    update_post_meta($post_id, 'fname', sanitize_text_field($row['fname']));
    update_post_meta($post_id, 'lname', sanitize_text_field($row['lname']));
    if (is_email($row['email'])) {
      update_post_meta($post_id, 'email', sanitize_email($row['email']));
    }
    update_post_meta($post_id, 'mp_be_test_date', sanitize_text_field($row['date']));
  }
}
add_action('admin_init', 'mp_be_test_create_posts_from_api');

// Add new columns to the post table and remove post date column
add_filter('manage_mp_be_test_posts_columns', function($columns) {
  unset($columns['date']); // Remove the WP default date column

  $columns['id'] = __('ID');
  $columns['fname'] = __('First Name');
  $columns['lname'] = __('Last Name');
  $columns['email'] = __('Email');
  $columns['mp_be_test_date'] = __('Date');

  return $columns;
});

// Output the column data
add_action('manage_mp_be_test_posts_custom_column', function($column, $post_id) {
  $meta = get_post_meta($post_id, $column, true);
  if ($column === 'mp_be_test_date') {
    $meta = date('F j, Y, g:i a', $meta);
}
  echo esc_html($meta ?? '');
}, 10, 2);
?>

<?php
add_action('wp_ajax_nopriv_get_table_data', 'get_table_data');
add_action('wp_ajax_get_table_data', 'get_table_data');

// Fetch data and store it in a transient
function fetch_and_store_data() {
  // Check if the transient exists
  if (false === ($data = get_transient('table_data'))) {
    // If the transient does not exist, make a request to the external API
    $response = wp_remote_get('https://caseproof.s3.amazonaws.com/dev-challenge/table.json');

    if (is_wp_error($response)) {
        return false;
    }

    // Store the data from the API in a transient that expires after 1 hour
    $data = wp_remote_retrieve_body($response);
    set_transient('table_data', $data, HOUR_IN_SECONDS);
  }

  return $data;
}

// !TODO: Combining the two functions below into one.
// Send data (AJAX)
function get_table_data() {
  $data = fetch_and_store_data();

  if (!$data) {
    wp_send_json_error('Failed to fetch data');
    wp_die();
  }

  wp_send_json_success($data);
  wp_die();
}

// Return data (NON AJAX)
function get_table_data_non_ajax() {
  $data = fetch_and_store_data();

  if (!$data) {
    return false;
  }

  return $data;
}
?>

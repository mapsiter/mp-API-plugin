<?php
function mp_be_test_shortcode() {
  // Enqueue the api call script.
  wp_enqueue_script('mp_be_test_api_call', plugins_url('../assets/js/api-call.js', __FILE__), array(), MP_BE_TEST_VERSION, true);

  // Define mp_be_test_ajax.
  wp_localize_script('mp_be_test_api_call', 'mp_be_test_ajax', array(
    'ajax_url' => admin_url('admin-ajax.php')
  ));

  return '<div id="mp-be-test-table"></div><div id="mp-be-test-button"><button id="button-refresh-data">Refresh Data</button></div>';
}
add_shortcode('mp_be_test', 'mp_be_test_shortcode');
?>

<?php
add_action('admin_notices', 'add_hero_section');

// Add Hero section
function add_hero_section() {
  // Check if we're on the MP BE Test admin page
  $screen = get_current_screen();
  if ($screen->id !== 'edit-mp_be_test') {
    return;
  }

  // Output the Hero section
  echo '<div class="mp-be-test-hero">';
  echo '<img src="' . esc_url(plugin_dir_url(dirname(__FILE__)) . 'assets/images/mp-logo-horiz-RGB_Horizontal.svg') . '" class="mp-logo" alt="Admin Logo" />';
  echo '</div>';
}
?>

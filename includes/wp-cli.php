<?php
/**
 * Force the refresh of this data the next time the AJAX endpoint is called
 *
 * ## Command: wp refresh_table_data
 */

if (defined('WP_CLI') && WP_CLI) {
  function refresh_table_data($args, $assoc_args) {
    delete_transient('table_data');
    WP_CLI::success('Table data transient deleted. It will be refreshed on the next AJAX call.');
  }
  WP_CLI::add_command('refresh_table_data', 'refresh_table_data');
}
?>
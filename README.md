# MP-API-plugin

Using the GET accessible endpoint create an AJAX endpoint in WordPress that:

- Can be used when logged out or in.
- Calls the above endpoint to get the data to return.
- When called, always returns the data, but regardless of when/how many times it is called, never requests the data from our server more than 1 time per hour.

- A block or shortcode for the front end that, when loaded, uses JavaScript to contact your AJAX endpoint and present the returned data formatted into a table-like display.
- A WP CLI command that can be used to force the refresh of this data the next time the AJAX endpoint is called.
- A WordPress admin page that displays this data.
- A button to refresh the data.
- A search field above the admin table that, when submitted, will make the table only display the rows that have a cell matching any part of the entered search term.

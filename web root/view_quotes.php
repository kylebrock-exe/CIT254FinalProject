<?php // Script 13.8 - view_quotes.php
/* This script lists every quote. */

// Include the header:
define('TITLE', 'View All Quotes');
include('templates/header.html');

print '<h2>All Quotes</h2>';

// Restrict access to administrators only:
if (!is_administrator()) {
	print '<h2>Access Denied!</h2><p class="error">You do not have permission to access this page.</p>';
	include('templates/footer.html');
	exit();
}

// Need the database connection:
include('../mysqli_connect.php');

// Define the query:
$query = 'SELECT id, quote, source, favorite FROM quotes ORDER BY date_entered DESC';

// Run the query:
if ($result = mysqli_query($dbc, $query)) {
	
	//Retrieve the returned records:
	while ($row = mysqli_fetch_array($result)) {
		
		// Print the record:
		print "<div><blockquote>{$row['quote']}</blockquote>- {$row['source']}\n";
		
		// IS this a favorite?
		if ($row['favorite'] == 1) {
			print ' <strong>Favorite!</strong>';
		}
		
		// Add administrative links:
		print "<p><b>Quote Admin:</b> <a href=\"edit_quote.php?id={$row['id']}\">Edit</a>
			  <->
			  <a href=\"delete_quote.php?id={$row['id']}\">Delete</a></p></div>\n";
		
	}

} else {
	print '<p class="error">Could not retrieve the data because:<br>' . mysqli_error($dbc) . '.</p><p>The query being run was: ' . $query . '</p>';
}

mysqli_close($dbc);

include('templates/footer.html');
?>
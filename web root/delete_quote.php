<?php // Script 13.10 - delete_quote.php
/* This script deletes a quote. */

// Define a page title and include the header:
define('TITLE', 'Delete a Quote');
include('templates/header.html');

print '<h2>Delete a Quotation</h2>';

// Restrict access to administrators only:
if (!is_administrator()) {
	print '<h2>Access Denied!</h2><p class="error">You do not have permission to access this page.</p>';
	include('templates/footer.html');
	exit();
}

// Need the database connection:
include('../mysqli_connect.php');

if (isset($_GET['id']) && is_numeric($_GET['id']) && ($_GET['id'] > 0) ) {
	
	$query = "SELECT quote, source, favorite FROM quotes WHERE id={$_GET['id']}";
	if ($result = mysqli_query($dbc, $query)) {
		
		$row = mysqli_fetch_array($result);
		
		// Make the form:
		print '<form action="delete_quote.php" method="post">
		<p>Are you sure you want to delete this quote?</p>
		<div><blockquote>' . $row['quote'] . '</blockquote>- ' . $row['source'];
		
		// Is this a favorite?
		if ($row['favorite'] == 1) {
			print ' <strong>Favorite</strong>';
		}
		
		print '</div><br><input type="hidden" name="id" value="' . $_GET['id'] . '">
		<p><input type="submit" name="submit" value="Delete this Quote!"></p>
		</form>';
		
	} else {
		print '<p class="error">Could not retrieve the quote becase:<br>' . mysqli_error($dbc) . '.</p><p>The query being run was: ' . $query . '</p>';
	}
	
} elseif (isset($_POST['id']) && is_numeric($_POST['id']) && ($_POST['id'] > 0) ) {
	$query = "DELETE FROM quotes WHERE id={$_POST['id']} LIMIT 1";
	$result = mysqli_query($dbc, $query);
	
	if (mysqli_affected_rows($dbc) == 1) {
		print '<p>The quote entry has been deleted.</p>';
	} else {
		print '<p class="error">Could not delete the blog entry because:<br>' . mysqli_error($dbc) . '.</p><p>The being run was: ' . $query . '</p>';
	}
	
} else {
	print '<p class="error">This page has been accessed in error.</p>';
}

mysqli_close($dbc);

include('templates/footer.html');
?>
	
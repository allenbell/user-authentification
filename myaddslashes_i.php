<?php
function myaddslashes_i($s,$db) {
	$retval = $s;
	if (get_magic_quotes_gpc()) {
		$retval = stripslashes($retval);
	}
	$retval = mysqli_real_escape_string($retval,$db);
	return $retval;
}

?>


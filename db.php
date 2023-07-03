<?php
include 'config.php';
$connect = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$connect) {
die("Failed to connect to the database: " . mysqli_connect_error());
}
/*if ($connect) {
           echo "Connected";
}*/////////////////////////// code for testing database connection

/*************** DateTime- To -Time Function ****************/
function formatDate($date) {
    return date('- M d - g:i a', strtotime($date));
    //return date('- Y M d - g:i a', strtotime($date));
}
?>



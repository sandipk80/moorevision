<?php 
include('../cnf.php');
session_destroy();

header("Location: ".DOCTOR_SITE_URL);
exit;
?>
<?php
session_start();
setcookie('PHPSESSID', '', 1);
unset($_SESSION);
session_destroy();
header('Location: /TZ2/index.php');
?>
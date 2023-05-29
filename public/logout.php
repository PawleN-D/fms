<?php
require_once('../private/initialize.php');

unset($_SESSION['user']);
// or you could use
// $_SESSION['user'] = NULL;

redirect_to(url_for('/login.php'));

?>
<?php
require_once './common/config.php';

unset($_SESSION['user_id']);
unset($_SESSION['username']);

header("Location: index.php");
exit;

<?php
require 'config.php';
require 'select_logic.php';

$_SESSION = [];
session_unset();
session_destroy();
header("Location: index.php");
?>
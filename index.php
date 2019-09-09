<?php
require_once('api\language_group_check.php');
$c = new api\languageGroupCheck(); // see "Global Space" section
$c->__call($argc, $argv);
?>
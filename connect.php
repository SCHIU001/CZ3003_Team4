<?php
session_start();
$db = new mysqli("localhost", "arbalest_CZ3003", "123456as", "arbalest_CZ3003");
if ($db->connect_errno) {
    die("Sorry, we are having some problems");
}
?>
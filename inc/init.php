<?php
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['log_detail'])) {
    $_SESSION['log_detail'] = [];
}

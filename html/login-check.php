<?php
/**
 * Created by IntelliJ IDEA.
 * User: louis.ompusungu
 * Date: 11/19/2019
 * Time: 4:08 PM
 */

session_start();

if (!empty($_SESSION)) {
    $_SESSION = [];
}
?>
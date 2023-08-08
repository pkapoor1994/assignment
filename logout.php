<?php
    session_start();
    session_unset();
    session_destroy();
    // header("Location:http://sale.kvrtechnologies.xyz");
    header("Location:index.php");
?>

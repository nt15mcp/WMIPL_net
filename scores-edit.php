<?php
// Need to start a new session if necessary and track what page we are on for this session 
session_start();
$_SESSION['page']="scores-edit";
require "header.php"; // Use common header file so no need to repeat for each page
if(isset($_SESSION['executive'])){
    if($_SESSION['executive']!='Statistician'){
        header("Location: scores.php".$urlString); // if statistician is not logged in, go to scores view page.
    }
}else{
    header("Location: scores.php".$urlString); // if statistician is not logged in, go to scores view page.
}

?>
<?php
if(!isset($_SESSION)) 
{ 
    session_start();
    
}
if(!isset($_SESSION['name']) && !isset($_SESSION['email'])){
    session_destroy();
    header('Location: ../index.php');
}

?>
<?php
if(!isset($_SESSION)) 
{ 
    session_start();
    
}
if(!isset($_SESSION['authentified'])){
    session_destroy();
    header('Location: ../index.php');
}

?>
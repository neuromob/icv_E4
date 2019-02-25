<?php
if(!isset($_SESSION)) 
{ 
    session_start();
    
}
if(!isset($_SESSION['authentified'])){
    echo "error";
    session_destroy();
    header('Location: ../index.php');
} 

?>
<?php
    session_start();
    if(isset($_SESSION['id'])){
?>

Employés

<?php
    }else{
        echo 'Veuillez-vous reconnectez!';
    }
?>
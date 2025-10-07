<?php
   
session_start(); //Inicia a sessão (necessário para destrui-la)

session_destroy();

header("Location: /Pethouse/login.php");
exit();
?>
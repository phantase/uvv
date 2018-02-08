<?php

// Database connection
try
{
    $bdd = new PDO('mysql:host=mysql51-53.pro;dbname=unionvovinamwww;charset=utf8', 'unionvovinamwww', 'zaVxvCoi');
}
catch(Exception $e)
{
    die('Error : '.$e->getMessage());
}

?>
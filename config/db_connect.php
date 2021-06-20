<?php 


// MySQLi = Improved MySQL or PDO = is for advanced devs

$conn = mysqli_connect('localhost', 'DailyEstel', 'test123', 'php_pizza');


// Check connection
if(!$conn) {

    echo 'Connection error' . mysqli_connect_error();

}





?>
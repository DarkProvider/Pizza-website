<?php

// MySQLi = Improved MySQL or PDO = is for advanced devs

$conn = mysqli_connect('localhost', 'DailyEstel', 'test123', 'php_pizza');


// Check connection
if(!$conn) {

    echo 'Connection error' . mysqli_connect_error();

}


// Write query for all pizzas

$sql = 'SELECT title, ingredients, id FROM pizzas ORDER BY created_at';


// Make query and get results
$result = mysqli_query($conn, $sql);

// Fetch the resulting rows as an array
$pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);


// Free result from memory
mysqli_free_result($result);

// Close connection
mysqli_close($conn);


print_r($pizzas);

?>

<!DOCTYPE html>
<html lang="en">

    <?php include('includes/header.php'); ?>

    <h4 class="center grey-text">Pizzas!</h4>
        <div class="container">
        
            <div class="row">
            
                <?php
                    foreach($pizzas as $pizza){
                ?>

                    <div class="col s6 md3">
                    
                        <div class="card z-depth-0">
                            <div class="card-content center">
                                <h6><?php echo htmlspecialchars($pizza['title']); ?></h6>
                                <div><?php echo htmlspecialchars($pizza['ingredients']);?></div>
                            </div>
                            <div class="card-action right-align">
                                <a href="#" class="brand-text">More info</a>
                            </div>
                        </div>

                    </div>

                <?php }?>

            </div>

        </div>

    <?php include('includes/footer.php'); ?>

</html>
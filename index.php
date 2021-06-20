<?php

include('config/db_connect.php');


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


// print_r($pizzas);


// Explode function helps us take a string of characters that meat a certain condition and put them into an array for examle for later use. In this case the explode funtion is looking for what behind a comma to grab 
// explode(',', $pizzas[0]['ingredients']);



?>

<!DOCTYPE html>
<html lang="en">

    <?php include('includes/header.php'); ?>

    <h4 class="center grey-text">Pizzas!</h4>
        <div class="container">
        
            <div class="row">
            
                <?php
                    foreach($pizzas as $pizza):

                        //It is inefficient to have the loops working at all times and therefore we removed the curly braces that used to be there instead of the colon and replaced them with a colon at the top and with an "endforeach;" function to end the loop 
                ?>

                    <div class="col s6 md3">
                    
                        <div class="card z-depth-0">
                            <img src="assets/images/Pizza.png" class="pizza" alt="">
                            <div class="card-content center">
                                <h6><?php echo htmlspecialchars($pizza['title']) ?></h6>
                                <div>
                                    <ul>
                                        
                                        <?php foreach(explode(',', $pizza['ingredients']) as $ing):
                                            ?>
                                            <li>
                                                <?php echo htmlspecialchars($ing); ?>
                                            </li>
                                       <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-action right-align">
                                <a href="details.php?id=<?php echo $pizza['id']?>" class="brand-text">More info</a>
                            </div>
                        </div>

                    </div>

                <?php endforeach; ?>

                <?php if(count($pizzas) >= 2): ?>
                <p class="white-text"> There are 2 or more Pizzas</p>
                <?php  else:  ?>
                <p class="white-text"> There are less than 2 pizzas</p>
                <?php endif; ?>

            </div>

        </div>

    <?php include('includes/footer.php'); ?>

</html>
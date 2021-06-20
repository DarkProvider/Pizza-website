<?php


include('config/db_connect.php');

if(isset($_POST['delete'])){

    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

    $sql = "DELETE FROM pizzas WHERE id = $id_to_delete";

    if(mysqli_query($conn, $sql)){

        //success
        header('Location: index.php');


    } else {

        //failure
        echo 'query error: ' . mysqli_error($conn);

    }
}

// Check GET request id parameter
if(isset($_GET['id'])){


    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Make SQL
    $sql = "SELECT * FROM pizzas WHERE id= $id";

    // Get query results
    $result = mysqli_query($conn, $sql);


    // Fetch results in an associative array
    $pizza = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
    mysqli_close($conn);



}


// In the method below we are getting the id out the url and linking it with the ids in the db and if it matches a certain id it will display the pizza that is associed with and the general info about the creator. As a security measure as well we have passed an argument which can prevent people from changing the id to something that doesn't exist

?>
<!DOCTYPE html>
<html lang="en">
    <?php include('includes/header.php')?>



        <div class="container center white darkgrey-text">

        <?php if($pizza): ?>

            <h4><?php echo htmlspecialchars($pizza['title']); ?></h4>
            <p>Created by: <?php echo htmlspecialchars($pizza['email']); ?></p>
            <p>At: <?php echo date($pizza['created_at']); ?></p>
            <h5>Ingredients: </h5>
            <p><?php echo htmlspecialchars($pizza['ingredients']); ?></p>

            <!-- Delete form -->
            <form action="details.php" method="POST">
                <input type="hidden" name="id_to_delete" value="<?php echo $pizza['id'] ?>">
                <button type="sumbit" name="delete" value="Delete" class="btn brand z-depth-0">Delete</button>
            </form>

        <?php else: ?>

            <h5>No such pizza exists!</h5>

        <?php endif; ?>

        </div>



    <?php include('includes/footer.php')?>
</html>
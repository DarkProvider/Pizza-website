<?php



    include('config/db_connect.php');


    // Those are defined as to make them empty until the submit button is pressed and the request has been passed
    $title = $email = $ingredients = '';

    // Showing errors under each field
    // That's why we need to store them in variables but that wouldn't be effecient and so we will use associative array
    // Also we need to define them as empty at the top of the app as if we didn't then it would spam the app with random errors that are not supposed to occur
    // And so we define them to be empty for now till they get replaced later on
    $errors = array('email' => '', 'title' => '', 'ingredients' => '');

    // POST and GET are the same for sending data but POST is more secure as it doesn't show the data in the link
    // Everything with $_ is a global and the $_POST is a global for an array that takes in the data to be stored for later
    if(isset($_POST['submit'])){

        //Cross site scripting preventing way is to wrap the form POST requests so te prevent malicious scripts from being ran through the form htmlspecialchars()
        // echo htmlspecialchars($_POST['email']);
        // echo htmlspecialchars($_POST['title']);
        // echo htmlspecialchars($_POST['ingredients']);

        // Check form fields from being empty
        // Filters are needed for further checks and are made possible with 'REGEX'!
        if(empty($_POST['email'])){
            $errors['email'] = 'An email is required <br />';
        } else {
            // echo htmlspecialchars($_POST['email']);
            // $email is a variable/parameter that stoes in the data filled out by the end user
            $email = $_POST['email']; // It picks the item out of the array and put it in a varaiable for later to be called
            // IF a certain cond is not met then display an error
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors['email'] = 'Email must be a valid email address!';
            }
        }
        if(empty($_POST['title'])){
            $errors['title'] = 'A title is required <br />';
        } else {
            // echo htmlspecialchars($_POST['title']);
            $title = $_POST['title'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $title)) {

                $errors['title'] = 'Title must be letters and spaces only!';
            }
        }
        if(empty($_POST['ingredients'])){
            $errors['ingredients'] = 'Ingredients are required (At least one) <br />';
        } else {
            // echo htmlspecialchars($_POST['ingredients']);
            $ingredients = $_POST['ingredients'];
            if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)) {

                $errors['ingredients'] = 'Ingredients must be seperated by commas!';
            }
        }

        // Are there any erros? Don't continue if there aren't any errors then proceed to redirect to another page/site/section or even execute a function or something at least
        if(array_filter($errors)){
            //echo 'Something went wrong within the form!';
        } else {
            //echo 'form is valid!';
            // mysqli real escape function helps us protect the data going into the db. It is mostly useful when you want ot prevent any kind of injection  into the db
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);


            // Create sql 

            $sql = "INSERT INTO pizzas(title, email, ingredients) VALUES('$title', '$email' ,'$ingredients')";

            // Save to db and check for errors

            if(mysqli_query($conn, $sql)){

                // success
                header('Location: index.php');

            } else {

                // Failed
                echo 'query error: ' . mysqli_error($conn);

            }
        }

    } //End of POST check



?>

<!DOCTYPE html>
<html lang="en">

    <?php include('includes/header.php'); ?>
    
        <section class="container grey-text">
            <h4 class="center">Add a Pizza</h4>
                <form action="add.php" class="white" method="POST">
                    <label>Your Email:</label>
                    <!-- The following has a value of a variable which is supposed to return what the user has input in the field but that doesn't work if the form isn't filled and reloaded as it will display errors
                    We want to prevent that from happening by defining it at the top -->
                    <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
                    <div class="red-text"><?php echo $errors['email'];?></div>
                    <label>Pizza Title:</label>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
                    <div class="red-text"><?php echo $errors['title'];?></div>
                    <label>Ingredients (comma seperated):</label>
                    <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients) ?>">
                    <div class="red-text"><?php echo $errors['ingredients'];?></div>
                    <div class="center">
                        <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
                    </div>
                </form>
        </section>

    <?php include('includes/footer.php'); ?>

</html>
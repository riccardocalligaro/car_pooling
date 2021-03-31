<!DOCTYPE html>
<html lang="it">


<?php
include_once('../../base.php');

cp_head('Login', '../');
?>


<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["type"] === 0) {
    header("location: ../../dashboard_client.php");
    exit;
}
 
// Include config file
include_once('../../config.php');
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // Check if username is empty
    if (empty(trim($_POST["email"]))) {
        $username_err = "Inserisci la mail.";
    } else {
        $username = trim($_POST["email"]);
    }
    
    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Inserisci la password.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, email, password FROM passeggero WHERE email = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();
                
                // Check if username exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            if (!isset($_SESSION)) {
                                session_start();
                            }
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["type"] = 0;
                          
                            
                            // Redirect user to welcome page
                            header("location: ../../dashboard_client.php");
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Username o password non valido.";
                            echo $login_err;
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Username o password non valido.";
                    echo $login_err;
                }
            } else {
                echo "Oops! Errore. Riprova più tardi.";
            }

            // Close statement
            $stmt->close();
        }
    }
}
?>
<?php
require 'config.php';
// Define variables and initialize with empty values
$accountID = $username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
$login_error="";
$accountID_err="";
$password_err="";
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_error="";
    $accountID_err="";
    $password_err="";

    // ID and password sent from form
    session_start();
    $accountID = mysqli_real_escape_string($db,$_POST['accountID']);
    $password = mysqli_real_escape_string($db,$_POST['password']);

    $sql = "SELECT Ac.accountID,profileName FROM 1Account Ac ,1Admin Ad WHERE Ad.accountID = Ac.accountID AND Ac.accountID = '$accountID' and password = '$password'";
    $result = mysqli_query($db,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);
    $profilename= $row['profileName'];
    // If result matched $accountID and $password, table row must be 1 row
    if($count == 1) {
        $_SESSION['accountID']  = $accountID;
        $_SESSION['profileName']=$profilename;
        header("location: admin_dashboard.php");
    }else {
        $login_error = "Your Login Name or Password is invalid";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
<div class="wrapper">
    <h2>Login</h2>
    <form name='submitform' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($accountID_err)) ? 'has-error' : ''; ?>">
            <label>Username</label>
            <input type="text" name="accountID" class="form-control" value="<?php echo $accountID; ?>">
            <span class="help-block"><?php echo $accountID_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password</label>
            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <span class="help-block"><?php echo $login_error; ?></span>
        <br>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-default" value="Reset">
        </div>
        <p><a href="forgot_password.php">Forgot your password?</a>.</p>
    </form>
</div>
</body>
</html>







<?php require_once('../private/initialize.php'); ?>

<?php 
        
        /* Check Login form submitted */        
        if(isset($_POST['Submit'])){

            if (isset($_POST["user"]) && !isset($_SESSION["user"])) {
                // (B1) USERS & PASSWORDS - SET YOUR OWN !
                 $users = [
                  "paul" => "admin123"
                ];
               
                // (B2) CHECK & VERIFY
                if (isset($users[$_POST["user"]]) && $users[$_POST["user"]] == $_POST["password"]) {
                  $_SESSION["user"] = $_POST["user"];
                }
               
                // (B3) FAILED LOGIN FLAG
                if (!isset($_SESSION["user"])) { $failed = true; }
              }
               
              // (C) REDIRECT TO HOME PAGE IF SIGNED IN - SET YOUR OWN !
              if (isset($_SESSION["user"])) {
                header("Location: index.php");
                exit();
              }

        }
?>



<div id="content">
    <div id="main-menu">
        
        <form action="" method="post" name="Login_Form">
            <table>
                <?php if(isset($msg)){?>
                <tr>
                <td colspan="2" align="center" valign="top"><?php echo $msg;?></td>
                </tr>
                <?php } ?>
                <tr>
                <td colspan="2" align="left" valign="top"><h3>Login</h3></td>
                </tr>
                <tr>
                <td align="right" valign="top">Username</td>
                <td><input name="user" type="text" class="Input"></td>
                </tr>
                <tr>
                <td align="right">Password</td>
                <td><input name="password" type="password" class="Input"></td>
                </tr>
                <tr>
                <td> </td>
                <td><input name="Submit" type="submit" value="Login" class="Button3"></td>
                </tr>
            </table>
        </form>
    </div>

</div>


<?php 
use Controllers\Bootstrap as Bootstrap;
use Traits\urlTrait as urlTrait;
use Models\Login as Login;

include 'models/init.php';
    
$login = new Login();
$login->CheckPermission();

if(isset($_POST["login"]))
    $login->LoginFunc();
$login->Logout();

?>

<!DOCTYPE html>
<html>
    <?php
        Bootstrap::LoadHead();
    ?>
    <body>
        <div class="messageBox">
            <div class="message_holder"></div>
            <div class="input_holder"></div>
            <div class="button_holder"></div>
        </div>
        <div class="loading"></div>
    <?php
        Bootstrap::LoadHeader();
    ?>
        <main>
            <?php
                Bootstrap::LoadContent();
            ?>
        </main>
    </body>
</html>
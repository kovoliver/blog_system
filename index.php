<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use Controllers\Bootstrap as Bootstrap;
use Models\FirstStart as FirstStart;
    include 'app/init.php';

if(FirstStart::CreateDatabase()) {
    FirstStart::MakeTables();
    FirstStart::SeoDefault();
    FirstStart::SocialDefault();
    FirstStart::CoverDefault();
    FirstStart::BlogDataDefault();
}

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
    <?php
        Bootstrap::LoadHeader();
    ?>
        <main>
            <?php
                Bootstrap::LoadContent();
            ?>
        </main>
        <?php
            Bootstrap::LoadFooter();
        ?>
    </body>
</html>
<footer>
    <?php
       if(isset($profile["public_phone"]) && $profile["phone_on"] == 1) { ?>
        <i class="fas fa-mobile-alt"></i> <?=$profile["public_phone"]?>
    <?php } ?>

    <?php
       if(isset($profile["public_email"]) && $profile["email_on"] == 1) { ?>
        <i class="fas fa-envelope"></i> <?=$profile["public_email"]?>
    <?php } ?>
</footer>
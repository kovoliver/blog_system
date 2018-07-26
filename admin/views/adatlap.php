<h1>Adatlap</h1>

<h2>Borítókép beállítása</h2>

<form method="post" action="" enctype="multipart/form-data">
    <?php
        if(!empty($headerMessage)) { ?>
            <div class="messageBox" style="display:block;">
                <h3><?=$headerMessage?></h3>
                <button type="button" id="cancel" class="input">Rendben!</button>
            </div>
       <?php }
    ?>
    <input type="file" class="input" name="cover">

    <button class="input" type="submit" name="change_cover">módosítás</button>

    <input type="hidden" name="token" value="<?=$token?>">
</form>

<h2>Jelszó megváltoztatása</h2>
<form method="POST" action="">
    <?php
        if(!empty($passwordChangeMessage)) { ?>
            <div class="messageBox" style="display:block;">
                <h3><?=$passwordChangeMessage?></h3>
                <button type="button" id="cancel" class="input">Rendben!</button>
            </div>
       <?php }
    ?>
    <input type="password" class="input" name="old_password" placeholder="régi jelszó">
    <input type="password" class="input" name="password" placeholder="új jelszó">
    <button class="input" type="submit" name="change_password">módosítás</button>

    <input type="hidden" name="token" value="<?=$token?>">
</form>

<h2>A blog adatai</h2>
<form method="POST" action="">
    <?php
        if(!empty($blogDataMessage)) { ?>
            <div class="messageBox" style="display:block;">
                <h3><?=$blogDataMessage?></h3>
                <button type="button" id="cancel" class="input">Rendben!</button>
            </div>
       <?php }
    ?>
    <h3>Blog címe</h3>
    <input type="text" class="input" value="<?=isset($blogData["blog_title"]) ? $blogData["blog_title"] : ""?>"
    name=":title" placeholder="A blog címe">

    <h3>Publikus email cím</h3>
    <input type="text" class="input" value="<?=isset($blogData["public_email"]) ? $blogData["public_email"] : ""?>"
    name=":public_email" placeholder="email cím">
    <label class="checkbox_holder">
        <input type="checkbox" <?=isset($blogData["email_on"]) && $blogData["email_on"] == 1 ? "checked='checked';" : ""?>
        name=":email_on"> publikus
    </label>

    <h3>Publikus telefonszám</h3>
    <input type="text" class="input" value="<?=isset($blogData["public_phone"]) ? $blogData["public_phone"] : ""?>"
    name=":public_phone" placeholder="telefonszám">
    <label class="checkbox_holder">
        <input type="checkbox" <?=isset($blogData["phone_on"]) && $blogData["phone_on"] == 1 ? "checked='checked';" : ""?>
        name=":phone_on"> publikus
    </label>

    <h3>Facebook app id</h3>
    <input type="text" class="input" value="<?=isset($blogData["facebook_app_id"]) ? $blogData["facebook_app_id"] : ""?>"
    name=":facebook_app_id" placeholder="Facebook komment app id">

    <h3>Share this link</h3>
    <input type="text" class="input" value="<?=isset($blogData["share_this_link"]) ? $blogData["share_this_link"] : ""?>"
    name=":share_this_link" placeholder="Share this link">

    <input type="hidden" name="token" value="<?=$token?>">

    <button class="input" name="save_blog_data">mentés</button>
</form>
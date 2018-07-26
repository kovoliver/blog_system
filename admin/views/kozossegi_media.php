<h1>Közösségi média</h1>

<form id="social_media">

    <input type="text" id="facebook" class="input" 
    value="<?=isset($socialMedia[0]["link"]) ? $socialMedia[0]["link"] : ""?>"
    regexp="url" placeholder="Facebook link" required>
    <label class="checkbox_holder">
        <input type="checkbox" 
        <?=isset($socialMedia[0]["is_on"]) && $socialMedia[0]["is_on"] == 1 ? "checked='checked'" : "" ?>
        class="social_check" id="facebook_checkbox">bekapcsolás
    </label>
    <button type="button" class="social_on input" social="facebook">mentés</button>

    <input type="text" id="twitter" class="input" 
    value="<?=isset($socialMedia[1]["link"]) ? $socialMedia[1]["link"] : ""?>"
    regexp="url" placeholder="Twitter link" required>
    <label class="checkbox_holder">
        <input type="checkbox" <?=isset($socialMedia[1]["is_on"]) && $socialMedia[1]["is_on"] == 1 ? "checked='checked'" : "" ?>
        class="social_check" id="twitter_checkbox">bekapcsolás
    </label>
    <button type="button" class="social_on input" social="twitter">mentés</button>

    <input type="text" id="instagram" class="input" 
    value="<?=isset($socialMedia[2]["link"]) ? $socialMedia[2]["link"] : ""?>"
    regexp="url" placeholder="Instagram link" required>
    <label class="checkbox_holder">
        <input type="checkbox" <?=isset($socialMedia[2]["is_on"]) && $socialMedia[2]["is_on"] == 1 ? "checked='checked'" : "" ?>
        class="social_check" id="instagram_checkbox">bekapcsolás
    </label>
    <button type="button" class="social_on input" social="instagram">mentés</button>

    <input type="text" id="youtube" class="input" 
    value="<?=isset($socialMedia[3]["link"]) ? $socialMedia[3]["link"] : ""?>"
    regexp="url" placeholder="Youtube link" required>
    <label class="checkbox_holder">
        <input type="checkbox" <?=isset($socialMedia[3]["is_on"]) && $socialMedia[3]["is_on"] == 1 ? "checked='checked'" : "" ?>
        class="social_check" id="youtube_checkbox">bekapcsolás
    </label>
    <button type="button" class="social_on input" social="youtube">mentés</button>

    <input type="text" id="soundcloud" class="input" 
    value="<?=isset($socialMedia[4]["link"]) ? $socialMedia[4]["link"] : ""?>"
    regexp="url" placeholder="Soundcloud link" required>
    <label class="checkbox_holder">
        <input type="checkbox" <?=isset($socialMedia[4]["is_on"]) && $socialMedia[4]["is_on"] == 1 ? "checked='checked'" : "" ?>
        class="social_check" id="soundcloud_checkbox">bekapcsolás
    </label>
    <button type="button" class="social_on input" social="soundcloud">mentés</button>

    <input type="hidden" class="token" id="token" value="<?=$token?>">
</form>
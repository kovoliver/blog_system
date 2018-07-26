
<nav>
    <ul>
        <?php
            foreach($categories as $category) {
                $per = "";
                if($_SERVER["HTTP_HOST"] != "localhost")
                    $per = "/";
        ?>
            <li><a href="<?=$baseUrl . $per . "cikkek/" . $category["category_url"]?>"><?=$category["category_name"]?></a></li>
        <?php } ?>
    </ul>
</nav>
<div class="social_media">
    <?php
        $faClass = "";
    ?>
    <?php foreach($socialMedia as $media) {
        switch($media["media_name"]) {
            case "facebook":
                $faClass = "fab fa-facebook-f";
                break;
            case "twitter":
                $faClass = "fab fa-twitter";
                break;
            case "instagram":
                $faClass = "fab fa-instagram";
                break;
            case "youtube":
                $faClass = "fab fa-youtube";
                break;
            case "soundcloud":
                $faClass = "fab fa-soundcloud";
                break;
        }
    ?>
    <a href="<?=$media["link"]?>" target="_blanket">
        <i class="<?=$faClass?> fontA"></i>
    </a>
    <?php } ?>
</div>
<header>
<div class="blog_title">
    <h1><?=isset($profile["blog_title"]) ? $profile["blog_title"] : ""?></h1>
</div>
<img src="<?=$baseUrl?>/admin/uploads/header/header.<?=$extension["extension"]?>">
</header>
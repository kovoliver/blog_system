<form class="search_box" >
    <input class="input" type="text" name="tags" 
    placeholder="keresendő kifejezés">
    <button class="input button" name="search">keresés</button>
</form>

<?php
    $length = count($articles);
    $counter = 0;
    $style = "";
    $per = "";
    if($_SERVER["HTTP_HOST"] != "localhost")
        $per = "/";
    
    foreach($articles as $article) {
        $content = $article["content"];
        preg_match('/src="([^"]+)"/', $content, $matches);
        $content = preg_replace("/<img[^>]+\>/", "", $content);
        $counter++;
        if($counter == $length)
            $style = "style='border-bottom:1px solid #d8d8d8;'";
        $imgClass = !isset($matches[0]) ? "default_image" : "";
?>
<div class="article" <?=$style?>>
    <a href="<?=$baseUrl . $per?>cikk/<?=$article["article_url"]?>" target="_blanket">
        <h1 class="title"><?=$article["title"];?></h1>
        <div class="pic_holder <?=$imgClass?>">
            <img <?=isset($matches[0]) ? $matches[0] : ""?>>
        </div>
        <?=mb_substr($content, 0, 450)?>...
    </a>
</div>
<?php
    }
?>

<div class="pagination">
    <a class="pagi left" <?php echo $prevHide; ?> href="<?=$prevPage?>">előző</a>
    <a class="pagi right" <?php echo $nextHide; ?> href="<?=$nextPage?>">következő</a>
</div>
<div class="clearfix"></div>
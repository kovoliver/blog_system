<h1>Cikk</h1>
<?=isset($article["content"]) ? $article["content"] : ""?>
<div class="clearfix"></div>
<div class="date_holder">
    <b><?=isset($article["create_date"]) ? $article["create_date"] : ""?></b>
</div>

<div class="fb">
    <div class="fb-comments" data-href="<?=$_SERVER["HTTP_HOST"]?><?=$_SERVER["REQUEST_URI"]?>" data-numposts="5"></div>

    <div class="sharethis-inline-share-buttons"></div>
</div>
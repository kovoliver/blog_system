<h1>Cikkek sorrendben</h1>

<form autocomplete="off">
    <h3>Dátum tól</h3>
        <input type="date" class="input" id="date_from" 
        value="<?=isset($_GET["date_from"]) ? urldecode($_GET["date_from"]) : ""?>">
    <h3>Dátum ig</h3>
        <input type="date" class="input" id="date_to" 
        value="<?=isset($_GET["date_to"]) ? urldecode($_GET["date_to"]) : ""?>">
    <h3>Cím részlet</h3>
        <input type="text" class="input" value="<?=isset($_GET["title"]) ? urldecode($_GET["title"]) : ""?>" 
        id="title" placeholder="cím részlet">
    <button type="button" class="input" id="search">keresés</button>
</form>

<div class="article_holder">
    <div class="articles">
        <h3>Cím</h3>
        <div class="article_data"></div>
        <div class="article_data"></div>
        <button class="half_input">törlés</button>
        <button class="half_input right">szerkesztés</button>
    </div>
</div>

<div class="pagination_holder">
    <button id="next_page" class="half_input right">következő</button>
    <button id="prev_page" class="half_input">előző</button>
</div>

<input type="hidden" id="token" class="token" value="<?=$token?>">
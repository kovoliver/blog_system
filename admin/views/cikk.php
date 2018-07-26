<h1>Kategória felvitele</h1>
<form id="new_category" autocomplete="off">
    <input type="text" class="input" id="new_category_name" 
    regexp="category_name" name=":category_name" placeholder="kategória elnevezése" required>

    <input type="button" class="input" id="set_category" value="kategória felvitele">

    <select class="select" id="delete_category_list">

    </select>
    <div class="center_div">
        <input type="button" class="half_input" id="delete_category" value="törlés">
        <input type="button" class="half_input" id="update_category" value="felülírás">
    </div>

    <input type="hidden" id="token" class="token" value="<?=$token?>">
</form>

<h1>Cikk felvitele</h1>
<form id="new_article" autocomplete="off">
    <input type="hidden" id="article_id" value="<?=isset($category["category_id"]) ? $category["category_id"] : ""?>">
    <h3>A cikk címe</h3>
    <input type="text" class="input article" value="<?=isset($data["title"]) ? $data["title"] : ""?>"
    name=":title" id="title" regexp="title" placeholder="A cikk címe" required>

    <h3>Tagek</h3>
    <input type="text" id="allowSpacesTags" class="input article" value="<?=isset($tags) ? $tags : ""?>"
    name=":tags" id="tags" regexp="tags" placeholder="tagek" required>

    <h3>A cikk kategóriája</h3>
    <select id="category" class="select article" id="category" 
    regexp="category" name=":category" required>
        
    </select>

    <textarea id="editor" style="height:500px;">
        <?=isset($data["content"]) ? $data["content"] : ""?>
    </textarea>

    <input type="hidden" class="token" name="token" value="<?=$token?>">
    
    <div class="clearfix"></div>
    <button type="button" class="input" id="set_article">mentés</button>
</form>

<style>
    .ck-content {
        min-height: 400px;
        margin-bottom:30px;
    }
</style>

<script>
    CKEDITOR.replace("editor", {
		height: 350,
		filebrowserBrowseUrl: GetBaseUrl() + '/views/file_browser.php'
	});
</script>
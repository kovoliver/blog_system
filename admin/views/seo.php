<h1>SEO</h1>

<form id="seo_data">
    <h3>Title</h3>
    <input type="text" class="input" value="<?=isset($seo["title"]) ? $seo["title"] : ""?>"
    name=":title" placeholder="title">

    <h3>Description</h3>
    <input type="text" class="input" value="<?=isset($seo["description"]) ? $seo["description"] : ""?>"
    name=":description" placeholder="description">

    <h3>schema.dcterms</h3>
    <input type="text" class="input" value="<?=isset($seo["schema_dcterms"]) ? $seo["schema_dcterms"] : ""?>"
    name=":schema_dcterms" placeholder="schema.dcterms">

    <h3>DC.coverage</h3>
    <input type="text" class="input" value="<?=isset($seo["DC_coverage"]) ? $seo["DC_coverage"] : ""?>"
    name=":DC_coverage" placeholder="DC.coverage">

    <h3>DC.description</h3>
    <input type="text" class="input" value="<?=isset($seo["DC_description"]) ? $seo["DC_description"] : ""?>"
    name=":DC_description" placeholder="DC.description">

    <h3>DC.format</h3>
    <input type="text" class="input" value="<?=isset($seo["DC_format"]) ? $seo["DC_format"] : ""?>"
    name=":DC_format" placeholder="DC.format">

    <h3>DC.identifier</h3>
    <input type="text" class="input" value="<?=isset($seo["DC_identifier"]) ? $seo["DC_identifier"] : ""?>"
    name=":DC_identifier" placeholder="DC.identifier">

    <h3>DC.publisher</h3>
    <input type="text" class="input" value="<?=isset($seo["DC_publisher"]) ? $seo["DC_publisher"] : ""?>"
    name=":DC_publisher" placeholder="DC.publisher">

    <h3>DC.title</h3>
    <input type="text" class="input" value="<?=isset($seo["DC_title"]) ? $seo["DC_title"] : ""?>"
    name=":DC_title" placeholder="DC.title">

    <h3>DC.type</h3>
    <input type="text" class="input" value="<?=isset($seo["DC_type"]) ? $seo["DC_type"] : ""?>"
    name=":DC_type" placeholder="DC.type">

    <h3>og:image</h3>
    <input type="text" class="input" value="<?=isset($seo["og_image"]) ? $seo["og_image"] : ""?>"
    name=":og_image" placeholder="og:image">

    <input type="hidden" class="token" id="token" value="<?=$token?>">

    <button type="button" class="input" id="set_seo">mentés</button>
</form>
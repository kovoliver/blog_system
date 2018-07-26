<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?=$baseUrl?>/assets/style.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" 
    integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
    <title><?=$seo["title"]?></title>
    <link rel="schema.dcterms" href="<?=isset($seo["schema_dcterms"]) ? $seo["schema_dcterms"] : ""?>">
    <meta name="description" content="<?=isset($seo["description"]) ? $seo["description"] : ""?>"/>
    <meta name="DC.coverage" content="<?=isset($seo["DC_coverage"]) ? $seo["DC_coverage"] : ""?>"/>
    <meta name="DC.description" content="<?=isset($seo["DC_description"]) ? $seo["DC_description"] : ""?>" />
    <meta name="DC.format" content="<?=isset($seo["DC_format"]) ? $seo["DC_format"] : ""?>" />
    <meta name="DC.identifier" content="<?=isset($seo["DC_identifier"]) ? $seo["DC_identifier"] : ""?>" />
    <meta name="DC.publisher" content="<?=isset($seo["DC_publisher"]) ? $seo["DC_publisher"] : ""?>" />
    <meta name="DC.title" content="<?=isset($seo["DC_title"]) ? $seo["DC_title"] : ""?>" />
    <meta name="DC.type" content="<?=isset($seo["DC_type"]) ? $seo["DC_type"] : ""?>" />
    <meta property="og:image" content="<?=isset($seo["og_image"]) ? $seo["og_image"] : ""?>"/>

    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

    <div id="fb-root"></div>
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/hu_HU/sdk.js#xfbml=1&version=v3.0&appId=<?=isset($profile["facebook_app_id"]) ? $profile["facebook_app_id"] : ""?>&autoLogAppEvents=1';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

</head>

<script src="<?=isset($profile["share_this_link"]) ? $profile["share_this_link"] : ""?>"></script>
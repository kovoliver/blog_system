var counter = getQueryVariable("page") !== false ? getQueryVariable("page") : 1;
var article = {
    regexp: function(id) {
        var regexpBool = true;
        var regexpObj = {
            "title":/^[a-zA-ZöüóőúéáűíÖÜÓŐÚÉÁŰÍ\.\s\-_\?\:\*\(\)\=\%\,\/\d]{3,35}$/,
            "tags":/^[a-zA-ZöüóőúéáűíÖÜÓŐÚÉÁŰÍ\.\s\-_\?\:\*\(\)\=\%\,\d]{3,35}$/,
            "category":/^[\d]{0,5}$/,
            "category_name":/^[a-zA-ZöüóőúéáűíÖÜÓŐÚÉÁŰÍ\.\s\-_\d]{3,50}$/,
            "url":/^(http|https)(:\/\/)(www.|)[a-zA-Z\d\_\-\.\?\%\*\/]{2,150}(.)[a-z\/]{2,6}$/
        }
        var inputVal = $('#'+ id).val();
        var regexp = $('#'+ id).attr("regexp");
        if(!inputVal.toString().match(regexpObj[regexp]) && $('#' + id).attr('required') != undefined) {
            regexpBool = false;
            $('#' + id).addClass('input_error');
            if(regexp == "tags")
                $(".tagit").addClass('input_error');
        } else {
            $('#' + id).removeClass('input_error');
        }
        return regexpBool;
    },
    regexpCycle: function(className) {
        var regexpBool = true;
        $('.' + className).each(function(index, value) {
            if(!article.regexp(value.id)) {
                regexpBool = false;
            }
        });
        return regexpBool;
    },
    manageCategory: function(formData, action) {
        $(".loading").show();
        SendFormData(formData, action).done(function(response) {
            $(".loading").hide();
            if(response == "exists")
                alert("A kategória már létezik!");
            else if(response == 1) {
                article.getCategories();
                $("#new_category_name").val("");
                $(".messageBox").hide(300);
            }
            else 
                alert("Végzetes, fatális, überhiba történt, kérem AZONNAL hívja a Miniszterelnököt!!!!!!");
            tokenObj.getToken();
        });
    },
    getCategories: function() {
        GetAjaxData("/ajax/get_categories.php").done(function(response) {
            var categoriesJson = JSON.parse(response);
            var html = "<option>Válassz kategóriát!</option>";
            var nonSelectedHtml = "<option>Válassz kategóriát!</option>";
            var selected = "";
            var currentCategory = $("#article_id").val();
            $.each(categoriesJson, function(index, value) {
                if(currentCategory == value.category_id)
                    selected = "selected='selected'";
                else 
                    selected = "";
                html += "<option "+selected+" value='"+value.category_id+"'>"+value.category_name+"</option>";
                nonSelectedHtml += "<option value='"+value.category_id+"'>"+value.category_name+"</option>";
            });
            $("#delete_category_list").html(nonSelectedHtml);
            $("#category").html(html);
        });
    },
    setArticle: function(formData) {
        $(".loading").show();
        if($("#category option:selected").val() === undefined) {
            alert("A kategória kiválasztása kötelező!");
            return;
        }
        var action = getQueryVariable("article_id") === false ? "/ajax/set_article.php" : "/ajax/update_article.php";
        SendFormData(formData, action).done(function(response) {
            response = Number(response);
            if(response > 0) {
                ChangeUrl("page", "cikk?article_id=" + response);
            } else {
                alert("Végzetes, fatális, überhiba történt, kérem AZONNAL hívja a Miniszterelnököt!!!!!!");
            }
            tokenObj.getToken();
            $(".loading").hide();
        });
    },
    deleteArticle: function(formData) {
        SendFormData(formData, "/ajax/delete_article.php").done(function(response) {
            if(response == 1) {
                article.getArticles();
            }
            else 
                alert("Végzetes, fatális, überhiba történt, kérem AZONNAL hívja a Miniszterelnököt!!!!!!");

            $(".messageBox").hide(300);
            tokenObj.getToken();
        });
    },
    getArticles: function() {
        GetAjaxData("/ajax/get_articles.php").done(function(response) {
            var articlesJson = JSON.parse(response);
            if($(".article_holder").length === 0)
                return;
            var html = "";
            $.each(articlesJson, function(index, value) {
                var modifyDate = value.modify_date !== null ? value.modify_date : "Még nem volt módosíta";
                html += "<div class='article_box'>";
                html += "<h3>"+value.title+"</h3>";
                html += '<div class="article_data">létrehozva: '+value.create_date+'</div>';
                html += '<div class="article_data">módosítva: '+modifyDate+'</div>';
                html += "<input type='button' class='delete_article half_input' article_id='"+value.article_id+"' value='törlés'>";
                html += '<a href="'+GetBaseUrl()+'/cikk?article_id='+value.article_id+'">';
                    html += '<button class="half_input right">szerkesztés</button>';
                html += "</a>";
                html += "</div>";
            });
            $(".article_holder").html(html);
        });
    },
    getMaxPage: function(formData) {
        var maxPage = 0;
        $.ajax({
            url: GetBaseUrl() + "/ajax/get_max_page.php",
            method: "POST",
            async: false,
            data: {formData}
        }).done(function(response) {
            maxPage = response;
        });
        return maxPage;
    },
    getArticlesUrlVars: function() {
        var page = getQueryVariable("page") !== false ? getQueryVariable("page") : 1;
        var title = getQueryVariable("title") !== false ? getQueryVariable("title") : "";
        var date_from = getQueryVariable("date_from") !== false ? decodeURIComponent(getQueryVariable("date_from")) : "";
        var date_to = getQueryVariable("date_to") !== false ? decodeURIComponent(getQueryVariable("date_to")) : "";
        var formData = [
            {"name":":page", "value":page},
            {"name":":title", "value":title},
            {"name":":date_from", "value":date_from},
            {"name":":date_to", "value":date_to}
        ];

        var maxPage = Math.ceil(this.getMaxPage(formData)/5);

        if(counter == maxPage)
            $("#next_page").hide();
        else 
            $("#next_page").show();

        if(counter == 1)
            $("#prev_page").hide();
        else 
            $("#prev_page").show();
        
        if(maxPage == 1) {
            $("#prev_page").hide();
            $("#next_page").hide();
        }

        SendFormData(formData, "/ajax/get_articles.php").done(function(response) {
            var articlesJson = JSON.parse(response);
            if($(".article_holder").length === 0)
                return;
            var html = "";
            $.each(articlesJson, function(index, value) {
                var modifyDate = value.modify_date !== null ? value.modify_date : "Még nem volt módosíta";
                html += "<div class='article_box'>";
                html += "<h3>"+value.title+"</h3>";
                html += '<div class="article_data">létrehozva: '+value.create_date+'</div>';
                html += '<div class="article_data">módosítva: '+modifyDate+'</div>';
                html += "<input type='button' class='delete_article half_input' article_id='"+value.article_id+"' value='törlés'>";
                html += '<a href="'+GetBaseUrl()+'/cikk?article_id='+value.article_id+'">';
                    html += '<button class="half_input right">szerkesztés</button>';
                html += "</a>";
                html += "</div>";
            });
            $(".article_holder").html(html);
        });
    }
}

$(document).ready(function() {
    $("#set_category").click(function() {
        var categoryName = $("#new_category_name").val();
        var token = $("#token").val();
        if(article.regexp("new_category_name")) {
            var formData = [
                {'name':':category_name', 'value':categoryName},
                {"name":"token", "value":token}
            ];
            article.manageCategory(formData, "/ajax/set_category.php");
        }
        else 
            alert("A kategória elnevezésének minimum három karakteresnek kell lennie!");
    });

    $("#delete_category").click(function() {
        var categoryId = $("#delete_category_list option:selected").val();
        var categoryName = $("#delete_category_list option:selected").text();
        var message = "<h3>Biztosan törölni akarod a(z) "+categoryName+" kategóriát?</h3>";
        var buttons = "<button class='input' id='category_delete' category_name='"+categoryName+"' category_id='"+categoryId+"'>törlés</button>";
        buttons += "<button class='input' id='cancel'>mégse</button>";
        MessageBox(message, buttons);
    });

    $("body").on("click", "#cancel", function() {
        $(".messageBox").hide(300);
    });

    $("body").on("click", "#category_delete", function() {
        var categoryId = $(this).attr("category_id");
        var token = $("#token").val();
        var formData = [
            {'name':':category_id', 'value':categoryId},
            {"name":"token", "value":token}
        ];
        article.manageCategory(formData, "/ajax/delete_category.php");
    });

    $("#set_article").click(function() {
        var formData = $("#new_article").serializeArray();
        formData[4] = {"name":":content", "value": CKEDITOR.instances['editor'].getData()};
        var articleId = getQueryVariable("article_id");
        if(articleId !== false)
            formData[5] = {"name":":article_id", "value":articleId};
        if(article.regexpCycle("article")) {
            article.setArticle(formData);
        }
    });

    $("#update_category").click(function() {
        var categoryId = $("#delete_category_list option:selected").val();
        var categoryName = $("#delete_category_list option:selected").text();
        var message = "<h3>Biztosan át akarod nevezni a(z) "+categoryName+" kategóriát?</h3>";
        var buttons = "<button class='input' id='category_update' category_name='"+categoryName+"' category_id='"+categoryId+"'>átnevezés</button>";
        buttons += "<button class='input' id='cancel'>mégse</button>";
        var inputs = "<input type='text' class='input' id='new_category_name' placeholder='kategória elnevezése'>";
        MessageBox(message, buttons, inputs);
    });

    $("body").on("click", "#category_update", function() {
        var categoryId = $(this).attr("category_id");
        var categoryName = $("#new_category_name").val();
        var token = $("#token").val();
        var formData = [
            {'name':':category_id', 'value':categoryId},
            {'name':':category_name', 'value':categoryName},
            {"name":"token", "value":token}
        ];
        if(categoryName.length >= 3)
            article.manageCategory(formData, "/ajax/update_category.php");
        else 
            alert("A ketegória elnevezésének legalább három karekteresnek kell lennie!");
    });

    $("body").on("click", ".delete_article", function() {
        var articleId = $(this).attr("article_id");
        var buttons = "<button class='input' id='article_delete' article_id='"+articleId+"'>törlés</button>";
        buttons += "<button class='input' id='cancel'>mégse</button>";
        var message = "<h3>Biztosan törölni akarod a cikket?</h3>";
        MessageBox(message, buttons);
    });

    $("body").on("click", "#article_delete", function() {
        var articleId = Number($(this).attr("article_id"));
        var token = $("#token").val();
        var formData = [
            {"name":":article_id", "value":articleId},
            {"name":"token", "value":token}
        ];
        if(articleId !== NaN)
            article.deleteArticle(formData);
    });

    $("body").on("click", "#next_page", function() {
        counter++;
        var title = getQueryVariable("title") !== false ? 
        "&title=" + getQueryVariable("title") : "";
        var date_from = getQueryVariable("date_from") !== false ? 
        "&date_from=" + getQueryVariable("date_from") : "";
        var date_to = getQueryVariable("date_to") !== false ? 
        "&date_to=" + getQueryVariable("date_to") : "";
        ChangeUrl("page", "cikkek?page=" + counter + title + date_from + date_to);
        article.getArticlesUrlVars();
    });

    $("body").on("click", "#prev_page", function() {
        counter--;
        if(counter == 0)
            counter = 1;
        var title = getQueryVariable("title") !== false ? 
        "&title=" + getQueryVariable("title") : "";
        var date_from = getQueryVariable("date_from") !== false ? 
        "&date_from=" + getQueryVariable("date_from") : "";
        var date_to = getQueryVariable("date_to") !== false ? 
        "&date_to=" + getQueryVariable("date_to") : "";
        ChangeUrl("page", "cikkek?page=" + counter + title + date_from + date_to);
        article.getArticlesUrlVars();
    });

    $("#search").click(function() {
        var date_from = $("#date_from").val() !== "" ? "&date_from=" + $("#date_from").val() : "";
        var date_to = $("#date_to").val() !== "" ? "&date_to=" + $("#date_to").val() : "";
        var title = $("#title").val() != "" ? "title=" + $("#title").val() : "";
        ChangeUrl("page", "cikkek?"+ title + date_from + date_to);
        article.getArticlesUrlVars();
    });

    article.getCategories();
    article.getArticlesUrlVars();
});
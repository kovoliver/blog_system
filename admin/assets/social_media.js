var socialMedia = {
    updateSocialMedia: function(formData) {
        $(".loading").show();
        SendFormData(formData, "/ajax/set_social_media.php").done(function(response) {
            tokenObj.getToken();
            $(".loading").hide();
        });
    }
}

$(document).ready(function() {
    $(".social_on").click(function() {
        var identity = $(this).attr("social");
        var checked = ($("#" + identity + "_checkbox")[0].checked === true) ? 1 : 0;
        var socialUrl = $("#" + identity).val();
        var token = $("#token").val();
        var formData = {
            ":is_on":checked, 
            ":media_name":identity, 
            ":link":socialUrl,
            "token":token
        };
        if(article.regexp(identity)) {
            socialMedia.updateSocialMedia(formData);
        }
    });
});
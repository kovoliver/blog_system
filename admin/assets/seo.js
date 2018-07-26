var seo = {
    updateSeo: function(formData) {
        $(".loading").show();
        SendFormData(formData, "/ajax/set_seo.php").done(function(response) {
            if(response != 1)
                alert("Végzetes, fatális, überhiba történt, kérem AZONNAL hívja a Miniszterelnököt!!!!!!");
            tokenObj.getToken();
            $(".loading").hide();
        });
    }
}

$(document).ready(function() {
    $("#set_seo").click(function() {
        var formData = $("#seo_data").serializeArray();
        seo.updateSeo(formData);
    });
});
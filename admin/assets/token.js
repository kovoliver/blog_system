var tokenObj = {
    getToken: function() {
        GetAjaxData("/ajax/get_token.php").done(function(response) {
            $(".token").val(response);
        });
    }
}
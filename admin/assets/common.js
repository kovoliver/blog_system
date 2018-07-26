function GetBaseUrl() {
    var getUrl = window.location;
    var localhostPath = "";
    if(getUrl.hostname == "localhost")
        localhostPath = "/" + getUrl.pathname.split("/")[1];
    var baseUrl = getUrl.protocol + "//" + getUrl.host + localhostPath + "/admin";
    return baseUrl;
}

function getQueryVariable(variable) {
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i=0;i<vars.length;i++) {
        var pair = vars[i].split("=");
        if(pair[0] == variable){return pair[1];}
    }
    return(false);
}

function ChangeUrl(page, url) {
    if (typeof (history.pushState) !== undefined) {
        var obj = { Page: page, Url: url };
        history.pushState(obj, obj.Page, obj.Url);
    } else {
        alert("Browser does not support HTML5.");
    }
}

function SendFormData(formData, action) {
    var ajaxRequest = $.ajax({
        method:"POST",
        url: GetBaseUrl() + action,
        data: {formData}
    });
    return ajaxRequest;
}

function GetAjaxData(action) {
    var responseObj = $.ajax({
        url: GetBaseUrl() + action,
        method: "GET"
    });
    return responseObj;
}

function MessageBox(message, buttons, inputs = "") {
    $(".messageBox").fadeIn(300);
    $(".messageBox .message_holder").html(message);
    $(".messageBox .button_holder").html(buttons);
    $(".messageBox .input_holder").html(inputs);
}
$(document).ready(function() {
    $('#allowSpacesTags').tagit({
        allowSpaces: true
    });
});

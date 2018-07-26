$(document).ready(function() {
    $("#file_upload").click(function() {
        fileUpload();
    });

    $(".image_button").click(function() {
        //var picName = $("input[type=checkbox]:checked").attr("picfolder");
        // Helper function to get parameters from the query string.
        var picName = $(this).attr("filename");
        function getUrlParam( paramName ) {
            var reParam = new RegExp( '(?:[\?&]|&)' + paramName + '=([^&]+)', 'i' );
            var match = window.location.search.match( reParam );
            return ( match && match.length > 1 ) ? match[1] : null;
        }
        // Simulate user action of selecting a file to be returned to CKEditor.
        function returnFileUrl() {
            var funcNum = getUrlParam( 'CKEditorFuncNum' );
            var fileUrl = picName;
            window.opener.CKEDITOR.tools.callFunction( funcNum, fileUrl );
            window.close();
        }
        returnFileUrl();
    });
});
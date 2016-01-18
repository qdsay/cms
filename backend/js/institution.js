// JavaScript Document
$().ready(function() {
    $("#search_institution_form").live("submit", function(){
        var params = $(this).serializeArray();
        if ($("#keywords").attr("title") == $("#keywords").val()) {
            $("#keywords").val('');
        }

        $.get(base_url+"institution/search", {keywords: $("#keywords").val()}, function(data){
            if(data.status == "success"){
                var html = '';
                $("#result").empty();

                $.each(data.list, function(i, n){
                    html += '<option value="'+n.id+'">'+n.name+'</option>';
                });

                $("#result").append(html);
            } else {
                alert(data.error);
            }
        }, 'json');
        return false;
    });
});
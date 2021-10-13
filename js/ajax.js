function ajax(servidor, tag){
    $.ajax({url: servidor, success: function(result){
                $(tag).html(result);
    }}); 
}

$( document ).ready(function() {
    $('input').attr('autocomplete','off');
    $(".cl_btn_file").on('click', function() {
        var file_path = $(this).attr('href');
        var ar=file_path.split("/");
        var filename=ar[ar.length-1];
        console.log(filename);
        $("#id_img_file").attr("src","/storage/uploads/" + filename);
    })
});

var MitrmLikesWidget = function () {
    var item = this;
    this.form = $('.js_mitrm_img_upload_form');
    this.btnUpload = $('.js_mitrm_img_upload_submit');

    this.form.submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        console.log(formData);
        $.ajax({
            type:'POST',
            url: item.form.attr('action'),
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                console.log("success");
                console.log(data);
            },
            error: function(data){
                console.log("error");
                console.log(data);
            }
        });
        return false;
    });


};


$(document).ready(function () {
    window.mitrmLikes = new MitrmLikesWidget();


});


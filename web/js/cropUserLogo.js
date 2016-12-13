var $dataX = $('#x');
var $dataY = $('#y');
var $dataHeight = $('#height');
var $dataWidth = $('#width');


$('#changeUserLogo').click(function (){
    $('#userLogoFileBox').css('display','block');
    $('#changeUserLogoBox').css('display','none');
});

$('.uploadDeny').click(function (){
    window.location.reload();
});

$('#uploadApprove').click(function (){
    $('#selectPhotoFile').remove();
    $('#user-logo-form').submit();
});



function uploadFile(url) {
    var formData = new FormData($("#user-logo-form")[0]);
    console.log(formData);
    $.ajax({
        url : url,
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success : function(data) // 服务器成功响应处理函数
        {
            $('#userLogoFileBox').css('display','none');
            $('#changeActionBox').css('display','block');
            $('#image').attr('src',data);
            $('#lastPhoto').val(data);
            $(function () {
              $('#image').cropper({
                viewMode: 1,
                dragMode: 'move',
                aspectRatio: 1 / 1,
                minContainerHeight:280,
                minContainerWidth:280,
                minCropBoxWidth:280,
                minCropBoxHeight:280,
                autoCropArea:1,
                center: true,
                restore: false,
                guides: false,
                highlight: false,
                cropBoxMovable: false,
                cropBoxResizable: false,
                crop: function (e) {
                  $dataX.val(Math.round(e.x));
                  $dataY.val(Math.round(e.y));
                  $dataHeight.val(Math.round(e.height));
                  $dataWidth.val(Math.round(e.width));
                }
              });
            });
            console.log(data);
        },
        error : function(data)// 服务器响应失败处理函数
        {
            console.log(data);
        }
    });
    return false;
}

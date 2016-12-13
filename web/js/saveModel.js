$(document).ready(function(){
    $("#savePersonalInfoBtn").click(function (){
        var form_id = $('form').attr('id');
        $(".ui.basic.savePersonalInfoCheck.modal").modal({
            blurring: true,
            onDeny    : function(){
                return true;
            },
            onApprove : function() {
                $('#'+form_id).submit();
            }
        }).modal("setting", "transition", "fade").modal("show");
    });
});

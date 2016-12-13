$(document).ready(function(){
    $(".linkChangeBtn").click(function (){
        var count = 0;
        $("td",$(this).parent().parent()).each(function(){
            if (count == 0){
                $('#id').val($(this).text());
            }else if (count == 1){
                $('#link_type').val($(this).text());
            }else if (count == 2){
                $('#icon').val($(this).find('i').attr('class').substr(0, $(this).find('i').attr('class').indexOf(' ')));
            }else if (count == 3){
                $('#description').val($(this).text());
            }
            count++;
        });
        $(".ui.linkChange.modal").modal({
            onDeny : function(){
                return true;
            },
            onApprove : function() {
                $('#link-change-form').submit();
            }
        }).modal("setting", "transition", "fade").modal("show");
    });
    $(".linkDelBtn").click(function (){
    
    });
});

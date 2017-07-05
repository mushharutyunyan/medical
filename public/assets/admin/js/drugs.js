$(document).ready(function(){
    $(".datepicker").datepicker();
    $(".add_drug_param").on("click",function(){
        var block_name = $(this).attr('data-name');
        var block_count = parseInt($(this).parent().children('input[name="'+block_name+'"]').val());
        ++block_count;
        if(block_name.match(/date/g)){
            $(this).parent().append('<input type="text" name="'+block_name+'_'+block_count+'" class="form-control datepicker" data-date-format="yyyy-mm-dd">')
            $(".datepicker").datepicker();
        }else if(block_name.match(/picture/g)){
            $(this).parent().append('<input type="file" name="'+block_name+'_'+block_count+'">')
        }else{
            $(this).parent().append('<input type="text" name="'+block_name+'_'+block_count+'" class="form-control">')
        }
        $('input[name="'+block_name+'"]').val(block_count);
    })
});
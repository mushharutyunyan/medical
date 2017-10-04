$('#top_rated_organization_id').on('change',function(){
    $("#top_rated_drug_id").html('<option></option>');
    if($(this).val() == ''){
        return false;
    }
    $.ajax({
        url: '/admin/manage/topRated/show',
        type: 'GET',
        data: {organization_id:$(this).val()},
        dataType: 'json',
        success: function(data){
            $.each(data,function(key,value){
                $("#top_rated_drug_id").append('<option value="'+value.id+'">'+value.name+' ('+value.price+')</option>')
            })
        }
    })
})
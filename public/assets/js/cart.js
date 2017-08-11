$(document).ready(function(){
   $(".shoping-cart").on('submit',function(e){
       e.preventDefault();
       var data = {_token:$(this).children('input[name="_token"]').val()};
       var i = 0;
       $(this).find('tbody tr').each(function(key,value){
           var count = $(this).find('input[name="count"]').val();
           var name = $(this).find('input[name="name"]').val();
           var image = $(this).find('input[name="image"]').val();
           var price = $(this).find('input[name="price"]').val();
           var storage_id = $(this).find('input[name="storage_id"]').val();
           var organization_id = $(this).find('input[name="organization_id"]').val();
           data[i] = {count:count,name:name,image:image,price:price,storage_id:storage_id,organization_id:organization_id}
            i++;
       });
       $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: data,
            dataType: 'json',
            success: function(){
                location.reload();
            }
       });
   })
});
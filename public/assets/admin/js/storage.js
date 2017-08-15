$(document).ready(function(){
    $(document).on("click",".search-drug-button",function(){
        $(".search-drug").removeClass('order');
        if($(this).hasClass('order')){
            $(".storage-save").addClass('order');
        }
        $("#search_drug").modal('show');
        $(".search-drug").val('');
        $(".search-drug").attr('data-id',$(this).attr('data-id'));
        $('.drug-settings').hide();
        $('.drug-settings-table tbody').html('');
        $('.drug-search-results').remove();
    })
    $(document).on("change",".search-drug",function(){

        $(this).parent().children('.error').html('');

        $('.drug-settings').hide();
        $('.drug-settings-table tbody').html('');
        if($(this).val().length < 2){
            $(this).parent().children('.error').html('Minimum 3 simbols');
            return false;
        }
        $('.drug-loader').show();
        $(".drug-content").html('');

        //for order organization
        var to = null;
        var is_order = false;
        if($('select[name="to"]').length){
            to = $('select[name="to"]').val();
            is_order = true;
        }
        $('.search-drug').parent().children('error').html('');
        $.ajax({
            url: '/admin/storage/searchDrug',
            type: 'POST',
            data: {'name':$(this).val(),'to':to,'is_order':is_order,'_token':$(this).parent().children('input[name="_token"]').val()},
            dataType: 'json',
            success: function(data){
                $('.drug-loader').hide();
                if(data.error){
                    $('.search-drug').parent().find('span.error').html(data.error);
                    return false;
                }

                $(".drug-content").append('<div class="col-md-6"><select class="drug-search-results form-control"><option value="0"></option></select></div>');
                if(is_order){
                    $.each(data,function(key,value){
                        $(".drug-search-results").append('<option value="'+value.id+'">'+value.trade_name+'</option>')
                    });
                    return false
                }
                $.each(data,function(key,value){
                    $(".drug-search-results").append('<option value="'+value.id+'">'+value.trade_name+'</option>')
                })
            }
        })
    })
    $(document).on('change',".drug-search-results",function(){
        $('.drug-settings').hide();
        $('.drug-settings-table tbody').html('');
        if($(this).val() == 0){
            return false;
        }
        //for order organization
        var to = null;
        var is_order = false;
        if($('select[name="to"]').length){
            to = $('select[name="to"]').val();
            is_order = true;
        }
        $('.drug-loader').show();
        $.ajax({
            url: '/admin/storage/searchDrugSettings',
            type: 'POST',
            data: {'id':$(this).val(),'is_order':is_order,'to':to,'_token':$('input[name="_token"]').val()},
            dataType: 'json',
            success: function(data){
                var drugs_settings = '';
                if(is_order){
                    drugs_settings = JSON.parse(data.storage.drug_settings);
                }
                $('.drug-loader').hide();
                $('.drug-settings').show();
                var generic_name = '';
                if(data.currentDrug.generic_name){
                    generic_name = data.currentDrug.generic_name;
                }
                var dosage_form = '';
                if(data.currentDrug.dosage_form){
                    dosage_form = data.currentDrug.dosage_form;
                }
                var dosage_strength = '';
                if(data.currentDrug.dosage_strength){
                    dosage_strength = data.currentDrug.dosage_strength;
                }
                var code = '';
                if(data.currentDrug.code){
                    code = data.currentDrug.code;
                }
                $('.drug-settings-table tbody').append('<tr><td>Generic Name</td><td>'+generic_name+'</td></tr>');
                $('.drug-settings-table tbody').append('<tr><td>Dosage Form</td><td>'+dosage_form+'</td></tr>');
                $('.drug-settings-table tbody').append('<tr><td>Dosage Strength</td><td>'+dosage_strength+'</td></tr>');
                $('.drug-settings-table tbody').append('<tr><td>Code</td><td>'+code+'</td></tr>');
                if(data.currentDrug.category.length){
                    var categories = data.currentDrug.category;
                    $('.drug-settings-table tbody').append('<tr><td>Categories</td><td><select class="form-control search-categories"><option value="0"></option></select></td></tr>');
                    $.each(categories,function(key,value){
                        if(drugs_settings.category.length){
                            if(drugs_settings.category == value.id){
                                $('.search-categories').append('<option value="'+value.id+'">'+value.name+'</option>')
                            }
                        }else{
                            $('.search-categories').append('<option value="'+value.id+'">'+value.name+'</option>')
                        }
                    })
                }
                if(data.currentDrug.count.length){
                    var count = data.currentDrug.count;
                    $('.drug-settings-table tbody').append('<tr><td>Count</td><td><select class="form-control search-count"><option value="0"></option></select></td></tr>');
                    $.each(count,function(key,value){
                        if(drugs_settings.count){
                            if(drugs_settings.count == value.id){
                                $('.search-count').append('<option value="'+value.id+'">'+value.count+'</option>')
                            }
                        }else{
                            $('.search-count').append('<option value="'+value.id+'">'+value.count+'</option>')
                        }
                    })
                }
                if(data.currentDrug.unit_price.length){
                    var unit_price = data.currentDrug.unit_price;
                    $('.drug-settings-table tbody').append('<tr><td>Unit Price</td><td><select class="form-control search-unit_price"><option value="0"></option></select></td></tr>');
                    $.each(unit_price,function(key,value){
                        if(drugs_settings.unit_price){
                            if(drugs_settings.unit_price == value.id){
                                $('.search-unit_price').append('<option value="'+value.id+'">'+value.price+'</option>')
                            }
                        }else{
                            $('.search-unit_price').append('<option value="'+value.id+'">'+value.price+'</option>')
                        }
                    })
                }
                if(data.currentDrug.country.length){
                    var country = data.currentDrug.country;
                    $('.drug-settings-table tbody').append('<tr><td>Country</td><td><select class="form-control search-country"><option value="0"></option></select></td></tr>');
                    $.each(country,function(key,value){
                        if(drugs_settings.country){
                            if(drugs_settings.country == value.id){
                                $('.search-country').append('<option value="'+value.id+'">'+value.name+'</option>')
                            }
                        }else{
                            $('.search-country').append('<option value="'+value.id+'">'+value.name+'</option>')
                        }
                    })
                }
                if(data.currentDrug.expiration_date.length){
                    var expiration_date = data.currentDrug.expiration_date;
                    $('.drug-settings-table tbody').append('<tr><td>Expiration date</td><td><select class="form-control search-expiration_date"><option value="0"></option></select></td></tr>');
                    $.each(expiration_date,function(key,value){
                        if(drugs_settings.expiration_date){
                            if(drugs_settings.expiration_date == value.id){
                                $('.search-expiration_date').append('<option value="'+value.id+'">'+value.date+'</option>')
                            }
                        }else{
                            $('.search-expiration_date').append('<option value="'+value.id+'">'+value.date+'</option>')
                        }
                    })
                }
                if(data.currentDrug.registration_date.length){
                    var registration_date = data.currentDrug.registration_date;
                    $('.drug-settings-table tbody').append('<tr><td>Registration Date</td><td><select class="form-control search-registration_date"><option value="0"></option></select></td></tr>');
                    $.each(registration_date,function(key,value){
                        if(drugs_settings.registration_date){
                            if(drugs_settings.registration_date == value.id){
                                $('.search-registration_date').append('<option value="'+value.id+'">'+value.date+'</option>')
                            }
                        }else{
                            $('.search-registration_date').append('<option value="'+value.id+'">'+value.date+'</option>')
                        }
                    })
                }
                if(data.currentDrug.group.length){
                    var group = data.currentDrug.group;
                    $('.drug-settings-table tbody').append('<tr><td>Group</td><td><select class="form-control search-group"><option value="0"></option></select></td></tr>');
                    $.each(group,function(key,value){
                        if(drugs_settings.group){
                            if(drugs_settings.group == value.id){
                                $('.search-group').append('<option value="'+value.id+'">'+value.name+'</option>')
                            }
                        }else{
                            $('.search-group').append('<option value="'+value.id+'">'+value.name+'</option>')
                        }
                    })
                }
                if(data.currentDrug.manufacturer.length){
                    var manufacturer = data.currentDrug.manufacturer;
                    $('.drug-settings-table tbody').append('<tr><td>Manufacturer</td><td><select class="form-control search-manufacturer"><option value="0"></option></select></td></tr>');
                    $.each(manufacturer,function(key,value){
                        if(drugs_settings.manufacturer){
                            if(drugs_settings.manufacturer == value.id){
                                $('.search-manufacturer').append('<option value="'+value.id+'">'+value.name+'</option>')
                            }
                        }else{
                            $('.search-manufacturer').append('<option value="'+value.id+'">'+value.name+'</option>')
                        }
                    })
                }
                if(data.currentDrug.series.length){
                    var series = data.currentDrug.series;
                    $('.drug-settings-table tbody').append('<tr><td>Series</td><td><select class="form-control search-series"><option value="0"></option></select></td></tr>');
                    $.each(series,function(key,value){
                        if(drugs_settings.series){
                            if(drugs_settings.series == value.id){
                                $('.search-series').append('<option value="'+value.id+'">'+value.name+'</option>')
                            }
                        }else{
                            $('.search-series').append('<option value="'+value.id+'">'+value.name+'</option>')
                        }
                    })
                }
                if(data.currentDrug.supplier.length){
                    var supplier = data.currentDrug.supplier;
                    $('.drug-settings-table tbody').append('<tr><td>Supplier</td><td><select class="form-control search-supplier"><option value="0"></option></select></td></tr>');
                    $.each(supplier,function(key,value){
                        if(drugs_settings.supplier){
                            if(drugs_settings.supplier == value.id){
                                $('.search-supplier').append('<option value="'+value.id+'">'+value.name+'</option>')
                            }
                        }else{
                            $('.search-supplier').append('<option value="'+value.id+'">'+value.name+'</option>')
                        }
                    })
                }
                if(data.currentDrug.type.length){
                    var type = data.currentDrug.type;
                    $('.drug-settings-table tbody').append('<tr><td>Type</td><td><select class="form-control search-type"><option value="0"></option></select></td></tr>');
                    $.each(type,function(key,value){
                        if(drugs_settings.type){
                            if(drugs_settings.type == value.id){
                                $('.search-type').append('<option value="'+value.id+'">'+value.name+'</option>')
                            }
                        }else{
                            $('.search-type').append('<option value="'+value.id+'">'+value.name+'</option>')
                        }
                    })
                }
                if(data.currentDrug.unit.length){
                    var unit = data.currentDrug.unit;
                    $('.drug-settings-table tbody').append('<tr><td>Unit</td><td><select class="form-control search-unit"><option value="0"></option></select></td></tr>');
                    $.each(unit,function(key,value){
                        if(drugs_settings.unit){
                            if(drugs_settings.unit == value.id){
                                $('.search-unit').append('<option value="'+value.id+'">'+value.name+'</option>')
                            }
                        }else{
                            $('.search-unit').append('<option value="'+value.id+'">'+value.name+'</option>')
                        }
                    })
                }
                if(data.currentDrug.certificate_number.length){
                    var certificate_number = data.currentDrug.certificate_number;
                    $('.drug-settings-table tbody').append('<tr><td>Certificate Number</td><td><select class="form-control search-certificate_number"><option value="0"></option></select></td></tr>');
                    $.each(certificate_number,function(key,value){
                        if(drugs_settings.certificate_number){
                            if(drugs_settings.certificate_number == value.id){
                                $('.search-certificate_number').append('<option value="'+value.id+'">'+value.name+'</option>')
                            }
                        }else{
                            $('.search-certificate_number').append('<option value="'+value.id+'">'+value.name+'</option>')
                        }
                    })
                }
                if(data.currentDrug.release_order.length){
                    var release_order = data.currentDrug.release_order;
                    $('.drug-settings-table tbody').append('<tr><td>Release Order</td><td><select class="form-control search-release_order"><option value="0"></option></select></td></tr>');
                    $.each(release_order,function(key,value){
                        if(drugs_settings.release_order){
                            if(drugs_settings.release_order == value.id){
                                $('.search-release_order').append('<option value="'+value.id+'">'+value.name+'</option>')
                            }
                        }else{
                            $('.search-release_order').append('<option value="'+value.id+'">'+value.name+'</option>')
                        }
                    })
                }
                if(data.currentDrug.release_packaging.length){
                    var release_packaging = data.currentDrug.release_packaging;
                    $('.drug-settings-table tbody').append('<tr><td>Release Packaging</td><td><select class="form-control search-release_packaging"><option value="0"></option></select></td></tr>');
                    $.each(release_packaging,function(key,value){
                        if(drugs_settings.release_packaging){
                            if(drugs_settings.release_packaging == value.id){
                                $('.search-release_packaging').append('<option value="'+value.id+'">'+value.name+'</option>')
                            }
                        }else{
                            $('.search-release_packaging').append('<option value="'+value.id+'">'+value.name+'</option>')
                        }
                    })
                }
                if(data.currentDrug.type_belonging.length){
                    var type_belonging = data.currentDrug.type_belonging;
                    $('.drug-settings-table tbody').append('<tr><td>Type Belonging</td><td><select class="form-control search-type_belonging"><option value="0"></option></select></td></tr>');
                    $.each(type_belonging,function(key,value){
                        if(drugs_settings.type_belonging){
                            if(drugs_settings.type_belonging == value.id){
                                $('.search-type_belonging').append('<option value="'+value.id+'">'+value.name+'</option>')
                            }
                        }else{
                            $('.search-type_belonging').append('<option value="'+value.id+'">'+value.name+'</option>')
                        }
                    })
                }
                if(data.currentDrug.registration_certificate_holder.length){
                    var registration_certificate_holder = data.currentDrug.registration_certificate_holder;
                    $('.drug-settings-table tbody').append('<tr><td>Registration Certificate Holder</td><td><select class="form-control search-registration_certificate_holder"><option value="0"></option></select></td></tr>');
                    $.each(registration_certificate_holder,function(key,value){
                        if(drugs_settings.registration_certificate_holder){
                            if(drugs_settings.registration_certificate_holder == value.id){
                                $('.search-registration_certificate_holder').append('<option value="'+value.id+'">'+value.name+'</option>')
                            }
                        }else{
                            $('.search-registration_certificate_holder').append('<option value="'+value.id+'">'+value.name+'</option>')
                        }
                    })
                }
                if(data.currentDrug.character.length){
                    var character = data.currentDrug.character;
                    $('.drug-settings-table tbody').append('<tr><td>Character</td><td><select class="form-control search-character"><option value="0"></option></select></td></tr>');
                    $.each(character,function(key,value){
                        if(drugs_settings.character){
                            if(drugs_settings.character == value.id){
                                $('.search-character').append('<option value="'+value.id+'" data-text="'+value.name+'">'+value.name.substring(0, 10)+'...</option>')
                            }
                        }else{
                            $('.search-character').append('<option value="'+value.id+'" data-text="'+value.name+'">'+value.name.substring(0, 10)+'...</option>')
                        }
                    })
                    $('.search-character').after('<button class="open-character btn blue">Open</button>')
                }
                if(data.currentDrug.picture.length){
                    var picture = data.currentDrug.picture;
                    $('.drug-settings-table tbody').append('<tr><td>Picture</td><td><select class="form-control search-picture"><option value="0"></option></select></td></tr>');
                    $.each(picture,function(key,value){
                        if(drugs_settings.picture){
                            if(drugs_settings.picture == value.id){
                                $('.search-picture').append('<option value="'+value.id+'" data-src="'+value.name+'">'+value.name+'</option>')
                            }
                        }else{
                            $('.search-picture').append('<option value="'+value.id+'" data-src="'+value.name+'">'+value.name+'</option>')
                        }
                    })
                    $('.search-picture').after('<button class="open-picture btn blue">Open</button>')
                }
            }
        })
    })
    $(document).on('click','.open-character',function(){
        var character_id = $(this).prev().val();
        if(parseInt(character_id)){
            var character_text = $(this).prev().children('option[value="'+character_id+'"]').attr('data-text');
            $("#watch").modal('show');
            $("#watch").find('.modal-body-watch').html(character_text);
        }
    });
    $(document).on('click','.open-picture',function(){
        var picture_id = $(this).prev().val();
        if(parseInt(picture_id)){
            var picture = $(this).prev().children('option[value="'+picture_id+'"]').attr('data-src');
            $("#watch").modal('show');
            $("#watch").find('.modal-body-watch').html("<img class='img-responsive' src='/assets/admin/images/drugs/"+picture+"'>");
        }
    });
    $(document).on("submit",".storage-save",function(e){
        e.preventDefault();
        var table = '.storage-actions-table',
            save_all_button = '.save-all-storage';
        if($(this).hasClass('order')){
            table = '.order-actions-table';
            save_all_button = '.save-all-order';
        }
        var access = true;
        var count = $(table).find('.row-settings').length;
        var drug_id = $('.drug-search-results').val();
        var $data = {info:{},data_info:{}};
        $(".drug-settings-table").find('select').each(function(key,value){
            val = $(value).val();
            var self = this
            if(parseInt($(value).val())){
                var classList = $(value).attr('class').split(/\s+/);
                $.each(classList, function(index, item) {
                    if (item !== 'form-control') {
                        var name = $(self).parent().prev().html();
                        var value_text = $(self).children('option[value="'+$(value).val()+'"]').text();
                        sub_value = item.split('search-')[1];
                        $data.info[sub_value] = val;
                        $data.data_info[name] = value_text;
                    }
                });
            }
        });
        $(table+' tbody tr').each(function(key,value){
            if($(value).find('.row-settings').val() == JSON.stringify($data['info']) && parseInt($(value).find('.row-drug-id').val()) == drug_id){
                if(!$(value).first().hasClass('saved')){
                    $.alert({
                        title: 'Warning!',
                        content: 'This drug is already exists in current insert table!',
                    });
                    access = false;
                }else{
                   $(value).addClass('dublicate');
                }
            }
        });
        if(Object.keys($data['info']).length != 0 && access){
            $data['drug_id'] = drug_id;
            token = $(this).children('input[name="_token"]').val();
            $data['_token'] = token;
            var is_order = 0;
            if($(this).hasClass('order')){
                is_order = 1;
            }
            $data['is_order'] = is_order;
            $.ajax({
                url: '/admin/storage/checkDrug',
                type: 'POST',
                data: $data ,
                dataType: 'json',
                success: function(data){
                    var clear_button_class = '';
                    if(is_order){
                        clear_button_class = 'order';
                    }
                    if(data){
                        var confirm_message = 'This drug with this params already exists. Only quantity will increase';
                        if(is_order){
                            if(data.error){
                                confirm_message = data.error + ", count - "+data.count;
                            }else{
                                confirm_message = 'This drug is already exists in your storage, count - '+data.count;
                            }
                        }
                        $.confirm({
                            animation: 'bottom',
                            closeAnimation: 'bottom',
                            title: 'Confirm!',
                            content: confirm_message,
                            buttons: {
                                confirm: function () {
                                    $(table+' tr').find('.search-drug-button').each(function(key,value){
                                        if($(value).attr('data-id') == $('.search-drug').attr('data-id')){
                                            $(this).parent().parent().addClass('process');
                                            row_id = $(value).attr('data-id');
                                            settings = JSON.stringify($data['info']);
                                            $("#search_drug").modal('hide');
                                            var info = '';
                                            $.each($data.data_info, function(key, value){
                                                info += '<p>'+key+': '+value+'</p><br>';
                                            });
                                            $(this).parent().html("<button class='remove-storage-row btn btn-warning "+clear_button_class+"' data-id='"+$(value).attr('data-id')+"'>Clear</button>" + $('.drug-search-results').children('option[value="'+$('.drug-search-results').val()+'"]').html()+" <span class='error'>(" + data.count + ")</span><input type='hidden' class='row-settings' name='settings_"+count+"' value='"+settings+"'><input type='hidden' class='row-drug-id' name='drug_id_"+count+"' value='"+$data.drug_id+"'><input type='hidden' class='row-exist' name='exist_"+count+"' value='1'>"+info);
                                            return false;
                                        }
                                    })
                                    $(save_all_button).attr('data-count',++count);
                                    $(table+' tbody tr').each(function(key,value){
                                       if($(value).hasClass('dublicate')){
                                           $(value).remove();
                                       }
                                    });
                                },
                                cancel: function () {

                                }
                            }
                        });
                    }else{
                        $(table + ' tr').find('.search-drug-button').each(function(key,value){
                            if($(value).attr('data-id') == $('.search-drug').attr('data-id')){
                                $(this).parent().parent().addClass('process');
                                row_id = $(value).attr('data-id');
                                settings = JSON.stringify($data['info']);
                                $("#search_drug").modal('hide');
                                $(this).parent().html("<button data-id='"+$(value).attr('data-id')+"' class='remove-storage-row btn btn-warning "+clear_button_class+"'>Clear</button>" + $('.drug-search-results').children('option[value="'+$('.drug-search-results').val()+'"]').html()+"<input type='hidden' class='row-settings' name='settings_"+count+"' value='"+settings+"'><input type='hidden' class='row-drug-id' name='drug_id_"+count+"' value='"+$data.drug_id+"'><input type='hidden' class='row-exist' name='exist_"+count+"' value='0'>");
                                $.each($data.data_info, function(key, value){
                                    $(this).parent().append('<p>'+key+': '+value+'</p>');
                                });
                                return false;
                            }
                        })
                        $(save_all_button).attr('data-count',++count);
                        $(table+' tbody tr').each(function(key,value){
                            if($(value).hasClass('dublicate')){
                                $(value).remove();
                            }
                        });
                    }
                }
            })
        }
    })
    $(document).on('click','.remove-storage-row',function(){
        $(this).parent().parent().removeClass('process');
        count = $('.save-all-storage').attr('data-count');
        var search_button_class = '';
        if($(this).hasClass('order')){
            search_button_class = 'order';
        }
        $(this).parent().html('<button type="button" class="btn btn-success search-drug-button '+search_button_class+'" data-id="'+$(this).attr('data-id')+'">Search</button>')
        $('.save-all-storage').attr('data-count',--count);
    })
    $(document).on("click",".add-storage-row",function(){
        var row_count = $('.count-storage-row').val();
        var iteration = $('.storage-actions-table tbody tr').length;
        for(i = 1; i <= row_count; i++){
            ++iteration;
            $('.storage-actions-table tbody').append('<tr><td><button type="button" data-id="'+iteration+'" class="btn btn-success search-drug-button">Search</button></td><td><input type="text" class="form-control" name="count" placeholder="Count"></td><td><button class="btn green save-storage-row">Save</button></td></tr>')
        }

    })
    $(document).on("click",".save-storage-row",function(){
        var tr = $(this).parent().parent();
        tr.prop("disabled",true);
        var settings = tr.find('.row-settings').val();
        var drug_id = tr.find('.row-drug-id').val();
        var count = tr.find('input[name="count"]').val();
        var exist = tr.find('.row-exist').val();
        var _token = $('.storage-save-all').children('input[name="_token"]').val();
        var self = this;
        if(settings && drug_id && count > 0){
            $(this).parent().html('<img src="/assets/admin/img/loading.gif" class="row-loading" width="40" style="margin-top: 5%;">');
            $.ajax({
                url: '/admin/storage/save',
                type: 'POST',
                data: {settings:settings,drug_id:drug_id,count:count,_token:_token,exist:exist},
                dataType: 'json',
                success: function(){
                    $(tr).find('.row-loading').parent().html('<button class="btn blue">Added</button>');
                    $(tr).find('.remove-storage-row').remove();
                    $(tr).find('input[name="count"]').attr('disabled','disabled');
                    $(tr).addClass('saved');
                },
                error: function(data){
                }
            })
        }
    })
    $(document).on("click",".save-all-storage",function(e){
        e.preventDefault();
        var i = 0;
        var $data = [];
        var $send_data = {};
        var access = true;
        var order_save = false;
        var order_send = false;
        var table = '.storage-actions-table';
        var edit_order = false;
        var method = 'POST';
        var in_table = false;
        if($(this).hasClass('order-save')){
            order_save = true;
            table = '.order-actions-table'
        }
        if($(this).hasClass('order-send')){
            order_send = true;
            table = '.order-actions-table'
        }
        if(order_save || order_send){
            if($(this).hasClass('edit')){
                edit_order = true;
            }
            if(!edit_order){
                var to = $('select[name="to"]').val();
                if(!parseInt(to)){
                    $.alert({
                        title: 'Warning!',
                        content: 'Select Organization!',
                    });
                    return true;
                }
            }
        }
        if($(this).hasClass('in_table')){
            in_table = true;
        }
        if(!in_table){
            if($(table + " tbody tr.process").length == 0){
                if(edit_order){
                    if($(table + " tbody tr.saved").length == 0){
                        $.alert({
                            title: 'Warning!',
                            content: 'No Drugs for save!',
                        });
                        return true;
                    }
                }else{
                    $.alert({
                        title: 'Warning!',
                        content: 'No Drugs for save!',
                    });
                    return true;
                }
            }
            $(table + " tbody tr.process").each(function(key,value){
                var row = {};
                var count = $(this).find('input[name="count"]').val();
                if(count == ''){
                    $.alert({
                        title: 'Warning!',
                        content: 'Check Drug counts!',
                    });
                    access = false;
                }
                var settings = $(this).find('.row-settings').val();
                var drug_id = $(this).find('.row-drug-id').val();
                row['settings'] = settings;
                row['drug_id'] = drug_id;
                row['count'] = count;

                if(!order_save && !order_send){
                    var exist = $(this).find('.row-exist').val();
                    row['exist'] = exist;
                }
                $data.push(row);

            });
        }
        if(access){
            var _token = $('.storage-save-all').children('input[name="_token"]').val();

            $send_data['info'] = $data;
            var url = '/admin/storage/saveAll';
            if(order_save){
                url = '/admin/order';

                $send_data['order_save'] = true;
                $send_data['to'] = to;
            }
            if(order_send){
                url = '/admin/order';
                $("#order_send").removeClass('edit');
                $('.order-form-status-block').html("");
                $('.order-form-delivery-status-block').html("");
                if(!edit_order || in_table){
                    if(in_table){
                        $("#order_send").addClass('edit');
                        $("#order_send").attr('data-id',$(this).attr('data-id'));
                    }
                    if(!$(this).hasClass('answer')){
                        $.ajax({
                            url: '/admin/order/getDeliveryStatuses',
                            method: 'POST',
                            data: {_token:_token},
                            dataType: 'json',
                            success: function(data){
                                $("#order_send").find('.order-form-delivery-status-block').html('<select name="delivery_status_id" class="form-control order-deliver-statuses"></select>')
                                $.each(data,function(key,value){
                                    $('.order-deliver-statuses').append('<option value="'+value.id+'">'+value.name+'</option>')
                                });
                            }
                        });
                    }
                }else{
                    $("#order_send").addClass('edit');
                    $("#order_send").attr('data-id',$(this).attr('data-id'));
                    if($(this).hasClass('answer')){
                        $('.order-form-delivery-status-block').html("");
                        $.ajax({
                            url: '/admin/order/getAnswerStatuses',
                            method: 'POST',
                            data: {_token:_token},
                            dataType: 'json',
                            success: function(data){
                                $("#order_send").find('.order-form-status-block').html('<select name="status" class="form-control order-send-statuses"></select>')
                                $.each(data,function(key,value){
                                    $('.order-send-statuses').append('<option value="'+key+'">'+value+'</option>')
                                })
                            }
                        })
                    }
                }
                $(".order-message").parent().children('textarea[name="data"]').remove();
                $(".order-message").val('');
                order_send_data = JSON.stringify($send_data.info);
                $(".order-message").parent().append('<textarea style="display:none" name="data">'+order_send_data+'</textarea>')
                $("#order_message").modal("show");
                return false;
            }else{
                $send_data['_token'] = _token;
            }
            if(edit_order){
                url = '/admin/order/'+$(this).attr('data-id');
                method = 'PUT';
            }
            $('.save-all-storage').html('Saving...');
            $('.save-all-storage').attr('disabled','disabled');
            $.ajax({
                url: url,
                type: method,
                data: $send_data ,
                dataType: 'json',
                success: function(data){
                    if(!order_save && !order_send){
                        location.replace('/admin/storage')
                    }else{
                        location.replace('/admin/order')
                    }
                }
            });
        }
        return false;
    });



    // Index page
    var $settings_info = {};
    $settings_info['category'] = 'Categories';
    $settings_info['count'] = 'Count';
    $settings_info['unit_price'] = 'Unit Price';
    $settings_info['country'] = 'Country';
    $settings_info['expiration_date'] = 'Expiration date';
    $settings_info['registration_date'] = 'Registration Date';
    $settings_info['group'] = 'Group';
    $settings_info['manufacturer'] = 'Manufacturer';
    $settings_info['series'] = 'Series';
    $settings_info['supplier'] = 'Supplier';
    $settings_info['type'] = 'Type';
    $settings_info['unit'] = 'Unit';
    $settings_info['certificate_number'] = 'Certificate Number';
    $settings_info['release_order'] = 'Release Order';
    $settings_info['release_packaging'] = 'Release Packaging';
    $settings_info['type_belonging'] = 'Type Belonging';
    $settings_info['registration_certificate_holder'] = 'Registration Certificate Holder';
    $settings_info['character'] = 'Character';
    $settings_info['picture'] = 'Picture';
    $(document).on('click','.view-edit-drug', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var url = '/admin/storage/'+id;
        var drug_id = 0;
        var order = false;
        if($(this).hasClass('order')){
            url = '/admin/order/'+id;
            drug_id = $(this).attr('data-drug-id');
            order = true;
        }
        $.ajax({
            url: url,
            type: 'GET',
            data: {drug_id:drug_id},
            dataType: 'json',
            success: function(data){
                if(order){
                    var settings = JSON.parse(data.order.drug_settings);
                }else{
                    var settings = JSON.parse(data.storage.drug_settings);
                }

                $("#edit_view_drug").find(".drug-name").html(data.drug.trade_name);
                $(".drug-settings-view-table tbody").html('');
                $('.drug-settings-view-table tbody').append('<tr><td>Generic Name</td><td>'+data.drug.generic_name+'</td></tr>');
                $('.drug-settings-view-table tbody').append('<tr><td>Dosage Form</td><td>'+data.drug.dosage_form+'</td></tr>');
                $('.drug-settings-view-table tbody').append('<tr><td>Dosage Strength</td><td>'+data.drug.dosage_strength+'</td></tr>');
                $('.drug-settings-view-table tbody').append('<tr><td>Code</td><td>'+data.drug.code+'</td></tr>');
                $.each(settings, function(key,value){
                    $.each(data.drug, function(drugKey,drugValue){
                        if(drugKey == key){
                            $.each(drugValue,function(settingKey,settingValue){
                                if(settingValue.id == value){
                                    if(drugKey == 'count'){
                                        name = settingValue.count
                                    }else if(drugKey.match(/date/g)){
                                        name = settingValue.date
                                    }else if(drugKey.match(/price/g)){
                                        name = settingValue.price
                                    }else if(drugKey == 'picture'){
                                        name = '<img class="img-responsive" src="/assets/admin/images/drugs/'+settingValue.name+'">'
                                    }else{
                                        name = settingValue.name
                                    }
                                    $(".drug-settings-view-table tbody").append('<tr><td>'+$settings_info[key]+'</td><td>'+name+'</td></tr>')
                                }
                            })
                        }
                    })
                })
                $("#edit_view_drug").modal('show')
            }
        });
    })

    $(".storage-edit-form").on("submit",function(e){
        e.preventDefault();
        $.ajax({
            url:$(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data){
                if(data.exist){
                    $.alert({
                        title: 'Warning!',
                        content: 'This drug with this params already exists. <a target="_blank" href="/admin/storage/'+data.exist+'/edit">Watch</a>',
                    });
                    return true;
                }else{
                    location.replace('/admin/storage')
                }
            }
        })
    })
});
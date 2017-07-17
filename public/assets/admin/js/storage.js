$(document).ready(function(){
    $(document).on("click",".search-drug-button",function(){
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
        $.ajax({
            url: '/admin/storage/searchDrug',
            type: 'POST',
            data: {'name':$(this).val(),'_token':$(this).parent().children('input[name="_token"]').val()},
            dataType: 'json',
            success: function(data){
                $('.drug-loader').hide();
                $(".drug-content").append('<div class="col-md-6"><select class="drug-search-results form-control"><option value="0"></option></select></div>');
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
        $('.drug-loader').show();
        $.ajax({
            url: '/admin/storage/searchDrugSettings',
            type: 'POST',
            data: {'id':$(this).val(),'_token':$('input[name="_token"]').val()},
            dataType: 'json',
            success: function(data){
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
                        $('.search-categories').append('<option value="'+value.id+'">'+value.name+'</option>')
                    })
                }
                if(data.currentDrug.count.length){
                    var count = data.currentDrug.count;
                    $('.drug-settings-table tbody').append('<tr><td>Count</td><td><select class="form-control search-count"><option value="0"></option></select></td></tr>');
                    $.each(count,function(key,value){
                        $('.search-count').append('<option value="'+value.id+'">'+value.count+'</option>')
                    })
                }
                if(data.currentDrug.unit_price.length){
                    var unit_price = data.currentDrug.unit_price;
                    $('.drug-settings-table tbody').append('<tr><td>Unit Price</td><td><select class="form-control search-unit_price"><option value="0"></option></select></td></tr>');
                    $.each(unit_price,function(key,value){
                        $('.search-unit_price').append('<option value="'+value.id+'">'+value.price+'</option>')
                    })
                }
                if(data.currentDrug.country.length){
                    var country = data.currentDrug.country;
                    $('.drug-settings-table tbody').append('<tr><td>Country</td><td><select class="form-control search-country"><option value="0"></option></select></td></tr>');
                    $.each(country,function(key,value){
                        $('.search-country').append('<option value="'+value.id+'">'+value.name+'</option>')
                    })
                }
                if(data.currentDrug.expiration_date.length){
                    var expiration_date = data.currentDrug.expiration_date;
                    $('.drug-settings-table tbody').append('<tr><td>Expiration date</td><td><select class="form-control search-expiration_date"><option value="0"></option></select></td></tr>');
                    $.each(expiration_date,function(key,value){
                        $('.search-expiration_date').append('<option value="'+value.id+'">'+value.date+'</option>')
                    })
                }
                if(data.currentDrug.registration_date.length){
                    var registration_date = data.currentDrug.registration_date;
                    $('.drug-settings-table tbody').append('<tr><td>Registration Date</td><td><select class="form-control search-registration_date"><option value="0"></option></select></td></tr>');
                    $.each(registration_date,function(key,value){
                        $('.search-registration_date').append('<option value="'+value.id+'">'+value.date+'</option>')
                    })
                }
                if(data.currentDrug.group.length){
                    var group = data.currentDrug.group;
                    $('.drug-settings-table tbody').append('<tr><td>Group</td><td><select class="form-control search-group"><option value="0"></option></select></td></tr>');
                    $.each(group,function(key,value){
                        $('.search-group').append('<option value="'+value.id+'">'+value.name+'</option>')
                    })
                }
                if(data.currentDrug.manufacturer.length){
                    var manufacturer = data.currentDrug.manufacturer;
                    $('.drug-settings-table tbody').append('<tr><td>Manufacturer</td><td><select class="form-control search-manufacturer"><option value="0"></option></select></td></tr>');
                    $.each(manufacturer,function(key,value){
                        $('.search-manufacturer').append('<option value="'+value.id+'">'+value.name+'</option>')
                    })
                }
                if(data.currentDrug.series.length){
                    var series = data.currentDrug.series;
                    $('.drug-settings-table tbody').append('<tr><td>Series</td><td><select class="form-control search-series"><option value="0"></option></select></td></tr>');
                    $.each(series,function(key,value){
                        $('.search-series').append('<option value="'+value.id+'">'+value.name+'</option>')
                    })
                }
                if(data.currentDrug.supplier.length){
                    var supplier = data.currentDrug.supplier;
                    $('.drug-settings-table tbody').append('<tr><td>Supplier</td><td><select class="form-control search-supplier"><option value="0"></option></select></td></tr>');
                    $.each(supplier,function(key,value){
                        $('.search-supplier').append('<option value="'+value.id+'">'+value.name+'</option>')
                    })
                }
                if(data.currentDrug.type.length){
                    var type = data.currentDrug.type;
                    $('.drug-settings-table tbody').append('<tr><td>Type</td><td><select class="form-control search-type"><option value="0"></option></select></td></tr>');
                    $.each(type,function(key,value){
                        $('.search-type').append('<option value="'+value.id+'">'+value.name+'</option>')
                    })
                }
                if(data.currentDrug.unit.length){
                    var unit = data.currentDrug.unit;
                    $('.drug-settings-table tbody').append('<tr><td>Unit</td><td><select class="form-control search-unit"><option value="0"></option></select></td></tr>');
                    $.each(unit,function(key,value){
                        $('.search-unit').append('<option value="'+value.id+'">'+value.name+'</option>')
                    })
                }
                if(data.currentDrug.certificate_number.length){
                    var certificate_number = data.currentDrug.certificate_number;
                    $('.drug-settings-table tbody').append('<tr><td>Certificate Number</td><td><select class="form-control search-certificate_number"><option value="0"></option></select></td></tr>');
                    $.each(certificate_number,function(key,value){
                        $('.search-certificate_number').append('<option value="'+value.id+'">'+value.name+'</option>')
                    })
                }
                if(data.currentDrug.release_order.length){
                    var release_order = data.currentDrug.release_order;
                    $('.drug-settings-table tbody').append('<tr><td>Release Order</td><td><select class="form-control search-release_order"><option value="0"></option></select></td></tr>');
                    $.each(release_order,function(key,value){
                        $('.search-release_order').append('<option value="'+value.id+'">'+value.name+'</option>')
                    })
                }
                if(data.currentDrug.release_packaging.length){
                    var release_packaging = data.currentDrug.release_packaging;
                    $('.drug-settings-table tbody').append('<tr><td>Release Packaging</td><td><select class="form-control search-release_packaging"><option value="0"></option></select></td></tr>');
                    $.each(release_packaging,function(key,value){
                        $('.search-release_packaging').append('<option value="'+value.id+'">'+value.name+'</option>')
                    })
                }
                if(data.currentDrug.type_belonging.length){
                    var type_belonging = data.currentDrug.type_belonging;
                    $('.drug-settings-table tbody').append('<tr><td>Type Belonging</td><td><select class="form-control search-type_belonging"><option value="0"></option></select></td></tr>');
                    $.each(type_belonging,function(key,value){
                        $('.search-type_belonging').append('<option value="'+value.id+'">'+value.name+'</option>')
                    })
                }
                if(data.currentDrug.registration_certificate_holder.length){
                    var registration_certificate_holder = data.currentDrug.registration_certificate_holder;
                    $('.drug-settings-table tbody').append('<tr><td>Registration Certificate Holder</td><td><select class="form-control search-registration_certificate_holder"><option value="0"></option></select></td></tr>');
                    $.each(registration_certificate_holder,function(key,value){
                        $('.search-registration_certificate_holder').append('<option value="'+value.id+'">'+value.name+'</option>')
                    })
                }
                if(data.currentDrug.character.length){
                    var character = data.currentDrug.character;
                    $('.drug-settings-table tbody').append('<tr><td>Character</td><td><select class="form-control search-character"><option value="0"></option></select></td></tr>');
                    $.each(character,function(key,value){
                        $('.search-character').append('<option value="'+value.id+'" data-text="'+value.name+'">'+value.name.substring(0, 10)+'...</option>')
                    })
                    $('.search-character').after('<button class="open-character btn blue">Open</button>')
                }
                if(data.currentDrug.picture.length){
                    var picture = data.currentDrug.picture;
                    $('.drug-settings-table tbody').append('<tr><td>Picture</td><td><select class="form-control search-picture"><option value="0"></option></select></td></tr>');
                    $.each(picture,function(key,value){
                        $('.search-picture').append('<option value="'+value.id+'" data-src="'+value.name+'">'+value.name+'</option>')
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
        var access = true;
        var count = $('.storage-actions-table').find('.row-settings').length;
        var drug_id = $('.drug-search-results').val();
        var $data = {info:{}};
        $(".drug-settings-table").find('select').each(function(key,value){
            val = $(value).val();
            if(parseInt($(value).val())){
                var classList = $(value).attr('class').split(/\s+/);
                $.each(classList, function(index, item) {
                    if (item !== 'form-control') {
                        sub_value = item.split('search-')[1];
                        $data.info[sub_value] = val;
                    }
                });
            }
        });
        $('.storage-actions-table tbody tr:first-child').each(function(key,value){
            if($(value).find('.row-settings').val() == JSON.stringify($data['info']) && parseInt($(value).find('.row-drug-id').val()) == drug_id){
                $.alert({
                    title: 'Warning!',
                    content: 'This drug is already exists in current insert table!',
                });
                access = false;
            }
        });
        if(Object.keys($data['info']).length != 0 && access){
            $data['drug_id'] = drug_id;
            token = $(this).children('input[name="_token"]').val();
            $data['_token'] = token;
            $.ajax({
                url: '/admin/storage/checkDrug',
                type: 'POST',
                data: $data ,
                dataType: 'json',
                success: function(data){
                    if(data){
                        $.confirm({
                            animation: 'bottom',
                            closeAnimation: 'bottom',
                            title: 'Confirm!',
                            content: 'This drug with this params already exists. Only quantity will increase',
                            buttons: {
                                confirm: function () {
                                    $('.storage-actions-table tr').find('.search-drug-button').each(function(key,value){
                                        if($(value).attr('data-id') == $('.search-drug').attr('data-id')){
                                            $(this).parent().parent().addClass('process');
                                            row_id = $(value).attr('data-id');
                                            settings = JSON.stringify($data['info']);
                                            $("#search_drug").modal('hide');
                                            $(this).parent().html("<button class='remove-storage-row btn btn-warning' data-id='"+$(value).attr('data-id')+"'>Clear</button>" + $('.drug-search-results').children('option[value="'+$('.drug-search-results').val()+'"]').html()+"<input type='hidden' class='row-settings' name='settings_"+count+"' value='"+settings+"'><input type='hidden' class='row-drug-id' name='drug_id_"+count+"' value='"+$data.drug_id+"'><input type='hidden' class='row-exist' name='exist_"+count+"' value='1'>");
                                            return false;
                                        }
                                    })
                                    $('.save-all-storage').attr('data-count',++count);
                                },
                                cancel: function () {

                                }
                            }
                        });
                    }else{
                        $('.storage-actions-table tr').find('.search-drug-button').each(function(key,value){
                            if($(value).attr('data-id') == $('.search-drug').attr('data-id')){
                                $(this).parent().parent().addClass('process');
                                row_id = $(value).attr('data-id');
                                settings = JSON.stringify($data['info']);
                                $("#search_drug").modal('hide');
                                $(this).parent().html("<button data-id='"+$(value).attr('data-id')+"' class='remove-storage-row btn btn-warning'>Clear</button>" + $('.drug-search-results').children('option[value="'+$('.drug-search-results').val()+'"]').html()+"<input type='hidden' class='row-settings' name='settings_"+count+"' value='"+settings+"'><input type='hidden' class='row-drug-id' name='drug_id_"+count+"' value='"+$data.drug_id+"'><input type='hidden' class='row-exist' name='exist_"+count+"' value='0'>");
                                return false;
                            }
                        })
                        $('.save-all-storage').attr('data-count',++count);
                    }
                }
            })
        }
    })
    $(document).on('click','.remove-storage-row',function(){
        $(this).parent().parent().removeClass('process');
        count = $('.save-all-storage').attr('data-count');
        $(this).parent().html('<button type="button" class="btn btn-success search-drug-button" data-id="'+$(this).attr('data-id')+'">Search</button>')
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
        console.log(_token);
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
    $(document).on("submit",".storage-save-all",function(e){
        e.preventDefault();
        var i = 0;
        var $data = [];
        var $send_data = {};
        var access = true;

        if($(".storage-actions-table tbody tr.process").length == 0){
            $.alert({
                title: 'Warning!',
                content: 'No Drugs for save!',
            });
            return true;
        }
        $(".storage-actions-table tbody tr.process").each(function(key,value){
            var row = {};
            var settings = $(this).find('.row-settings').val();
            var drug_id = $(this).find('.row-drug-id').val();
            var count = $(this).find('input[name="count"]').val();
            var exist = $(this).find('.row-exist').val();
            if(count == ''){
                $.alert({
                    title: 'Warning!',
                    content: 'Check Drug counts!',
                });
                access = false;
            }
            row['settings'] = settings;
            row['drug_id'] = drug_id;
            row['count'] = count;
            row['exist'] = exist;
            $data.push(row);

        });
        if(access){
            var _token = $('.storage-save-all').children('input[name="_token"]').val();
            $send_data['_token'] = _token;
            $send_data['info'] = $data;
            $('.save-all-storage').html('Saving...')
            $.ajax({
                url: '/admin/storage/saveAll',
                type: 'POST',
                data: $send_data ,
                dataType: 'json',
                success: function(data){
                    location.replace('/admin/storage')
                }
            });
        }
        return false;
    })


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
        $.ajax({
            url: '/admin/storage/'+id,
            type: 'GET',
            dataType: 'json',
            success: function(data){
                var settings = JSON.parse(data.storage.drug_settings);
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
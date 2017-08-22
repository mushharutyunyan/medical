@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>Edit drug
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse">
                        </a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {{ Form::model($currentDrug, ['url' => '/admin/manage/drugs/'.$currentDrug->id, 'method' => 'PUT', 'class' => 'form-horizontal form-bordered drug-form', "enctype" => "multipart/form-data"]) }}
                    <div class="form-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul class="list-group">
                                    @foreach ($errors->all() as $error)
                                        <li class="list-group-item">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group">
                            <label class="control-label col-md-6">Trade Name - торговое название (Առևտրային անվանում)</label>
                            <div class="col-md-4">
                                {{Form::text('trade_name',$currentDrug->trade_name,['class' => 'form-control'])}}
                                {{Form::text('trade_name_ru',$currentDrug->trade_name_ru,['class' => 'form-control','placeholder' => 'russian name'])}}
                                {{Form::text('trade_name_en',$currentDrug->trade_name_en,['class' => 'form-control','placeholder' => 'english name'])}}
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Generic Name - вещество (Ազդող նյութ)</label>
                            <div class="col-md-4">
                                {{Form::text('generic_name',$currentDrug->generic_name,['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Dosage Form - форма (Դեղաձև)</label>
                            <div class="col-md-4">
                                {{Form::text('dosage_form',$currentDrug->dosage_form,['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Dosage Strength - дозировка (Դեղաչափ)</label>
                            <div class="col-md-4">
                                {{Form::text('dosage_strength',$currentDrug->dosage_strength,['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Code</label>
                            <div class="col-md-4">
                                {{Form::text('code',$currentDrug->code,['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Category</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="category"><i class="fa fa-plus"></i></a>
                                @if($categories->count() != 0   || Input::old('category') != 0)
                                    @if(Input::old('category') != 0)
                                        @for($i = 1; $i <= Input::old('category'); $i++)
                                            {{Form::text('category_'.$i,Input::old('category_'.$i),['class' => 'form-control'])}}
                                        @endfor
                                        {{Form::hidden('category',Input::old('category'),['class' => 'form-control'])}}
                                    @else
                                        <?php $i = 1; ?>
                                        @foreach($categories as $category)
                                            {{Form::text('category_'.$i,$category->name,['class' => 'form-control'])}}
                                            <?php $i++; ?>
                                        @endforeach
                                        {{Form::hidden('category',$categories->count(),['class' => 'form-control'])}}
                                    @endif


                                @else
                                {{Form::text('category_1','',['class' => 'form-control'])}}
                                {{Form::hidden('category',1,['class' => 'form-control'])}}
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Group</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="category"><i class="fa fa-plus"></i></a>
                                @if($group->count() != 0  || Input::old('group') != 0)
                                    @if(Input::old('group') != 0)
                                        @for($i = 1; $i <= Input::old('group'); $i++)
                                            {{Form::text('group_'.$i,Input::old('group_'.$i),['class' => 'form-control'])}}
                                        @endfor
                                        {{Form::hidden('group',Input::old('group'),['class' => 'form-control'])}}
                                    @else
                                        <?php $i = 1; ?>
                                        @foreach($group as $value)
                                            {{Form::text('group_'.$i,$value->name,['class' => 'form-control'])}}
                                            <?php $i++; ?>
                                        @endforeach
                                        {{Form::hidden('group',$group->count(),['class' => 'form-control'])}}
                                    @endif

                                @else
                                {{Form::text('group_1','',['class' => 'form-control'])}}
                                {{Form::hidden('group','1',['class' => 'form-control'])}}
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Type</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="type"><i class="fa fa-plus"></i></a>
                                @if($type->count() != 0  || Input::old('type') != 0)
                                    @if(Input::old('type') != 0)
                                        @for($i = 1; $i <= Input::old('type'); $i++)
                                            {{Form::text('type_'.$i,Input::old('type_'.$i),['class' => 'form-control'])}}
                                        @endfor
                                        {{Form::hidden('type',$type->count(),['class' => 'form-control'])}}
                                    @else
                                        <?php $i = 1; ?>
                                        @foreach($type as $value)
                                            {{Form::text('type_'.$i,$value->name,['class' => 'form-control'])}}
                                            <?php $i++; ?>
                                        @endforeach
                                        {{Form::hidden('type',$type->count(),['class' => 'form-control'])}}
                                    @endif

                                @else
                                {{Form::text('type_1','',['class' => 'form-control'])}}
                                {{Form::hidden('type','1',['class' => 'form-control'])}}
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-6">Series</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="series"><i class="fa fa-plus"></i></a>
                                @if($series->count() != 0 || Input::old('series') != 0)
                                    @if(Input::old('series') != 0)
                                        @for($i = 1; $i <= Input::old('series'); $i++)
                                            {{Form::text('series_'.$i,Input::old('series_'.$i),['class' => 'form-control'])}}
                                        @endfor
                                        {{Form::hidden('series',Input::old('series'),['class' => 'form-control'])}}
                                    @else
                                        <?php $i = 1; ?>
                                        @foreach($series as $value)
                                            {{Form::text('series_'.$i,$value->name,['class' => 'form-control'])}}
                                            <?php $i++; ?>
                                        @endforeach
                                        {{Form::hidden('series',$series->count(),['class' => 'form-control'])}}
                                    @endif
                                @else
                                {{Form::text('series_1','',['class' => 'form-control'])}}
                                {{Form::hidden('series','1',['class' => 'form-control'])}}
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Country</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="country"><i class="fa fa-plus"></i></a>
                                @if($country->count() != 0 || Input::old('country') != 0)
                                    @if(Input::old('country') != 0)
                                        @for($i = 1; $i <= Input::old('country'); $i++)
                                            {{Form::text('country_'.$i,Input::old('country_'.$i),['class' => 'form-control'])}}
                                        @endfor
                                        {{Form::hidden('country',Input::old('country'),['class' => 'form-control'])}}
                                    @else
                                        <?php $i = 1; ?>
                                        @foreach($country as $value)
                                            {{Form::text('country_'.$i,$value->name,['class' => 'form-control'])}}
                                            <?php $i++; ?>
                                        @endforeach
                                        {{Form::hidden('country',$country->count(),['class' => 'form-control'])}}
                                    @endif
                                @else
                                {{Form::text('country_1','',['class' => 'form-control'])}}
                                {{Form::hidden('country','1',['class' => 'form-control'])}}
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Manufacturer</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="manufacturer"><i class="fa fa-plus"></i></a>
                                @if($manufacturer->count() != 0 || Input::old('manufacturer') != 0)
                                    @if(Input::old('manufacturer') != 0)
                                        @for($i = 1; $i <= Input::old('manufacturer'); $i++)
                                            {{Form::text('manufacturer_'.$i,Input::old('manufacturer_'.$i),['class' => 'form-control'])}}
                                        @endfor
                                        {{Form::hidden('manufacturer',Input::old('manufacturer'),['class' => 'form-control'])}}
                                    @else
                                        <?php $i = 1; ?>
                                        @foreach($manufacturer as $value)
                                            {{Form::text('manufacturer_'.$i,$value->name,['class' => 'form-control'])}}
                                            <?php $i++; ?>
                                        @endforeach
                                        {{Form::hidden('manufacturer',$manufacturer->count(),['class' => 'form-control'])}}
                                    @endif

                                @else
                                {{Form::text('manufacturer_1','',['class' => 'form-control'])}}
                                {{Form::hidden('manufacturer','1',['class' => 'form-control'])}}
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Unit - измерение (Չափման միավոր)</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="unit"><i class="fa fa-plus"></i></a>
                                @if($unit->count() != 0 || Input::old('unit') != 0)
                                    @if(Input::old('unit') != 0)
                                        @for($i = 1; $i <= Input::old('unit'); $i++)
                                            {{Form::text('unit_'.$i,Input::old('unit_'.$i),['class' => 'form-control'])}}
                                        @endfor
                                        {{Form::hidden('unit',Input::old('unit'),['class' => 'form-control'])}}
                                    @else
                                        <?php $i = 1; ?>
                                        @foreach($unit as $value)
                                            {{Form::text('unit_'.$i,$value->name,['class' => 'form-control'])}}
                                            <?php $i++; ?>
                                        @endforeach
                                        {{Form::hidden('unit',$unit->count(),['class' => 'form-control'])}}
                                    @endif
                                @else
                                {{Form::text('unit_1','',['class' => 'form-control'])}}
                                {{Form::hidden('unit','1',['class' => 'form-control'])}}
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Release Packaging - Форма производства (тип упаковки) (Թողարկման ձևը (փաթեթավորումը) )</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="release_packaging"><i class="fa fa-plus"></i></a>
                                @if($releasePackaging->count() != 0 || Input::old('release_packaging') != 0)
                                    @if(Input::old('release_packaging') != 0)
                                        @for($i = 1; $i <= Input::old('release_packaging'); $i++)
                                            {{Form::text('release_packaging_'.$i,Input::old('release_packaging_'.$i),['class' => 'form-control'])}}
                                        @endfor
                                        {{Form::hidden('release_packaging',Input::old('release_packaging'),['class' => 'form-control'])}}
                                    @else
                                        <?php $i = 1; ?>
                                        @foreach($releasePackaging as $value)
                                            {{Form::text('release_packaging_'.$i,$value->name,['class' => 'form-control'])}}
                                            <?php $i++; ?>
                                        @endforeach
                                        {{Form::hidden('release_packaging',$releasePackaging->count(),['class' => 'form-control'])}}
                                    @endif
                                @else
                                {{Form::text('release_packaging_1','',['class' => 'form-control'])}}
                                {{Form::hidden('release_packaging','1',['class' => 'form-control'])}}
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Count - Количество в упаковке (N) (тип упаковки) (Միավորների քանակը տուփում(N))</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="count"><i class="fa fa-plus"></i></a>
                                @if($count->count() != 0 || Input::old('count') != 0)
                                    @if(Input::old('count') != 0)
                                        @for($i = 1; $i <= Input::old('count'); $i++)
                                            {{Form::text('count_'.$i,Input::old('count_'.$i),['class' => 'form-control'])}}
                                        @endfor
                                        {{Form::hidden('count',Input::old('count'),['class' => 'form-control'])}}
                                    @else
                                        <?php $i = 1; ?>
                                        @foreach($count as $value)
                                            {{Form::text('count_'.$i,$value->count,['class' => 'form-control'])}}
                                            <?php $i++; ?>
                                        @endforeach
                                        {{Form::hidden('count',$count->count(),['class' => 'form-control'])}}
                                    @endif
                                @else
                                {{Form::text('count_1','',['class' => 'form-control'])}}
                                {{Form::hidden('count','1',['class' => 'form-control'])}}
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Unit Price</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="unit_price"><i class="fa fa-plus"></i></a>
                                @if($unit_price->count() != 0 || Input::old('unit_price') != 0)
                                    @if(Input::old('unit_price') != 0)
                                        @for($i = 1; $i <= Input::old('unit_price'); $i++)
                                            {{Form::text('unit_price_'.$i,Input::old('unit_price_'.$i),['class' => 'form-control'])}}
                                        @endfor
                                        {{Form::hidden('unit_price',Input::old('unit_price'),['class' => 'form-control'])}}
                                    @else
                                        <?php $i = 1; ?>
                                        @foreach($unit_price as $value)
                                            {{Form::text('unit_price_'.$i,$value->price,['class' => 'form-control'])}}
                                            <?php $i++; ?>
                                        @endforeach
                                        {{Form::hidden('unit_price',$unit_price->count(),['class' => 'form-control'])}}
                                    @endif
                                @else
                                {{Form::text('unit_price_1','',['class' => 'form-control'])}}
                                {{Form::hidden('unit_price','1',['class' => 'form-control'])}}
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Supplier - поставщик (Մատակարար)</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="supplier"><i class="fa fa-plus"></i></a>
                                @if($supplier->count() != 0 || Input::old('supplier') != 0)
                                    @if(Input::old('supplier') != 0)
                                        @for($i = 1; $i <= Input::old('supplier'); $i++)
                                            {{Form::text('supplier_'.$i,Input::old('supplier_'.$i),['class' => 'form-control'])}}
                                        @endfor
                                        {{Form::hidden('supplier',Input::old('supplier'),['class' => 'form-control'])}}
                                    @else
                                        <?php $i = 1; ?>
                                        @foreach($supplier as $value)
                                            {{Form::text('supplier_'.$i,$value->name,['class' => 'form-control'])}}
                                            <?php $i++; ?>
                                        @endforeach
                                        {{Form::hidden('supplier',$supplier->count(),['class' => 'form-control'])}}
                                    @endif
                                @else
                                {{Form::text('supplier_1','',['class' => 'form-control'])}}
                                {{Form::hidden('supplier','1',['class' => 'form-control'])}}
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Type Belonging - (տեսակային պատկանելիություն)</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="type_belonging"><i class="fa fa-plus"></i></a>
                                @if($type_belonging->count() != 0 || Input::old('type_belonging') != 0)
                                    @if(Input::old('type_belonging') != 0)
                                        @for($i = 1; $i <= Input::old('type_belonging'); $i++)
                                            {{Form::text('type_belonging_'.$i,Input::old('type_belonging_'.$i),['class' => 'form-control'])}}
                                        @endfor
                                        {{Form::hidden('type_belonging',Input::old('type_belonging'),['class' => 'form-control'])}}
                                    @else
                                        <?php $i = 1; ?>
                                        @foreach($type_belonging as $value)
                                            {{Form::text('type_belonging_'.$i,$value->name,['class' => 'form-control'])}}
                                            <?php $i++; ?>
                                        @endforeach
                                        {{Form::hidden('type_belonging',$type_belonging->count(),['class' => 'form-control'])}}
                                    @endif
                                @else
                                {{Form::text('type_belonging_1','',['class' => 'form-control'])}}
                                {{Form::hidden('type_belonging','1',['class' => 'form-control'])}}
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Certificate Number - (Հավաստագրի համարը)</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="certificate_number"><i class="fa fa-plus"></i></a>
                                @if($certificate_number->count() != 0 || Input::old('certificate_number') != 0)
                                    @if(Input::old('certificate_number') != 0)
                                        @for($i = 1; $i <= Input::old('certificate_number'); $i++)
                                            {{Form::text('certificate_number_'.$i,Input::old('certificate_number_'.$i),['class' => 'form-control'])}}
                                        @endfor
                                        {{Form::hidden('certificate_number',Input::old('certificate_number'),['class' => 'form-control'])}}
                                    @else
                                        <?php $i = 1; ?>
                                        @foreach($certificate_number as $value)
                                            {{Form::text('certificate_number_'.$i,$value->name,['class' => 'form-control'])}}
                                            <?php $i++; ?>
                                        @endforeach
                                        {{Form::hidden('certificate_number',$certificate_number->count(),['class' => 'form-control'])}}
                                    @endif
                                @else
                                    {{Form::text('certificate_number_1','',['class' => 'form-control'])}}
                                    {{Form::hidden('certificate_number','1',['class' => 'form-control'])}}
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Registration Date - (գրանցման ժամկետը)</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="registration_date"><i class="fa fa-plus"></i></a>
                                @if($registration_date->count() != 0 || Input::old('registration_date') != 0)
                                    @if(Input::old('registration_date') != 0)
                                        @for($i = 1; $i <= Input::old('registration_date'); $i++)
                                            {{Form::text('registration_date_'.$i,Input::old('registration_date_'.$i),['class' => 'form-control datepicker','data-date-format' => 'yyyy-mm'])}}
                                        @endfor
                                        {{Form::hidden('registration_date',Input::old('registration_date'),['class' => 'form-control'])}}
                                    @else
                                        <?php $i = 1; ?>
                                        @foreach($registration_date as $value)
                                            {{Form::text('registration_date_'.$i,$value->date,['class' => 'form-control datepicker','data-date-format' => 'yyyy-mm'])}}
                                            <?php $i++; ?>
                                        @endforeach
                                        {{Form::hidden('registration_date',$registration_date->count(),['class' => 'form-control'])}}
                                    @endif
                                @else
                                    {{Form::text('registration_date_1','',['class' => 'form-control datepicker','data-date-format' => 'yyyy-mm'])}}
                                    {{Form::hidden('registration_date','1',['class' => 'form-control'])}}
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Expiration Date - (Պահպանման ժամկետը)</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="expiration_date"><i class="fa fa-plus"></i></a>
                                @if($expiration_date->count() != 0 || Input::old('expiration_date') != 0)
                                    @if(Input::old('expiration_date') != 0)
                                        @for($i = 1; $i <= Input::old('expiration_date'); $i++)
                                            {{Form::text('expiration_date_'.$i,Input::old('expiration_date_'.$i),['class' => 'form-control datepicker','data-date-format' => 'yyyy-mm'])}}
                                        @endfor
                                        {{Form::hidden('expiration_date',Input::old('expiration_date'),['class' => 'form-control'])}}
                                    @else
                                        <?php $i = 1; ?>
                                        @foreach($expiration_date as $value)
                                            {{Form::text('expiration_date_'.$i,$value->date,['class' => 'form-control datepicker','data-date-format' => 'yyyy-mm'])}}
                                            <?php $i++; ?>
                                        @endforeach
                                        {{Form::hidden('expiration_date',$expiration_date->count(),['class' => 'form-control'])}}
                                    @endif
                                @else
                                {{Form::text('expiration_date_1','',['class' => 'form-control datepicker','data-date-format' => 'yyyy-mm'])}}
                                {{Form::hidden('expiration_date','1',['class' => 'form-control'])}}
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Registration Certificate Holder - (Գրանցման հավաստագրի իրավատերը)</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="registration_certificate_holder"><i class="fa fa-plus"></i></a>
                                @if($registration_certificate_holder->count() != 0 || Input::old('registration_certificate_holder') != 0)
                                    @if(Input::old('registration_certificate_holder') != 0)
                                        @for($i = 1; $i <= Input::old('registration_certificate_holder'); $i++)
                                            {{Form::text('registration_certificate_holder_'.$i,Input::old('registration_certificate_holder_'.$i),['class' => 'form-control'])}}
                                        @endfor
                                        {{Form::hidden('registration_certificate_holder',Input::old('registration_certificate_holder'),['class' => 'form-control'])}}
                                    @else
                                        <?php $i = 1; ?>
                                        @foreach($registration_certificate_holder as $value)
                                            {{Form::text('registration_certificate_holder_'.$i,$value->name,['class' => 'form-control'])}}
                                            <?php $i++; ?>
                                        @endforeach
                                        {{Form::hidden('registration_certificate_holder',$registration_certificate_holder->count(),['class' => 'form-control'])}}
                                    @endif
                                @else
                                {{Form::text('registration_certificate_holder_1','',['class' => 'form-control'])}}
                                {{Form::hidden('registration_certificate_holder','1',['class' => 'form-control'])}}
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Release Form - (Բացթողնման կարգը)</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="release_form"><i class="fa fa-plus"></i></a>
                                @if($release_order->count() != 0 || Input::old('release_order') != 0)
                                    @if(Input::old('release_order') != 0)
                                        @for($i = 1; $i <= Input::old('release_order'); $i++)
                                            {{Form::text('release_order_'.$i,Input::old('release_order_'.$i),['class' => 'form-control'])}}
                                        @endfor
                                        {{Form::hidden('release_order',Input::old('release_order'),['class' => 'form-control'])}}
                                    @else
                                        <?php $i = 1; ?>
                                        @foreach($release_order as $value)
                                            {{Form::text('release_order_'.$i,$value->name,['class' => 'form-control'])}}
                                            <?php $i++; ?>
                                        @endforeach
                                        {{Form::hidden('release_order',$release_order->count(),['class' => 'form-control'])}}
                                    @endif
                                @else
                                {{Form::text('release_order_1','',['class' => 'form-control'])}}
                                {{Form::hidden('release_order','1',['class' => 'form-control'])}}
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Character</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="character"><i class="fa fa-plus"></i></a>
                                @if($character->count() != 0 || Input::old('character') != 0)
                                    @if(Input::old('character') != 0)
                                        @for($i = 1; $i <= Input::old('character'); $i++)
                                            {{Form::text('character_'.$i,Input::old('character_'.$i),['class' => 'form-control'])}}
                                        @endfor
                                        {{Form::hidden('character',Input::old('character'),['class' => 'form-control'])}}
                                    @else
                                        <?php $i = 1; ?>
                                        @foreach($character as $value)
                                            {{Form::text('character_'.$i,$value->name,['class' => 'form-control '])}}
                                            <?php $i++; ?>
                                        @endforeach
                                        {{Form::hidden('character',$character->count(),['class' => 'form-control'])}}
                                    @endif
                                @else
                                {{Form::textarea('character_1','',['class' => 'form-control'])}}
                                {{Form::hidden('character','1',['class' => 'form-control'])}}
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Picture</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="picture"><i class="fa fa-plus"></i></a>
                                @if($picture->count() != 0)
                                    <?php $i = 1; ?>
                                    @foreach($picture as $value)
                                        <div class="image-block">
                                            <a class="image-block-delete" data-iteration="{{$i}}"><i class="fa fa-remove"></i></a>
                                            <img src="/assets/admin/images/drugs/{{$value->name}}">
                                            {{Form::hidden('picture_'.$i,$value->name,['class' => 'form-control'])}}
                                        </div>
                                        <?php $i++; ?>
                                    @endforeach
                                    {{Form::hidden('picture',$picture->count(),['class' => 'form-control'])}}
                                @else
                                {{Form::file('picture_1','',['class' => 'form-control'])}}
                                {{Form::hidden('picture','1',['class' => 'form-control'])}}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-6 col-md-6">
                                <button type="submit" class="btn green"><i class="fa fa-check"></i> Submit</button>
                                <a href="{{url()->previous()}}" type="button" class="btn default">Cancel</a>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                <!-- END FORM-->
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
    </div>
@endsection

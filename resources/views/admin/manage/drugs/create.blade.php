@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>Create new drug
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse">
                        </a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {!! Form::open(['url' => 'admin/manage/drugs', "class" => "form-horizontal form-bordered drug-form", "enctype" => "multipart/form-data"]) !!}
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
                                {{Form::text('trade_name','',['class' => 'form-control'])}}
                                {{Form::text('trade_name_ru','',['class' => 'form-control','placeholder' => 'russian name'])}}
                                {{Form::text('trade_name_en','',['class' => 'form-control','placeholder' => 'english name'])}}
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Generic Name - вещество (Ազդող նյութ)</label>
                            <div class="col-md-4">
                                {{Form::text('generic_name','',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Dosage Form - форма (Դեղաձև)</label>
                            <div class="col-md-4">
                                {{Form::text('dosage_form','',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Dosage Strength - дозировка (Դեղաչափ)</label>
                            <div class="col-md-4">
                                {{Form::text('dosage_strength','',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Code</label>
                            <div class="col-md-4">
                                {{Form::text('code','',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Category</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="category"><i class="fa fa-plus"></i></a>
                                {{Form::text('category_1','',['class' => 'form-control'])}}
                                {{Form::hidden('category','1',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Group</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="category"><i class="fa fa-plus"></i></a>
                                {{Form::text('group_1','',['class' => 'form-control'])}}
                                {{Form::hidden('group','1',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Type</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="type"><i class="fa fa-plus"></i></a>
                                {{Form::text('type_1','',['class' => 'form-control'])}}
                                {{Form::hidden('type','1',['class' => 'form-control'])}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-6">Series</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="series"><i class="fa fa-plus"></i></a>
                                {{Form::text('series_1','',['class' => 'form-control'])}}
                                {{Form::hidden('series','1',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Country</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="country"><i class="fa fa-plus"></i></a>
                                {{Form::text('country_1','',['class' => 'form-control'])}}
                                {{Form::hidden('country','1',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Manufacturer</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="manufacturer"><i class="fa fa-plus"></i></a>
                                {{Form::text('manufacturer_1','',['class' => 'form-control'])}}
                                {{Form::hidden('manufacturer','1',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Unit - измерение (Չափման միավոր)</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="unit"><i class="fa fa-plus"></i></a>
                                {{Form::text('unit_1','',['class' => 'form-control'])}}
                                {{Form::hidden('unit','1',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Release Packaging - Форма производства (тип упаковки) (Թողարկման ձևը (փաթեթավորումը) )</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="release_packaging"><i class="fa fa-plus"></i></a>
                                {{Form::text('release_packaging_1','',['class' => 'form-control'])}}
                                {{Form::hidden('release_packaging','1',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Count - Количество в упаковке (N) (тип упаковки) (Միավորների քանակը տուփում(N))</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="count"><i class="fa fa-plus"></i></a>
                                {{Form::text('count_1','',['class' => 'form-control'])}}
                                {{Form::hidden('count','1',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Unit Price</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="unit_price"><i class="fa fa-plus"></i></a>
                                {{Form::text('unit_price_1','',['class' => 'form-control'])}}
                                {{Form::hidden('unit_price','1',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Supplier - поставщик (Մատակարար)</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="supplier"><i class="fa fa-plus"></i></a>
                                {{Form::text('supplier_1','',['class' => 'form-control'])}}
                                {{Form::hidden('supplier','1',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Type Belonging - (տեսակային պատկանելիություն)</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="type_belonging"><i class="fa fa-plus"></i></a>
                                {{Form::text('type_belonging_1','',['class' => 'form-control'])}}
                                {{Form::hidden('type_belonging','1',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Certificate Number - (Հավաստագրի համարը)</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="certificate_number"><i class="fa fa-plus"></i></a>
                                {{Form::text('certificate_number_1','',['class' => 'form-control'])}}
                                {{Form::hidden('certificate_number','1',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Registration Date - (գրանցման ժամկետը)</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="registration_date"><i class="fa fa-plus"></i></a>
                                {{Form::text('registration_date_1','',['class' => 'form-control datepicker','data-date-format' => 'yyyy-mm-dd'])}}
                                {{Form::hidden('registration_date','1',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Expiration Date - (Պահպանման ժամկետը)</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="expiration_date"><i class="fa fa-plus"></i></a>
                                {{Form::text('expiration_date_1','',['class' => 'form-control datepicker','data-date-format' => 'yyyy-mm-dd'])}}
                                {{Form::hidden('expiration_date','1',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Registration Certificate Holder - (Գրանցման հավաստագրի իրավատերը)</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="registration_certificate_holder"><i class="fa fa-plus"></i></a>
                                {{Form::text('registration_certificate_holder_1','',['class' => 'form-control'])}}
                                {{Form::hidden('registration_certificate_holder','1',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Release Form - (Բացթողնման կարգը)</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="release_form"><i class="fa fa-plus"></i></a>
                                {{Form::text('release_order_1','',['class' => 'form-control'])}}
                                {{Form::hidden('release_order','1',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Character</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="character"><i class="fa fa-plus"></i></a>
                                {{Form::textarea('character_1','',['class' => 'form-control'])}}
                                {{Form::hidden('character','1',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Picture</label>
                            <div class="col-md-4">
                                <a class="add_drug_param" data-name="picture"><i class="fa fa-plus"></i></a>
                                {{Form::file('picture_1','',['class' => 'form-control'])}}
                                {{Form::hidden('picture','1',['class' => 'form-control'])}}
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

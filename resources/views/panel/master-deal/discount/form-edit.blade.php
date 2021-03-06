@extends('master') @section('content')
<link href="{{ asset('fiture-style/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('fiture-style/datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
<div class="container-fluid">
    <div class="animate fadeIn">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <p>
                    <a class="btn btn-primary" href="{{route('discount.index')}}">
                        <i class="fa fa-backward"></i>&nbsp; Back to List
                    </a>
                </p>
                <form id="jxForm" method="POST" action="{{ route('discount.update',['id' => $discount->id]) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <input type="hidden" class="id" name="id" value="{{ $discount->id }}">
                    <!--start card -->
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Create
                            <small>Discount</small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="title">*Discount Title
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Declaration of title discount"></i>
                                        </label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Title" aria-describedby="title-error" value="{{$discount->title}}" onkeyup="$('#keyID').val(convertToSlug($(this).val()));$('#keyID').valid();">
                                        <em id="title-error" class="error invalid-feedback"></em>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label" for="status">Set Status Discount
                                        <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Set discount status"></i>
                                    </label>
                                    <div class="form-group">
                                        <label class="switch switch-text switch-pill switch-success">
                                            <input type="checkbox" class="switch-input" id="status" name="status" {{($discount->status == 'on'? 'checked': '')}} tabindex="-1">
                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="title">*Discount Key ID
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Declaration of key id discount"></i>
                                        </label>
                                        <input type="text" class="form-control" id="keyID" name="keyID" placeholder="Key ID" aria-describedby="keyID-error" value="{{$discount->key_id}}">
                                        <em id="keyID-error" class="error invalid-feedback"></em>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="description">Description
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="description of discount"></i>
                                        </label>
                                        <input type="text" class="form-control" id="description" name="description" placeholder="description" value="{{$discount->description}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">*Value
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Set value discount"></i>
                                        </label>
                                        <div class="input-group">
                                            <input type="text" id="value" name="value" class="form-control text-right input-number" placeholder="00" aria-describedby="value-error" value="{{$discount->value}}">
                                            <div class="input-group-append">
                                                <input type="hidden" name="type" value="{{$discount->type}}">
                                                <button type="button" class="btn btn-secondary dropdown-toggle type-btn" data-toggle="dropdown">{{$discount->type=='price'?'.00':' % '}}
                                                    <span class="caret"></span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" onclick="changeType('price')">.00</a>
                                                    <a class="dropdown-item" onclick="changeType('percent')"> % </a>
                                                </div>
                                            </div>
                                            <em id="value-error" class="error invalid-feedback"></em>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">*Expired Date
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Set expired date"></i>
                                        </label>
                                        <input type="text" class="form-control" id="expiredDate" name="expiredDate" placeholder="0000-00-00 0:00:00" aria-describedby="expiredDate-error"
                                        value="{{$discount->expired_date}}">
                                        <em id="expiredDate-error" class="error invalid-feedback"></em>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end card -->

                    <!--start card -->
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Unique
                            <small>Modifier</small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">Brand
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Brand of product"></i>
                                        </label>
                                        <select id="brand" class="form-control" name="brand[]" multiple>
                                            <option value=""></option>
                                            @foreach($brands as $brand)
                                            <option value="{{$brand->id}}" <?php print((in_array($brand->id, array_column($discount->brands, '_id'))?'selected':'')); ?> >{{$brand->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">Category
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Category of product"></i>
                                        </label>
                                        <select id="category" class="form-control" name="category[]" multiple>
                                            <option value=""></option>
                                            @foreach($categories as $category)
                                            <option value="{{$category->id}}" <?php print((in_array($category->id, array_column($discount->categories, '_id'))?'selected':'')); ?> >{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">Product
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Product of member"></i>
                                        </label>
                                        <select id="product" class="form-control" name="product[]" multiple>
                                            <option value=""></option>
                                            @foreach($products as $product)
                                            <option value="{{$product->id}}" <?php print((in_array($product->id, array_column($discount->products, '_id'))?'selected':'')); ?> >{{$product->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">Level
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Level of member"></i>
                                        </label>
                                        <select id="level" class="form-control" name="level[]" multiple>
                                            <option value=""></option>
                                            @foreach($levels as $level)
                                            <option value="{{$level->id}}" <?php print((in_array($level->id, array_column($discount->levels, '_id'))?'selected':'')); ?> >{{$level->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">Member
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Target specific member"></i>
                                        </label>
                                        <select id="member" class="form-control" name="member[]" multiple>
                                            <option value=""></option>
                                            @foreach($members as $member)
                                            <option value="{{$member->id}}" <?php print((in_array($member->id, array_column($discount->members, '_id'))?'selected':'')); ?> >{{$member->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end card -->

                    <!--start card -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <a class="btn btn-secondary" href="{{route('discount.index')}}">
                                        <i class="fa fa-times-rectangle"></i>&nbsp;Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end card -->
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- /.container-fluid -->

@section('myscript')
<script src="{{ asset('fiture-style/select2/select2.min.js') }}"></script>
<script src="{{ asset('fiture-style/datetimepicker/build/js/moment.min.js') }}"></script>
<script src="{{ asset('fiture-style/datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<script>
    $('#brand').select2({
        theme: "bootstrap",
        placeholder: 'Brand'
    }).change(function () {
        $(this).parent('.form-group').find('.select2-selection').css('height', '55px');
    });

    $('#category').select2({
        theme: "bootstrap",
        placeholder: 'Category'
    }).change(function () {
        $(this).parent('.form-group').find('.select2-selection').css('height', '55px');
    });

    $('#product').select2({
        theme: "bootstrap",
        placeholder: 'Product'
    }).change(function () {
        $(this).parent('.form-group').find('.select2-selection').css('height', '55px');
    });

    $('#level').select2({
        theme: "bootstrap",
        placeholder: 'Level'
    }).change(function () {
        $(this).parent('.form-group').find('.select2-selection').css('height', '55px');
    });

    $('#member').select2({
        theme: "bootstrap",
        placeholder: 'Member'
    }).change(function () {
        $(this).parent('.form-group').find('.select2-selection').css('height', '55px');
    });

    $('#brand').change();
    $('#category').change();
    $('#product').change();
    $('#level').change();
    $('#member').change();
    $('#expiredDate').datetimepicker({
        format: 'YYYY-MM-DD H:mm:ss',
    });

    function changeType(typeValue){
        $("input[name='type']").val(typeValue);
        if(typeValue == 'price'){
            $(".type-btn").html('.00');
        }else{
            $(".type-btn").html('&nbsp;%&nbsp;');
        }
    }

    $("#jxForm").validate({
        rules: {
            title: {
                required: true,
            },
            keyID: {
                required: true,
                remote: {
                    url: '{{ route("discount.index") }}/find',
                    type: "post",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: $('.id').val(),
                        keyID: function () {
                            return $('#jxForm :input[name="keyID"]').val();
                        }
                    }
                }
            },
            value: {
                required: true,
            },
            expiredDate: {
                required: true,
            }
        },
        messages: {
            title: {
                required: 'Please enter title',
            },
            keyID: {
                required: 'Please enter key id',
                remote: 'Key ID already in use. Please use other key id.'
            },
            value: {
                required: 'Please set value',
            },
            expiredDate: {
                required: 'Please set expired date',
            }
        },
        errorElement: 'em',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass('is-valid').removeClass('is-invalid');
        },
        ignore: "#editor *"
    });
</script>
@endsection
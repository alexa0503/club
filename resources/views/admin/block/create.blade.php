@extends('layouts.admin')
@section('content')
    @php
    $name = Request::get('name') ? : 'graphic';
    @endphp
    <div class="page-content sidebar-page right-sidebar-page clearfix">
        <!-- .page-content-wrapper -->
        <div class="page-content-wrapper">
            <div class="page-content-inner">
                <!-- Start .page-content-inner -->
                <div id="page-header" class="clearfix">
                    <div class="page-header">
                        <h2>区块管理 - {{$page->title}}  - 新增</h2>
                    </div>
                </div>
                <!-- Start .row -->
                <div class="row">
                    <div class="col-lg-12">
                        <!-- col-lg-12 start here -->
                        <div class="panel panel-default">
                            <!-- Start .panel -->
                            <div class="panel-body pt0 pb0">
                                {{ Form::open(array('route' => ['page.block.store', Request::segment(3)], 'class'=>'form-horizontal group-border stripped', 'id'=>'form')) }}
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">区块种类</label>
                                        <div class="col-lg-10 col-md-9">
                                            <select id="name" name="name" class="select2 form-control">
                                                <option value="">请选择区块种类</option>
                                                @foreach ($blocks as $key=>$block)
                                                <option value="{{$key}}" @if ($key == $name){{'selected="selected"'}}@endif>{{$block}}</option>
                                                @endforeach
                                            </select>
                                            <label class="help-block" for="name"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">标题</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" name="title" class="form-control" value="">
                                            <label class="help-block" for="title"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">描述</label>
                                        <div class="col-lg-10 col-md-9">
                                            <textarea name="description" class="form-control" rows="5" placeholder="请输入"></textarea>
                                            <label class="help-block" for="description"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    @if ($name == 'graphic')
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">内容</label>
                                        <div class="col-lg-10 col-md-9">
                                            <textarea name="content" class="form-control" rows="5" placeholder="请输入"></textarea>
                                            <label class="help-block" for="content"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    @endif
                                    @if ($name == 'kv' || $name == 'graphic')
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-3 control-label" for="">头图</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input id="header-explorer" name="file1" type="file" multiple >
                                            <input name="header_image" value="" type="hidden" />
                                            <label class="help-block" for="image"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    @endif
                                    @if ($name == 'graphic')
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-3 control-label" for="">背景图/大图</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input id="bkg-explorer" name="file2" type="file" multiple >
                                            <input name="bkg_image" value="" type="hidden" />
                                            <label class="help-block" for="image_bkg"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    @endif
                                    @if ($name == 'gallery')
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-3 control-label" for="">图库</label>
                                        <div class="col-lg-10 col-md-9" id="div-gallery">
                                            <input id="gallery-explorer" name="file3[]" type="file" multiple >
                                            <label class="help-block" for="gallery[]"></label>

                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    @endif
                                    @if($name == 'video' || $name == 'kv')
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">链接</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" name="link" class="form-control" value="">
                                            <label class="help-block" for="link"></label>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">排序</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" name="sort_id" class="form-control" value="">
                                            <label class="help-block" for="sort_id"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">是否发布</label>
                                        <div class="col-lg-10 col-md-9">
                                            <select name="is_posted" class="form-control">
                                                <option value="1">是</option>
                                                <option value="0" selected="selected">否</option>
                                            </select>
                                            <label class="help-block" for="is_posted"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-3 control-label"></label>
                                        <div class="col-lg-10 col-md-9">
                                            <button class="btn btn-default ml15" type="submit">提 交</button>
                                            <a class="btn btn-default ml15" href="{{url('admin/page/index')}}">返回</a>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    {{ Form::close() }}
                            </div>
                        </div>
                        <!-- End .panel -->
                    </div>
                    <!-- col-lg-12 end here -->
                </div>
                <!-- End .row -->
            </div>
            <!-- End .page-content-inner -->
        </div>
        <!-- / page-content-wrapper -->
    </div>
@endsection
@section('scripts')
<script>
$(document).ready(function() {
    $('.select2').select2();
    $('#name').on('change', function (){
        var v = $(this).val();
        location.href = '{{route('page.block.create',['page'=>Request::segment(3)])}}' + '?name=' + v;
    });
    $('#form').ajaxForm({
        dataType: 'json',
        success: function() {
            $('#form .form-group .help-block').empty();
            $('#form .form-group').removeClass('has-error');
            location.href='{{route("page.block.index",["page"=>Request::segment(3)])}}';
        },
        error: function(xhr){
            try {
                var json = jQuery.parseJSON(xhr.responseText);
                var keys = Object.keys(json);
                $('#form .form-group .help-block').empty();
                $('#form .form-group').removeClass('has-error');
                $('#form .form-group').each(function(){
                    var name = $(this).find('select').attr('name') || $(this).find('input,textarea').attr('name');
                    //console.log(name);
                    if( jQuery.inArray(name, keys) != -1){
                        $(this).addClass('has-error');
                        $(this).find('.help-block').html(json[name]);
                    }
                })
                //return true;
            } catch(e) {
                alert('提交失败，请联系管理员');
                //console.log(e);
                return false;
            }

        }
    });
    @if ($name == 'kv' || $name == 'graphic')
    var file_config_header = {
        theme: 'explorer',
        uploadUrl: '{{url("admin/file/upload/file1")}}',
        uploadAsync: false,
        maxFileCount: 1,
        allowedFileTypes: ["image", "video"],
        overwriteInitial: true,
        initialPreviewAsData: true,
        fileActionSettings: {
            showUpload: false
        }
    };
    $("#header-explorer").fileinput(file_config_header).on('filebatchuploadsuccess', function(event, data) {
        $('input[name="header_image"]').val(data.response.initialPreviewConfig[0].value);
    }).on('filedeleted',function () {
        $('input[name="header_image"]').val('');
    });
    @endif

    @if ($name == 'graphic')
    var file_config_bkg = {
        theme: 'explorer',
        uploadUrl: '{{url("admin/file/upload/file2")}}',
        uploadAsync: false,
        maxFileCount: 1,
        allowedFileTypes: ["image", "video"],
        overwriteInitial: true,
        initialPreviewAsData: true,
        fileActionSettings: {
            showUpload: false
        }
    };


    $("#bkg-explorer").fileinput(file_config_bkg).on('filebatchuploadsuccess', function(event, data) {
        $('input[name="bkg_image"]').val(data.response.initialPreviewConfig[0].value);
    }).on('filedeleted',function () {
        $('input[name="bkg_image"]').val('');
    });
    @endif


    @if ($name == 'gallery')
    var file_config_gallery = {
        theme: 'explorer',
        uploadUrl: '{{url("admin/file/upload/file3")}}',
        uploadAsync: false,
        allowedFileTypes: ["image", "video"],
        overwriteInitial: false,
        initialPreviewAsData: true,
        fileActionSettings: {
            showUpload: false
        }
    };

    $("#gallery-explorer").fileinput(file_config_gallery).on('filebatchuploadsuccess', function(event, data) {
        console.log(data.response);
        $.each(data.response.initialPreviewConfig, function (index, value) {
            $("#div-gallery").append('<input name="gallery[]" value="'+value.value+'" type="hidden" />');
        });
    }).on('filedeleted',function (event, key) {
        var obj = $("#div-gallery").find('input[name="gallery[]"]');
        obj.each(function (index) {
            if(obj.eq(index) && obj.eq(index).val() == key){
                obj.eq(index).remove();
            }
        });
    });
    @endif
});
</script>
@endsection

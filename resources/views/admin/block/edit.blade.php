@extends('layouts.admin')

@section('content')
    <div class="page-content sidebar-page right-sidebar-page clearfix">
        <!-- .page-content-wrapper -->
        <div class="page-content-wrapper">
            <div class="page-content-inner">
                <!-- Start .page-content-inner -->
                <div id="page-header" class="clearfix">
                    <div class="page-header">
                        <h2>区块管理 - {{$page->title}} - 编辑</h2>
                    </div>
                </div>
                <!-- Start .row -->
                <div class="row">
                    <div class="col-lg-12">
                        <!-- col-lg-12 start here -->
                        <div class="panel panel-default">
                            <!-- Start .panel -->
                            <div class="panel-body pt0 pb0">
                                {{ Form::open(array('route' => ['page.block.update', $row->page_id,$row->id], 'class'=>'form-horizontal group-border stripped', 'method'=>'PUT', 'id'=>'form')) }}
                                    <!--<div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">区块种类</label>
                                        <div class="col-lg-10 col-md-9">
                                            <select name="name" class="select2 form-control">
                                                <option value="">请选择区块种类</option>
                                                @foreach ($blocks as $name=>$block)
                                                <option value="{{$name}}" @if ($name == $row->name){{'selected="selected"'}}@endif>{{$block}}</option>
                                                @endforeach
                                            </select>
                                            <label class="help-block" for="name"></label>
                                        </div>
                                    </div>-->
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">标题</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" name="title" class="form-control" value="{{$row->title}}">
                                            <label class="help-block" for="title"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">描述</label>
                                        <div class="col-lg-10 col-md-9">
                                            <textarea name="description" class="form-control" rows="5" placeholder="请输入">{{$row->description}}</textarea>
                                            <label class="help-block" for="description"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    @if ($row->name == 'graphic')
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">内容</label>
                                        <div class="col-lg-10 col-md-9">
                                            <textarea name="content" class="form-control" rows="5" placeholder="请输入">{{$row->content}}</textarea>
                                            <label class="help-block" for="content"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    @endif
                                    @if ($row->name == 'kv' || $row->name == 'graphic')
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-3 control-label" for="">头图</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input id="header-explorer" name="file1" type="file" multiple >
                                            <input name="header_image" value="{{$row->header_image}}" type="hidden" />
                                            <label class="help-block" for="image"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    @endif
                                    @if ($row->name == 'graphic')
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-3 control-label" for="">背景图/大图</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input id="bkg-explorer" name="file2" type="file" multiple >
                                            <input name="bkg_image" value="{{$row->bkg_image}}" type="hidden" />
                                            <label class="help-block" for="image_bkg"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    @endif
                                    @if ($row->name == 'gallery')
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-3 control-label" for="">图库</label>
                                        <div class="col-lg-10 col-md-9" id="div-gallery">
                                            <input id="gallery-explorer" name="file3[]" type="file" multiple >
                                            <label class="help-block" for="gallery[]"></label>
                                            @if($row->gallery && is_array($row->gallery))
                                                @foreach($row->gallery as $image)
                                            <input name="gallery[]" value="{{$image}}" type="hidden" />
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    @endif
                                    @if($row->name == 'video' || $row->name == 'kv')
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">链接</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" name="link" class="form-control" value="{{$row->link}}">
                                            <label class="help-block" for="link"></label>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">排序</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" name="sort_id" class="form-control" value="{{$row->sort_id}}">
                                            <label class="help-block" for="sort_id"></label>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">是否发布</label>
                                        <div class="col-lg-10 col-md-9">
                                            <select name="is_posted" class="form-control">
                                                <option value="1"@if($row->is_posted == '1'){{' selected="selected"'}}@endif>是</option>
                                                <option value="0"@if($row->is_posted == '0'){{' selected="selected"'}}@endif>否</option>
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
    $('#form').ajaxForm({
        dataType: 'json',
        success: function() {
            $('#form .form-group .help-block').empty();
            $('#form .form-group').removeClass('has-error');
            location.href='{{route("page.block.index",["page"=>$row->page_id])}}';
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
    @if ($row->name == 'kv' || $row->name == 'graphic')
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
            @if($row->header_image)
    var obj1 = {
            initialPreview: [
                "{{asset($row->header_image)}}"
            ],
            initialPreviewConfig: [
                {caption: "", size: "{{ filesize($row->header_image) }}", width: "400px", url: "{{url('admin/file/delete')}}", key: 1,extra:{name:'{{$row->header_image}}'}}
            ]
        };
    $.extend( file_config_header, obj1 );
            @endif

    $("#header-explorer").fileinput(file_config_header).on('filebatchuploadsuccess', function(event, data) {
        $('input[name="header_image"]').val(data.response.initialPreviewConfig[0].value);
    }).on('filedeleted',function () {
        $('input[name="header_image"]').val('');
    });
    @endif

    @if ($row->name == 'graphic')
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

    @if($row->bkg_image)
    var obj2 = {
        initialPreview: [
            "{{asset($row->bkg_image)}}"
        ],
        initialPreviewConfig: [
            {caption: "", size: "{{ filesize($row->bkg_image) }}", width: "400px", url: "{{url('admin/file/delete')}}", key: 1,extra:{name:'{{$row->bkg_image}}'}}
        ]
    };
    $.extend( file_config_bkg, obj2 );
    @endif
    $("#bkg-explorer").fileinput(file_config_bkg).on('filebatchuploadsuccess', function(event, data) {
        $('input[name="bkg_image"]').val(data.response.initialPreviewConfig[0].value);
    }).on('filedeleted',function () {
        $('input[name="bkg_image"]').val('');
    });
    @endif


    @if ($row->name == 'gallery')
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
    @if($row->gallery && is_array($row->gallery))
        var preview = [];
        var config = [];
        @foreach($row->gallery as $image)
            preview.push('{{asset($image)}}');
            config.push({caption: "", size: "{{ filesize($image) }}", width: "400px", url: "{{url('admin/file/delete')}}", key: '{{$image}}',extra:{name:'{{$image}}'}});
        @endforeach
    var obj3 = {
        initialPreview: preview,
        initialPreviewConfig: config
    };
    $.extend( file_config_gallery, obj3 );
    @endif
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

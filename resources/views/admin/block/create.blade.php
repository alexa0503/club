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
                        <h2>区块管理 - {{$page->title}} - 新增</h2>
                    </div>
                </div>
                <!-- Start .row -->
                <div class="row">
                    <div class="col-lg-12">
                        <!-- col-lg-12 start here -->
                        <div class="panel panel-default">
                            <!-- Start .panel -->
                            <div class="panel-body pt0 pb0">
                                {{ Form::open(array('route' => ['page.block.store', Request::segment(3)], 'class'=>'form-horizontal group-border stripped', 'id'=>'post-form')) }}
                                <div class="form-group">
                                    <label for="text" class="col-lg-2 col-md-3 control-label">区块种类</label>
                                    <div class="col-lg-10 col-md-9">
                                        <select id="name" name="name" class="select2 form-control">
                                            <option value="">请选择区块种类</option>
                                            @foreach ($blocks as $key=>$block)
                                                <option value="{{$key}}">{{$block}}</option>
                                            @endforeach
                                        </select>
                                        <label class="help-block" for="name" id="help-name"></label>
                                    </div>
                                </div>
                                <!-- End .form-group  -->
                                <div class="form-group">
                                    <label for="text" class="col-lg-2 col-md-3 control-label">标题</label>
                                    <div class="col-lg-10 col-md-9">
                                        <input type="text" id="title" name="title" class="form-control" value="">
                                        <label class="help-block" for="title" id="help-title"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="link" class="col-lg-2 col-md-3 control-label">链接</label>
                                    <div class="col-lg-10 col-md-9">
                                        <input type="text" id="link" name="link" class="form-control" value="">
                                        <label class="help-block" for="link" id="help-link"></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="text" class="col-lg-2 col-md-3 control-label">描述</label>
                                    <div class="col-lg-10 col-md-9">
                                        <textarea id="description" name="description" class="form-control" rows="5" placeholder="请输入"></textarea>
                                        <label class="help-block" for="description" id="help-description"></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="" class="col-lg-2 control-label">图片</label>
                                    <div class="col-lg-10">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                            <a id="c-image" data-input="image" data-preview="preview-image" class="btn btn-primary">
                                            <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                            </span>
                                            <input id="image" class="form-control" type="text" name="image">
                                        </div>
                                        <img id="preview-image" style="margin-top:15px;max-height:100px;">
                                        <label class="help-block" for="" id="help-image"></label>
                                    </div><!-- /.col -->
                                </div><!-- /form-group -->

                                <div class="form-group">
                                    <label for="" class="col-lg-2 control-label">缩略图</label>
                                    <div class="col-lg-10">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                            <a id="c-thumb" data-input="thumb" data-preview="preview-thumb" class="btn btn-primary">
                                            <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                            </span>
                                            <input id="thumb" class="form-control" type="text" name="thumb">
                                        </div>
                                        <img id="preview-thumb" style="margin-top:15px;max-height:100px;">
                                        <label class="help-block" for="" id="help-thumb"></label>
                                    </div><!-- /.col -->
                                </div><!-- /form-group -->

                                <div class="form-group">
                                    <label for="" class="col-lg-2 col-md-3 control-label">排序</label>
                                    <div class="col-lg-10 col-md-9">
                                        <input type="text" id="sort_id" name="sort_id" class="form-control" value="">
                                        <label class="help-block" for="sort_id" id="help-username"></label>
                                    </div>
                                </div>
                                <!-- End .form-group  -->
                                
                                <div class="form-group">
                                    <label for="" class="col-lg-2 col-md-3 control-label">是否发布</label>
                                    <div class="col-lg-10 col-md-9">
                                        <select name="is_posted" class="form-control" id="is_posted">
                                            <option value="1">是</option>
                                            <option value="0" selected="selected">否</option>
                                        </select>
                                        <label class="help-block" for="is_posted" id="help-is_posted"></label>
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
    <!--form-->
    <script src="/vendor/laravel-filemanager/js/lfm.js"></script>
    <script src="{{asset('js/jquery.form.js')}}"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script src="{{asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>
    <script>
        $('#c-image').filemanager('image',{prefix:'{!! url("/filemanager") !!}'});
        $('#c-thumb').filemanager('image',{prefix:'{!! url("/filemanager") !!}'});
        $().ready(function () {
            $('.article-ckeditor').ckeditor({
                filebrowserBrowseUrl: '{!! url("/filemanager?type=Images") !!}'
            });
            $('.select2').select2({
                tags: true,
                language: "zh-CN",
                placeholder: "请输入",
            });


            $('#post-form').ajaxForm({
                dataType: 'json',
                success: function (json) {
                    $('#post-form').modal('hide');
                    location.href = json.url;
                },
                error: function (xhr) {
                    var json = jQuery.parseJSON(xhr.responseText);
                    if (xhr.status == 200) {
                        $('#post-form').modal('hide');
                        location.href = json.url;
                    }
                    $('.help-block').html('');
                    $.each(json, function (index, value) {
                        $('#' + index).parents('.form-group').addClass('has-error');
                        $('#help-' + index).html(value);
                        //$('#'+index).next('.help-block').html(value);
                    });
                }
            });
        })
    </script>
@endsection

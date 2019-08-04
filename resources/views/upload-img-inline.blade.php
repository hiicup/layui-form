@if(!$js)

    <div class="layui-upload-drag {{ $class }}" id="{{ $id }}" style="padding: 5px;">
        <a href="javascript:;" class="layui-btn layui-btn-warm">
            <i class="layui-icon upload-btn-icon">&#xe681;</i> {{ $placeholder }}
        </a>
    </div>
    @if(isset($tips))
        <p class="input-tips"><i class="layui-icon" style="font-size: 16px;color:#ccc;">&#xe60b;</i> {{ $tips }}</p>
    @endif
    <div class="up-loading" id="{{ $id }}-loading" style="display: none">
        正在上传 <i class="layui-icon layui-anim layui-anim-rotate layui-anim-loop">&#x1002;</i>
    </div>
    @if($value)
        <div class="upload-img-wrap" id="{{ $id }}-preview">
            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
            <img src="{{ asset($value) }}" alt="预览">
        </div>
    @else
        <div class="upload-img-wrap" id="{{ $id }}-preview" style="display: none">
            <input type="hidden" name="{{ $name }}" value="">
        </div>
    @endif
    <style>
        .layui-upload-drag .upload-btn-icon{
            font-size:30px;
            color:white;
        }
        .layui-upload-drag{
            text-align: left;
        }
        .upload-img-wrap img{
            height: 100px;
            margin-top: 10px;
        }
    </style>
@else
    <script>

        $(".{{ $class }}").each(function(){
            var self = $(this);
            var id = self.attr('id');
            var imgPreviewWrap = $("#"+id+"-preview");
            var loading = $("#"+id+"-loading");
            //上传
            layui.upload.render({
                elem: "#"+id
                ,url: "{{ config("layui.upload") }}" //上传接口
                ,before:function(obj){
                    loading.show();
                }
                ,done: function(res){
                    loading.hide();
                    if(res.status === 200){
                        imgPreviewWrap.show();
                        var img = res.data;
                        imgPreviewWrap.html("");
                        imgPreviewWrap.append('<input type="hidden" value="'+img.value+'" name="{{ $name }}" ><img src="'+img.src+'">');
                    }else{
                        layer.msg(res.message, {icon: 6});
                    }
                }
            });

        });

    </script>
@endif
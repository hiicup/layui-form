@if($isHtml)
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
        }
        .upload-img-item{
            height: 150px;
            float: left;
            margin: 10px;
        }
        .upload-img-item a{
            line-height: 20px;
            font-size: 14px;
            text-align: center;
            background: orangered;
            color: white;
            font-weight: bold;
            display: block;
        }
    </style>
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
            @foreach($value as $img)
                <div class="upload-img-item">
                    <a href="javascript:;">删除</a>
                    <input type="hidden" value="{{ $img }}" name="{{ $name }}[]">
                    <img src="{{ asset($img) }}">
                </div>
            @endforeach
        </div>
    @else
        <div class="upload-img-wrap" id="{{ $id }}-preview" style="display: none"></div>
    @endif
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
                ,url: "{{ route('admin.upload.image') }}" //上传接口
                ,before:function(obj){
                    loading.show();
                }
                ,done: function(res){
                    loading.hide();
                    if(res.status === 200){
                        imgPreviewWrap.show();
                        var img = res.data;
                        imgPreviewWrap.append('<div class="upload-img-item"><a href="javascript:;">删除</a><input type="hidden" value="'+img.value+'" name="{{ $name }}[]"><img src="'+img.src+'"></div>');
                    }else{
                        _error(res.message)
                    }
                }
            });
            imgPreviewWrap.on("click","a",function(){
                var _this = this;
                if(confirm("此操作不可撤销，确定移除吗？")){
                    $(_this).fadeOut(function(){
                        $(_this).parent().remove();
                    })
                }
            });

        });

    </script>
@endif
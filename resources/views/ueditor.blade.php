@if($js)

    <script>
        window.UEURL = "{{ config("layui.ueditor_server_url") }}";
    </script>

    <!-- 配置文件 -->
    <script type="text/javascript" src="{{ asset('layui-form/ueditor/ueditor.config.js') }}"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="{{ asset('layui-form/ueditor/ueditor.all.js') }}"></script>

    <script>

        $(".ueditor").each(function(){
            var height = $(this).data('height');
            UE.getEditor($(this).attr('id'),{
                initialFrameHeight:height,
                scaleEnabled:true
            });
        });

    </script>
@else
    <div class="layui-form-item layui-form-text">

        @if($inline)
            <div class="layui-input-inline">
                {!! $form->textarea($name,$value,$options) !!}
            </div>
        @else
            {!! $layui->labelTag($label,$required) !!}
            <div class="layui-input-block">
                {!! $form->textarea($name,$value,$options) !!}
            </div>
        @endif

    </div>
@endif
@if($js)
    <script>
        $(".{{ $class }}").each(function(){
            var id = $(this).attr('id');
            layui.laydate.render({
                elem: "#"+id,
                format:"yyyy-MM-dd HH:mm:ss"
            });
        });
    </script>
@else
    <div class="layui-form-item">
        {!! $form->input($type,$name,$value,$options) !!}
    </div>
@endif
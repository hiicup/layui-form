@if($js)
    <script>
        $(".{{ $class }}").each(function(){
            var id = $(this).attr('id');
            layui.laydate.render({
                elem: "#"+id
            });
        });
    </script>
@else
    {!! $form->input($type,$name,$value,$options) !!}
@endif
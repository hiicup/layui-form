<!-- 配置文件 -->
<script type="text/javascript" src="{{ asset('res/ueditor/ueditor.config.js') }}"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="{{ asset('res/ueditor/ueditor.all.js') }}"></script>

<script>

    $(".ueditor").each(function(){
        var height = $(this).data('height');
        UE.getEditor($(this).attr('id'),{
            initialFrameHeight:height,
            scaleEnabled:true
        });
    });

</script>
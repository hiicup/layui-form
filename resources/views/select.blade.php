<div class="layui-form-item">
    {!! $layui->labelTag($label,$required) !!}
    <div class="layui-input-inline" style="{{ $style or "" }}">
        {!! $form->select($name,$list,$selected,$options) !!}
    </div>
</div>
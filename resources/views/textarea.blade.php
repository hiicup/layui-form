<div class="layui-form-item layui-form-text">
    {!! $layui->label($label,$required) !!}
    <div class="layui-input-block">
        {!! $form->textarea($name,$value,$options) !!}
    </div>
</div>
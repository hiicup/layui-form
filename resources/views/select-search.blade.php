<div class="layui-form-item">
    {!! $layui->label($label,$required) !!}
    <div class="layui-input-inline">
        {!! $form->select($name,$list,$selected,$options) !!}
    </div>
</div>
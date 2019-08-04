<div class="layui-form-item">
    {!! $layui->labelTag($label,$required) !!}
    <div class="layui-input-inline {{ $inputSize  }}">
        {!! $form->password($name,$options) !!}
    </div>
</div>
<div class="layui-form-item">
    {!! $layui->label($label,$required) !!}
    <div class="layui-input-inline {{ $inputSize  }}">
        {!! $form->input($type,$name,$value,$options) !!}
    </div>
</div>
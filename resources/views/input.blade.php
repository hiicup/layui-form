<div class="layui-form-item">
    {!! $layui->labelTag($label,$required) !!}
    <div class="layui-input-inline {{ $inputSize  }}">
        {!! $form->input($type,$name,$value,$options) !!}
    </div>
</div>
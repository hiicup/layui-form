@if($inline)
    <input type="hidden" name="{{ $name }}" value="{{ $noValue or 0 }}">
    {!! $form->checkbox($name,$value,$checked,$options) !!}
@else
    <div class="layui-form-item">
        {!! $layui->label($label,$required) !!}
        <div class="layui-input-inline">
            <input type="hidden" name="{{ $name }}" value="{{ $noValue or 0 }}">
            {!! $form->checkbox($name,$value,$checked,$options) !!}
        </div>
    </div>
@endif
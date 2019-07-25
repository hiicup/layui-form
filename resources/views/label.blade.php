@if($required)
    <label class="layui-form-label"><span class="red">*</span> {{ $label }}</label>
@else
    <label class="layui-form-label">{{ $label }}</label>
@endif
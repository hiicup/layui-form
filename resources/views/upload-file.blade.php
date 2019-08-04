<div class="layui-form-item">
    <label class="layui-form-label">{{ $title }}</label>
    <div class="layui-input-block">
        <div class="">
            {!! $layui->uploadFileInline($name,$tips,$placeholder) !!}
        </div>
    </div>
</div>
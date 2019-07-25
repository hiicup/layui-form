<div class="layui-form-item">
    <label class="layui-form-label">{{ $title }}</label>
    <div class="layui-input-block">
        <div class="">
            {!! $layui->uploadSingleAttachment($name,$model,$tips,$placeholder) !!}
        </div>
    </div>
</div>
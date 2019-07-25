<div class="layui-form-item">
    <div class="{{ $floatLeft?'':'layui-input-block' }}">
        @if($formId)
            <button type="button" class="layui-btn" onclick="$('#{{ $formId }}').submit()" lay-filter="demo1">立即提交</button>
        @else
            <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
        @endif

        @if($backUrl)
            <a href="{{ $backUrl }}" class="layui-btn layui-btn-primary">取消</a>
        @endif
    </div>
</div>
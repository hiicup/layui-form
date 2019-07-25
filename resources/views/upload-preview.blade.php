<input type="hidden" name="{{ $name }}" value="{{ $value }}">
@if(ends_with($attach_name,'.mp3'))
    <audio controls="controls">
        <source src="{{ route('admin.upload.audio',$value) }}" type="audio/mpeg">
        您的浏览器暂不支持播放音频文件
    </audio>
@else
    <i class="layui-icon" style="font-size: 30px; color: mediumseagreen;">&#xe621;</i>
    @if(isset($attach_url))
        <a target="_blank" href="{{ $attach_url }}">{{ $attach_name}}</a>
    @else
        <a target="_blank" href="javascript:;">{{ $attach_name}}</a>
    @endif
@endif
<?php


namespace Hiicup\Layui\Html;


use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;

class LayuiHtmlBuilder {

    public function css() {
        return '<link rel="stylesheet" href="' . asset('layui-form/layui/css/layui.css') . '">' .
            '<link rel="stylesheet" href="' . asset('layui-form/layui-form.css') . '">';
    }

    public function js() {
        return '<script src="' . asset('layui-form/layui/layui.all.js') . '"></script>';
    }

    /**
     * @param string $backUrl
     * @param string $formId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function submit($backUrl = '', $formId = '') {
        return view('layui::submit', [
            'backUrl'   => $backUrl,
            'formId'    => $formId,
            'floatLeft' => false,
        ]);
    }

    /**
     * @param string $backUrl
     * @param string $formId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function submitLeft($backUrl = '', $formId = '') {
        return view('layui::submit', [
            'backUrl'   => $backUrl,
            'formId'    => $formId,
            'floatLeft' => true,
        ]);
    }

    public function selectSearchText($name, $list, $label = '', $selected = null, $required = false, $tips = '直接选择或搜索选择') {
        $options = [
            'lay-search' => '',
        ];

        if ($required) {
            $options['lay-verify'] = "required";
        }

        $newList = [];

        foreach ($list as $item) {
            $newList[$item] = $item;
        }
        $list = collect($newList);
        $list = $list->prepend('', $tips);

        return view('layui::select-search')->with([
            'list'     => $list,
            'name'     => $name,
            'options'  => $options,
            'selected' => $selected,
            'label'    => $label,
            'required' => $required,
        ]);
    }

    public function selectSearch($name, Collection $list, $label = '', $selected = null, $required = false, $tips = '直接选择或搜索选择') {
        $options = [
            'lay-search' => '',
        ];

        if ($required) {
            $options['lay-verify'] = "required";
        }

        $list = $list->prepend('', $tips);

        return view('layui::select-search')->with([
            'list'     => $list,
            'name'     => $name,
            'options'  => $options,
            'selected' => $selected,
            'label'    => $label,
            'required' => $required,
        ]);
    }


    public function label($label, $required = false) {

        return view('layui::label', [
            'label'    => $label,
            'required' => $required,
        ]);
    }

    public function uploadFile($title, $name, $model = null, $tips = null, $placeholder = '点击上传，或将文件拖拽到此处') {
        return view('layui::upload-file', [
            'title'       => $title,
            'name'        => $name,
            'model'       => $model,
            'tips'        => $tips,
            'placeholder' => $placeholder,
        ]);
    }

    /**
     * @param        $name
     * @param null   $model
     * @param null   $tips
     * @param string $placeholder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function uploadSingleAttachment($name, $model = null, $tips = null, $placeholder = '点击上传，或将文件拖拽到此处') {

        $value = old($name);
        $attach_name = '';
        $attach_url = '';
        $attach_type = '';
        if ($model) {
            $value = old($name, $model->$name);
            $method = str_replace("_id", "", $name);
            if (method_exists($model, $method)) {
                if ($attach = $model->$method) {
                    $attach_name = $attach->name;
                    $attach_type = $attach->type;
                    $attach_url = route('admin.attachment.download', ['guid' => $attach->guid]);
                }
            }
        }

        $render = [
            'class'       => 'upload-single-attachment',
            'isHtml'      => true,
            'name'        => $name,
            'id'          => uniqid(),
            'value'       => $value,
            'tips'        => $tips,
            'placeholder' => $placeholder,
            'attach_name' => $attach_name,
            'attach_url'  => $attach_url,
            'attach_type' => $attach_type,
        ];

        return view('layui::upload-single-attachment')->with($render);
    }

    public function uploadSingleAttachmentDepends($name, $model = null) {

        $value = old($name);
        if ($model) {
            $value = old($name, $model->$name);
        }

        $render = [
            'class'  => 'upload-single-attachment',
            'isHtml' => false,
            'name'   => $name,
            'id'     => uniqid(),
            'value'  => $value,
        ];

        return view('layui::upload-single-attachment')->with($render);
    }


    public function uploadImg($title, $name, $model = null, $tips = null, $placeholder = '点击上传，或将文件拖拽到此处') {
        return view('layui::upload-img', [
            'title'       => $title,
            'name'        => $name,
            'model'       => $model,
            'tips'        => $tips,
            'placeholder' => $placeholder,
        ]);
    }

    public function uploadImgs($name, $model = null, $tips = null, $placeholder = '点击上传，或将文件拖拽到此处') {

        $value = old($name);
        if ($model) {
            $value = old($name, $model->$name);

            if ($value) {
                $value = explode(",", $value);
            }
        }

        $render = [
            'class'       => 'upload-mutil-img',
            'isHtml'      => true,
            'name'        => $name,
            'id'          => uniqid(),
            'value'       => $value,
            'tips'        => $tips,
            'placeholder' => $placeholder,
        ];

        return view('layui::upload-imgs')->with($render);
    }

    public function uploadImgsDepends($name, $model = null) {

        $value = old($name);
        if ($model) {
            $value = old($name, $model->$name);
        }

        $render = [
            'class'  => 'upload-mutil-img',
            'isHtml' => false,
            'name'   => $name,
            'id'     => uniqid(),
            'value'  => $value,
        ];

        return view('layui::upload-imgs')->with($render);
    }

    public function uploadOneImg($name, $model = null, $tips = null, $placeholder = '点击上传，或将文件拖拽到此处') {

        $value = old($name);
        if ($model) {
            $value = old($name, $model->$name);
        }

        $render = [
            'class'       => 'upload-single-img',
            'js'          => false,
            'name'        => $name,
            'id'          => uniqid(),
            'value'       => $value,
            'tips'        => $tips,
            'placeholder' => $placeholder,
        ];

        return view('layui::upload-single-img')->with($render);
    }

    public function uploadOneImgJS($name, $model = null) {

        $value = old($name);
        if ($model) {
            $value = old($name, $model->$name);
        }

        $render = [
            'class' => 'upload-single-img',
            'js'    => true,
            'name'  => $name,
            'id'    => uniqid(),
            'value' => $value,
        ];

        return view('layui::upload-single-img')->with($render);
    }

    public function textarea($name, $label, $model = null, $required = false, $size = [600, 120], $placeholder = null) {
        $value = old($name);
        if ($model) {
            $value = old($name, $model->$name);
        }

        if (!$placeholder) {
            $placeholder = "请输入" . $label;
        }

        $width = $size[0];
        $height = $size[1];

        $options = [
            'class'       => 'layui-textarea',
            'placeholder' => $placeholder,
            'style'       => "height: {$height}px;width:{$width}px",
            'rows'        => '',
        ];

        if ($required) {
            $options['lay-verify'] = 'required|content';
        } else {
            $options['lay-verify'] = 'content';
        }

        return view('layui::textarea', [
            'name'     => $name,
            'required' => $required,
            'label'    => $label,
            'value'    => $value,
            'options'  => $options,
        ]);
    }

    public function ueditorJS() {
        return view('layui::ueditor', [
            "js" => true,
        ]);
    }

    public function ueditor($name, $label, $model = null, $required = false, $height = 350) {
        $value = old($name);
        if ($model) {
            $value = old($name, $model->$name);
        }

        $placeholder = "请输入" . $label;

        $options = [
            'class'       => 'ueditor',
            'placeholder' => $placeholder,
            'style'       => "height: {$height}px;width:99%",
            'id'          => uniqid(),
            'data-height' => $height,
        ];

        if ($required) {
            $options['lay-verify'] = 'required|content';
        } else {
            $options['lay-verify'] = 'content';
        }

        return view('layui::ueditor', [
            "js"       => false,
            'name'     => $name,
            'required' => $required,
            'label'    => $label,
            'value'    => $value,
            'options'  => $options,
        ]);
    }

    public function yesOrNoCheckbox($name, $title, $value, $model = null, $options = []) {
        $no = 0;
        $yes = 1;
        if (is_array($value)) {
            if (isset($value['yes'])) {
                $yes = $value['yes'];
            }

            if (isset($value['no'])) {
                $no = $value['no'];
            }
        } else {
            $yes = $value;
        }


        return $this->checkbox($name, $yes, $title, $model, false, $options, $no);
    }

    public function img($img) {

        if (!$img) {
            return '';
        }
        $img = asset($img);
        return <<<EOL
<i class="layui-icon tips" data-title="<img width='100' height='100' src='{$img}' />" style="color:mediumseagreen">&#xe64a;</i>
EOL;
    }

    public function checkboxInline($name, $value, $title, $model = null, $required = false, $options = [], $noValue = 0) {

        $options = $this->mergeAttributes($options, [
            'lay-skin' => 'primary',
            'title'    => $title,
        ]);

        $checkedValue = old($name);
        if ($model) {
            $checkedValue = old($name, $model->$name);
        }

        $checked = false;
        if ($checkedValue == $value) {
            $checked = true;
        }

        return view('layui::input-checkbox', [
            'name'     => $name,
            'required' => $required,
            'label'    => '',
            'checked'  => $checked,
            'value'    => $value,
            'noValue'  => $noValue,
            'options'  => $options,
            'inline'   => true,
        ]);
    }

    public function checkbox($name, $value, $title, $model = null, $required = false, $options = [], $noValue = 0) {

        $options = $this->mergeAttributes($options, [
            'lay-skin' => 'primary',
            'title'    => $title,
        ]);

        $checkedValue = old($name);
        if ($model) {
//            dump($name,$model->$name);
            $checkedValue = old($name, $model->$name);
        }

        $checked = false;
        if ($checkedValue == $value) {
            $checked = true;
        }

        return view('layui::input-checkbox', [
            'name'     => $name,
            'required' => $required,
            'label'    => '',
            'checked'  => $checked,
            'value'    => $value,
            'noValue'  => $noValue,
            'options'  => $options,
            'inline'   => false,
        ]);
    }

    public function password($name, $label, $required = false, $inputSize = 'input-xxx') {

        $placeholder = "请输入" . $label;

        $options = [
            'class'       => 'layui-input',
            'placeholder' => $placeholder,
        ];

        if ($required) {
            $options['lay-verify'] = 'required';
        }

        return view('layui::input-password', [
            'name'      => $name,
            'required'  => $required,
            'label'     => $label,
            'options'   => $options,
            'inputSize' => $inputSize,
        ]);
    }

    public function miniBtnAdd($url, $label, $options = []) {

        $options = $this->mergeAttributes($options, [
            'class' => 'layui-btn-mini mr-btn-success',
        ]);

        return $this->btnAdd($url, $label, $options);
    }

    public function btnAdd($url, $label, $options = []) {

        $options = $this->mergeAttributes($options, [
            'class' => 'layui-btn',
        ]);

        $content = $this->iconAdd() . $label;

        return app('html')->link($url, $content, $options, null, false);
    }

    public function readonly($name, $label, $model = null, $required = false, $inputSize = 'input-xx') {

        $value = old($name);
        if ($model) {
            $value = old($name, $model->$name);
        }

        $placeholder = "请输入" . $label;

        $options = [
            'class'       => 'layui-input',
            'placeholder' => $placeholder,
            'disabled',
            'style'       => 'background:#eee;',
        ];

        if ($required) {
            $options['lay-verify'] = 'required';
        }

        return view('layui::input', [
            'name'      => $name,
            'required'  => $required,
            'label'     => $label,
            'value'     => $value,
            'options'   => $options,
            'inputSize' => $inputSize,
        ]);
    }

    public function inputNumber($name, $label, $model = null, $required = false, $inputSize = 'input-xxx') {
        return $this->input($name, $label, $model, $required, $inputSize, 'number');
    }

    public function input($name, $label, $model = null, $required = false, $inputSize = 'input-xxx', $type = 'text') {
        $value = old($name);
        if ($model) {
            $value = old($name, $model->$name);
        }

        $labelArray = explode("|", $label);
        $label = $labelArray[0];
        if (count($labelArray) == 2) {
            $placeholder = $labelArray[1];
        } else {
            $placeholder = "请输入" . $label;
        }

        $options = [
            'class'       => 'layui-input',
            'placeholder' => $placeholder,
        ];

        if ($required) {
            $options['lay-verify'] = 'required';
        }

        return view('layui::input', [
            'type'      => $type,
            'name'      => $name,
            'required'  => $required,
            'label'     => $label,
            'value'     => $value,
            'options'   => $options,
            'inputSize' => $inputSize,
        ]);
    }

    public function dialogInfo($url, $title, $label = '更多', $w = 500, $h = 400) {
        return <<<HTML
<a href="javascript:;" class="blue fn-info" data-url="{$url}" data-title="{$title}" data-w="{$w}" data-h="{$h}">{$label}</a>
HTML;
    }

    public function fieldsetBegin($title) {
        return <<<EOL
<fieldset class="layui-elem-field"><legend class="f14" style="color: #222; font-weight:bold;">{$title}</legend><div class="layui-field-box">
EOL;
    }

    public function fieldsetEnd() {
        return <<<EOL
</div></fieldset>
EOL;
    }

    public function iconfont($font, $boolean = true, $color = '') {

        if (!$boolean) {
            return '';
        }

        $opt = [
            'class' => 'iconfont',
        ];

        if ($color) {
            $opt['style'] = "color:{$color}";
        }

        return app('html')->tag('i', $font, $opt);
    }

    public function icon($font, $attributes = []) {
        $attributes = $this->mergeAttributes($attributes, [
            'class' => 'layui-icon',
        ]);
        return app('html')->tag('i', $font, $attributes);
    }

    public function iconBack() {
        return $this->icon('&#xe65c;');
    }

    public function iconAdd() {
        return $this->icon('&#xe654;');
    }

    public function sbigInput($name, $label, $model = null, $required = false) {
        return $this->input($name, $label, $model, $required, 'input-big');
    }

    public function bigInput($name, $label, $model = null, $required = false) {
        return $this->input($name, $label, $model, $required, 'input-xxxx');
    }

    public function miniInput($name, $label, $model = null, $required = false) {
        return $this->input($name, $label, $model, $required, '');
    }

    public function miniNumberInput($name, $label, $model = null, $required = false) {
        return $this->inputNumber($name, $label, $model, $required, '');
    }

    public function sInput($name, $label, $model = null, $required = false) {
        return $this->input($name, $label, $model, $required, 'input-s');
    }

    public function ssInput($name, $label, $model = null, $required = false) {
        return $this->input($name, $label, $model, $required, 'input-ss');
    }

    public function sssInput($name, $label, $model = null, $required = false) {
        return $this->input($name, $label, $model, $required, 'input-sss');
    }

    public function smallInput($name, $label, $model = null, $required = false) {
        return $this->input($name, $label, $model, $required, 'input-xx');
    }

    public function bigPassword($name, $label, $required = false) {
        return $this->password($name, $label, $required, 'input-xxxx');
    }

    public function miniPassword($name, $label, $required = false) {
        return $this->password($name, $label, $required, '');
    }

    public function smallPassword($name, $label, $required = false) {
        return $this->password($name, $label, $required, 'input-xx');
    }


    private function mergeAttributes($new, $default) {

        $attributes = array_merge($default, $new);
        if (isset($new['class'], $default['class'])) {
            $class = $default['class'] . ' ' . $new['class'];
            $attributes['class'] = $class;
        }

        return $attributes;
    }

}
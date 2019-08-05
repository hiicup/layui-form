<?php


namespace Hiicup\Layui\Html;


use Illuminate\Database\Eloquent\Model;

class LayuiHtmlBuilder {

    private $jsSet = [];
    /**
     * @var \Illuminate\Database\Eloquent\Model 数据
     */
    private $model = null;
    private $label;
    private $name;

    public function css() {
        return '<link rel="stylesheet" href="' . asset('layui-form/layui/css/layui.css') . '">' .
            '<link rel="stylesheet" href="' . asset('layui-form/layui-form.css') . '">';
    }

    public function js() {
        $script = '<script src="' . asset('layui-form/layui/layui.all.js') . '"></script>' . PHP_EOL;
        foreach ($this->jsSet as $js) {
            $script .= $js;
        }

        return $script;
    }

    /**
     * @param null $model
     * @return null
     */
    public function model($model = null) {
        $this->model = $model;
        return null;
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

    public function selectXXL($name, $list, $label = '', $selected = null, $required = false) {
        return $this->select($name, $list, $label, $selected, $required, 280);
    }

    public function selectXL($name, $list, $label = '', $selected = null, $required = false) {
        return $this->select($name, $list, $label, $selected, $required, 220);
    }

    public function select($name, $list, $label = '', $selected = null, $required = false, $width = 190) {
        $options = [];

        if ($required) {
            $options['lay-verify'] = "required";
        }

        $style = "width:{$width}px;";

        if ($this->model && is_null($selected)) {
            $selected = $this->model->$name;
        }

        if (is_string($list)) {
            // 如果是逗号分割的字符串
            $list = explode(",", $list);
            $list = array_filter($list, function ($it) {
                return !!$it;
            });
            foreach ($list as $item) {
                $newList[$item] = $item;
            }
        }

        if (!is_object($list)) {
            $list = collect($list);
        }

        $list->prepend('', "");

        return view('layui::select')->with([
            'list'     => $list,
            'name'     => $name,
            'options'  => $options,
            'selected' => $selected,
            'label'    => $label,
            'required' => $required,
            'style'    => $style,
        ]);
    }

    public function labelTag($label, $required = false) {

        return view('layui::label', [
            'label'    => $label,
            'required' => $required,
        ]);
    }

    public function uploadFile($title, $name, $tips = null, $placeholder = '点击上传，或将文件拖拽到此处') {
        $model = $this->model;
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
     * @param null   $tips
     * @param string $placeholder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function uploadFileInline($name, $tips = null, $placeholder = '点击上传，或将文件拖拽到此处') {
        $model = $this->model;
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

    public function uploadSingleAttachmentDepends($name) {

        $model = $this->model;
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

    public function uploadImgs($name, $tips = null, $placeholder = '点击上传，或将文件拖拽到此处') {
        $model = $this->model;
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

    public function uploadImgsDepends($name) {
        $model = $this->model;
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

    public function uploadImg($name, $title, $tips = null, $placeholder = '点击上传，或将文件拖拽到此处') {
        $model = $this->model;
        $this->uploadImgJS($name);
        return view('layui::upload-img', [
            'title'       => $title,
            'name'        => $name,
            'model'       => $model,
            'tips'        => $tips,
            'placeholder' => $placeholder,
        ]);
    }

    public function uploadImgInline($name, $tips = null, $placeholder = '点击上传，或将文件拖拽到此处') {
        $model = $this->model;
        $value = old($name);
        if ($model) {
            $value = old($name, $model->$name);
        }

        $render = [
            'class'       => 'upload-img-inline',
            'js'          => false,
            'name'        => $name,
            'id'          => uniqid(),
            'value'       => $value,
            'tips'        => $tips,
            'placeholder' => $placeholder,
        ];

        $this->uploadImgJS($name);

        return view('layui::upload-img-inline')->with($render);
    }

    private function uploadImgJS($name) {

        $model = $this->model;
        $value = old($name);
        if ($model) {
            $value = old($name, $model->$name);
        }

        $render = [
            'class' => 'upload-img-inline',
            'js'    => true,
            'name'  => $name,
            'id'    => uniqid(),
            'value' => $value,
        ];

        $this->registerJS(__METHOD__, view('layui::upload-img-inline')->with($render));
    }

    public function textarea($name, $label, $required = false, $size = [600, 120], $placeholder = null) {
        $model = $this->model;
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

    private function datetimeJS() {
        $render = [
            'class' => 'fn-datetime',
            'js'    => true,
        ];

        $this->registerJS(__METHOD__, view('layui::datetime')->with($render));
    }

    public function datetimeInline($name, $required = false) {
        $model = $this->model;
        $value = old($name);
        if ($model) {
            $value = old($name, $model->$name);
        }
        $options = [
            'class' => 'fn-datetime layui-input',
            'id'    => "xx",
            "readonly" => 'readonly'
        ];
        $this->datetimeJS();
        return view('layui::datetime-inline', [
            "js"       => false,
            'type'     => "text",
            'name'     => $name,
            'required' => $required,
            'value'    => $value,
            'options'  => $options,
        ]);
    }

    public function datetime($name, $label, $required = false) {
        $model = $this->model;
        $value = old($name);
        if ($model) {
            $value = old($name, $model->$name);
        }
        $options = [
            'class' => 'fn-datetime layui-input',
            'id'    => "xx",
            "readonly" => 'readonly'
        ];
        $this->datetimeJS();
        return view('layui::datetime', [
            "js"       => false,
            'type'     => "text",
            'name'     => $name,
            'required' => $required,
            'label'    => $label,
            'value'    => $value,
            'options'  => $options,
        ]);
    }

    public function ueditorInline($name, $label, $required = false, $height = 350) {
        return $this->ueditor($name, $label, $required, $height, true);
    }

    public function ueditor($name, $label, $required = false, $height = 350, $inline = false) {
        $model = $this->model;
        $value = old($name);
        if ($model) {
            $value = old($name, $model->$name);
        }

        $placeholder = "请输入" . $label;
        $width = "99%";
        if ($inline) {
            $width = "100%";
        }

        $options = [
            'class'       => 'ueditor',
            'placeholder' => $placeholder,
            'style'       => "height: {$height}px;width:" . $width,
            'id'          => uniqid(),
            'data-height' => $height,
        ];

        if ($required) {
            $options['lay-verify'] = 'required|content';
        } else {
            $options['lay-verify'] = 'content';
        }

        $this->registerJS(__METHOD__, view('layui::ueditor', [
            "js" => true,
        ]));

        return view('layui::ueditor', [
            "js"       => false,
            'name'     => $name,
            'required' => $required,
            'label'    => $label,
            'value'    => $value,
            'options'  => $options,
            'inline'   => $inline,
        ]);
    }

    public function yesOrNoCheckbox($name, $title, $value, $options = []) {
        $model = $this->model;
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


        return $this->checkbox($name, $yes, $title, false, $options, $no);
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

    public function checkboxInline($name, $value, $title, $required = false, $options = [], $noValue = 0) {
        $model = $this->model;
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

    public function checkbox($name, $value, $title, $required = false, $options = [], $noValue = 0) {
        $model = $this->model;
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

    public function readonly($name, $label, $required = false, $inputSize = 'input-xx') {
        $model = $this->model;
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

    public function inputNumber($name, $label, $required = false, $inputSize = 'input-xxx') {
        return $this->input($name, $label, $required, $inputSize, 'number');
    }

    public function inputInline($name, $placeholder, $type = 'text') {
        $model = $this->model;
        if (!$name) {
            $name = $this->name;
        }

        $value = old($name);
        if ($model) {
            $value = old($name, $model->$name);
        }

        $options = [
            'class'       => 'layui-input',
            'placeholder' => $placeholder,
        ];

        return view('layui::input-inline', [
            'type'    => $type,
            'name'    => $name,
            'value'   => $value,
            'options' => $options,
        ]);
    }

    public function input($name, $label, $required = false, $inputSize = 'input-xxx', $type = 'text') {
        $model = $this->model;
        if (!$name) {
            $name = $this->name;
        }

        if (!$label) {
            $label = $this->label;
        }

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
<fieldset class="layui-elem-field"><legend style="color: #222;font-size: 12px;">{$title}</legend><div class="layui-field-box">
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

    public function sbigInput($name, $label, $required = false) {
        return $this->input($name, $label, $required, 'input-big');
    }

    public function bigInput($name, $label, $required = false) {
        return $this->input($name, $label, $required, 'input-xxxx');
    }

    public function miniInput($name, $label, $required = false) {
        return $this->input($name, $label, $required, '');
    }

    public function miniNumberInput($name, $label, $required = false) {
        return $this->inputNumber($name, $label, $required, '');
    }

    public function sInput($name, $label, $required = false) {
        return $this->input($name, $label, $required, 'input-s');
    }

    public function ssInput($name, $label, $required = false) {
        return $this->input($name, $label, $required, 'input-ss');
    }

    public function sssInput($name, $label, $required = false) {
        return $this->input($name, $label, $required, 'input-sss');
    }

    public function smallInput($name, $label, $required = false) {
        return $this->input($name, $label, $required, 'input-xx');
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

    private function registerJS($method, $js) {
        $this->jsSet[md5(__CLASS__ . $method)] = $js;
    }

}
<?php

namespace FTS;


class FormViewHelper
{
    private static $_instance = null;
    private $_elements = array();
    private $_assembledElements = array();
    private $_currentElementId = 0;
    private $_isInForm = false;

    private function  __construct()
    {

    }

    public static function init()
    {
        if (self::$_instance == null) {
            self::$_instance = new FormViewHelper();
        }

        return self::$_instance;
    }

    public function initTextBox()
    {
        $this->_elements[$this->_currentElementId]['opening tag'] = '<input type="text"';
        $this->_elements[$this->_currentElementId]['closing tag'] = '>';

        return $this;
    }

    public function initForm($action, $method = 'post')
    {
        if ($this->_currentElementId != 0) {
            throw new \Exception('Cannot start form as not first element!', 500);
        }

        $this->_elements['form']['action'] = $action;
        $this->_elements['form']['method'] = $method;
        $this->_isInForm = true;
        return $this;
    }

    public function initPasswordBox()
    {
        $this->_elements[$this->_currentElementId]['opening tag'] = '<input type="password"';
        $this->_elements[$this->_currentElementId]['closing tag'] = '>';

        return $this;
    }

    public function initTextArea()
    {
        $this->_elements[$this->_currentElementId]['opening tag'] = '<textarea';
        $this->_elements[$this->_currentElementId]['closing tag'] = '></textarea>';

        return $this;
    }

    public function initUploadFile()
    {
        $this->_elements[$this->_currentElementId]['opening tag'] = '<input type="file"';
        $this->_elements[$this->_currentElementId]['closing tag'] = '>';

        return $this;
    }

    public function initRadioBox()
    {
        $this->_elements[$this->_currentElementId]['opening tag'] = '<input type="radio"';
        $this->_elements[$this->_currentElementId]['closing tag'] = '>';

        return $this;
    }

    public function initSubmit()
    {
        $this->_elements[$this->_currentElementId]['opening tag'] = '<input type="submit"';
        $this->_elements[$this->_currentElementId]['closing tag'] = '>';

        return $this;
    }

    public function initLabel()
    {
        $this->_elements[$this->_currentElementId]['opening tag'] = '<label';
        $this->_elements[$this->_currentElementId]['closing tag'] = '</label>';

        return $this;
    }

    public function initCheckBox()
    {
        $this->_elements[$this->_currentElementId]['opening tag'] = '<input type="checkbox"';
        $this->_elements[$this->_currentElementId]['closing tag'] = '>';

        return $this;
    }

    public function initBoostrapDropDown($value)
    {
        $this->_elements[$this->_currentElementId]['opening tag'] = '<div class="dropdown">
<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">' . $value .
            '<span class="caret"></span></button><ul class="dropdown-menu">';
        $this->_elements[$this->_currentElementId]['closing tag'] = ' </ul></div>';

        return $this;
    }

    public function setDropDownLi($href, $value)
    {
        $this->_elements[$this->_currentElementId]['attributes'][] = '<li><a href="' . $href . '">' . $value . '</a></li>';

        return $this;
    }

    public function setName($name)
    {
        $this->_elements[$this->_currentElementId]['name'] = 'name="' . $name . '"';

        return $this;
    }

    public function setValue($value)
    {
        $this->_elements[$this->_currentElementId]['value'] = '>' . $value;

        return $this;
    }

    public function setAttribute($attribute, $value)
    {
        $this->_elements[$this->_currentElementId]['attributes'][] = $attribute . '="' . $value . '"';

        return $this;
    }

    public function setChecked()
    {
        $this->_elements[$this->_currentElementId]['checked'] = 'checked';

        return $this;
    }

    public function create()
    {
        $element = $this->_elements[$this->_currentElementId];
        $html = $element['opening tag'];
        if ($element['name']) {
            $html .= ' ' . $element['name'];
        }

        if ($element['attributes']) {
            foreach ($element['attributes'] as $attribute) {
                $html .= ' ' . $attribute;
            }
        }

        if ($element['checked']) {
            $html .= ' ' . $element['checked'];
        }

        if ($element['value']) {
            $html .= ' ' . $element['value'];
        }

        $html .= $element['closing tag'];

        $this->_assembledElements[$this->_currentElementId] = $html;
        unset($this->_elements[$this->_currentElementId]);
        $this->_currentElementId++;

        return $this;
    }

    public function render()
    {
        if ($this->_isInForm) {
            $action = $this->_elements['form']['action'];
            $method = $this->_elements['form']['method'];
            echo '<form action="' . $action . '" method="' . $method . '">';
        }

        foreach ($this->_assembledElements as $element) {
            echo $element;
        }

        if ($this->_isInForm) {
            Token::init()->render();
            echo '</form>';
        }

        $this->_elements = array();
        $this->_currentElementId = 0;
        $this->_isInForm = false;
        $this->_assembledElements = array();
    }
}
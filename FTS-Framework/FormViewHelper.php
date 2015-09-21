<?php

namespace FTS;


class FormViewHelper
{
    private static $_instance = null;
    private $elements = array();
    private $assembledElements = array();
    private $currentElement = null;
    private $isInForm = false;

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
        $this->currentElement = 'textBox';
        $this->elements[$this->currentElement]['opening tag'] = '<input type="text"';
        $this->elements[$this->currentElement]['closing tag'] = '>';

        return $this;
    }

    public function initForm($action, $method = 'post')
    {
        if ($this->currentElement != null) {
            throw new \Exception('Cannot start form as not first element!', 500);
        }

        $this->elements['form']['action'] = $action;
        $this->elements['form']['method'] = $method;
        $this->isInForm = true;
        return $this;
    }

    public function initSubmit(){
        $this->currentElement = 'submit';
        $this->elements[$this->currentElement]['opening tag'] = '<input type="submit"';
        $this->elements[$this->currentElement]['closing tag'] = '>';

        return $this;
    }

    public function setName($name)
    {
        $this->elements[$this->currentElement]['name'] = 'name="' . $name . '"';

        return $this;
    }

    public function setValue($value)
    {
        $this->elements[$this->currentElement]['value'] = 'value="' . $value . '"';

        return $this;
    }

    public function setAttribute($attribute, $value)
    {
        $this->elements[$this->currentElement]['attributes'][] = $attribute . '="' . $value . '"';

        return $this;
    }


    public function create()
    {
        $element = $this->elements[$this->currentElement];
        $html = $element['opening tag'];
        if ($element['name']) {
            $html .= ' ' . $element['name'];
        }

        if ($element['value']) {
            $html .= ' ' . $element['value'];
        }

        if ($element['attributes']) {
            foreach ($element['attributes'] as $attribute) {
                $html .= ' ' . $attribute;
            }
        }

        $html .= $element['closing tag'];
        $this->assembledElements[$this->currentElement] = $html;
        unset($this->elements[$this->currentElement]);
        $this->currentElement = null;

        return $this;
    }

    public function render()
    {
        if ($this->isInForm) {
            $action = $this->elements['form']['action'];
            $method = $this->elements['form']['method'];
            echo '<form action="' . $action . '" method="' . $method . '">';
        }
        foreach ($this->assembledElements as $element) {
            echo $element;
        }
        if ($this->isInForm) {
            Token::init()->render();
            echo '</form>';
        }

        $this->elements = array();
        $this->currentElement = null;
    }
}
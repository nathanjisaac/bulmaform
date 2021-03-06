<?php

namespace Isaac\BulmaForm;

use AdamWathan\Form\FormBuilder;
use Isaac\BulmaForm\Elements\CheckGroup;
use Isaac\BulmaForm\Elements\Control;
use Isaac\BulmaForm\Elements\FormGroup;
use Isaac\BulmaForm\Elements\GroupWrapper;
use Isaac\BulmaForm\Elements\Select;

class BasicFormBuilder
{
    protected $builder;

    public function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
    }

    protected function formGroup($label, $name, $control)
    {
        $label = $this->builder->label($label)->addClass('label')->forId($name);
        $control->id($name);

        $formGroup = new Control($label, $control);

        if ($this->builder->hasError($name)) {
            $formGroup->helpBlock($this->builder->getError($name));
            $formGroup->addClass('is-danger');
        }

        return $this->wrap($formGroup);
    }

    protected function selectFormGroup($label, $name, $control)
    {
        $label = $this->builder->label($label)->addClass('label')->forId($name);
        $control->id($name);

        $formGroup = new Select($label, $control);

        if ($this->builder->hasError($name)) {
            $formGroup->helpBlock($this->builder->getError($name));
            $formGroup->addClass('is-danger');
        }

        return $this->wrap($formGroup);
    }

    protected function wrap($group)
    {
        return new GroupWrapper($group);
    }

    public function text($label, $name, $value = null)
    {
        $control = $this->builder->text($name)->value($value)->addClass('input');
        return $this->formGroup($label, $name, $control);
    }

    public function password($label, $name)
    {
        $control = $this->builder->password($name)->addClass('input');
        return $this->formGroup($label, $name, $control);
    }

    public function button($value, $name = null, $type = "")
    {
        return $this->builder->button($value, $name)->addClass('button')->addClass($type);
    }

    public function submit($value = "Submit", $type = "")
    {
        return $this->builder->submit($value)->addClass('button')->addClass($type);
    }

    public function select($label, $name, $options = [])
    {
        $control = $this->builder->select($name, $options);
        return $this->selectFormGroup($label, $name, $control);
    }

    public function checkbox($label, $name)
    {
        $control = $this->builder->checkbox($name);
        return $this->checkGroup($label, $name, $control);
    }

    public function inlineCheckbox($label, $name)
    {
        return $this->checkbox($label, $name)->inline();
    }

    protected function checkGroup($label, $name, $control)
    {
        $checkGroup = $this->buildCheckGroup($label, $name, $control);
        return $this->wrap($checkGroup->addClass('control'));
    }

    protected function buildCheckGroup($label, $name, $control)
    {
        $label = $this->builder->label($label, $name)->after($control)->addClass('checkbox');

        $checkGroup = new CheckGroup($label);

        if ($this->builder->hasError($name)) {
            $checkGroup->helpBlock($this->builder->getError($name));
            $checkGroup->addClass('is-danger');
        }

        return $checkGroup;
    }

    protected function buildRadioGroup($label, $name, $control)
    {
        $label = $this->builder->label($label, $name)->after($control)->addClass('radio');

        $checkGroup = new CheckGroup($label);

        if ($this->builder->hasError($name)) {
            $checkGroup->helpBlock($this->builder->getError($name));
            $checkGroup->addClass('is-danger');
        }

        return $checkGroup;
    }

    public function radio($label, $name, $value = null)
    {
        if (is_null($value)) {
            $value = $label;
        }
        $control = $this->builder->radio($name, $value);
        return $this->radioGroup($label, $name, $control);
    }

    public function inlineRadio($label, $name, $value = null)
    {
        return $this->radio($label, $name, $value)->inline();
    }

    protected function radioGroup($label, $name, $control)
    {
        $checkGroup = $this->buildRadioGroup($label, $name, $control);
        return $this->wrap($checkGroup->addClass('control'));
    }

    public function textarea($label, $name)
    {
        $control = $this->builder->textarea($name)->addClass('textarea');
        return $this->formGroup($label, $name, $control);
    }

    public function date($label, $name, $value = null)
    {
        $control = $this->builder->date($name)->value($value)->addClass('input');
        return $this->formGroup($label, $name, $control);
    }

    public function dateTimeLocal($label, $name, $value = null)
    {
        $control = $this->builder->dateTimeLocal($name)->value($value)->addClass('input');
        return $this->formGroup($label, $name, $control);
    }

    public function email($label, $name, $value = null)
    {
        $control = $this->builder->email($name)->value($value)->addClass('input');
        return $this->formGroup($label, $name, $control);
    }

    public function file($label, $name, $value = null)
    {
        $control = $this->builder->file($name)->value($value)->addClass('input');
        $label = $this->builder->label($label, $name)->addClass('label')->forId($name);
        $control->id($name);

        $formGroup = new FormGroup($label, $control);

        if ($this->builder->hasError($name)) {
            $formGroup->helpBlock($this->builder->getError($name));
            $formGroup->addClass('is-danger');
        }
        return $this->wrap($formGroup);
    }

    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->builder, $method], $parameters);
    }
}

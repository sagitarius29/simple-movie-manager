<?php

namespace App\Lib;

use App\Http\Controllers\Controller;

class FormGroup extends Controller
{
    protected $title;
    protected $prefix;
    protected $inputs;

    public function __construct(string $title, string $prefix = null)
    {
        $this->title = $title;
        $this->prefix = $prefix;
    }

    public function addInput(
        string $title, string $bind, string $type = 'text', string $class = 'col-12', $config = null
    )
    {
        $arr = [
            'title' => $title,
            'bind' => $bind,
            'type' => $type,
            'required' => false,
            'class' => $class,
            'config' => $config
        ];

        if(isset($arr['config']['options'])) {
            $arr['options'] = $arr['config']['options'];
        }

        $this->inputs[] = $arr;
    }

    public function addInputRequired(
        string $title, string $bind, string $type = 'text', string $class = 'col-12', $config = null
    )
    {
        $arr = [
            'title' => $title. ' *',
            'bind' => $bind,
            'type' => $type,
            'required' => true,
            'class' => $class,
            'config' => $config
        ];

        if(isset($arr['config']['options'])) {
            $arr['options'] = $arr['config']['options'];
        }

        $this->inputs[] = $arr;
    }

    public function render()
    {
        return [
            'title' => $this->title,
            'prefix' => $this->prefix,
            'inputs' => $this->inputs
        ];
    }
}

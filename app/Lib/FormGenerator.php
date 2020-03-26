<?php

namespace App\Lib;

class FormGenerator
{
    protected $groups = [];

    public function group($title, callable $funcGroup, $prefix = null)
    {
        $group = new FormGroup($title, $prefix);
        $funcGroup($group);

        $this->groups[] = $group;
    }

    public function render()
    {
        $forms = [];

        foreach($this->groups as $group) {
            $forms[] = $group->render();
        }
        return $forms;
    }
}

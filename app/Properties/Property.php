<?php

namespace App\Properties;

/**
 * Class for properties of models
 * Class Property
 * @package App\Properties
 */
class Property
{
    protected $title;
    protected $bind;
    protected $type;
    protected $visibility = true;
    protected $visibleInTable = true;
    protected $visibleInImport = true;
    protected $inRelation;
    protected $options = null;
    protected $config = [];
    protected $class = 'col-lg-12';
    protected $required = false;

    public function __construct($title, $bind, $type)
    {
        $this->title = $title;
        $this->bind = $bind;
        $this->type = $type;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function getConfig()
    {
        $data = $this->config;

        if(is_callable($this->options)) {
            $data['options'] = ($this->options)();
        }


        return $data;
    }

    public function setOptions(callable $options)
    {
        $this->options = $options;
        return $this;
    }

    public function getOptions()
    {
        if(is_callable($this->options)) {
            return $this->options();
        }

        return [];
    }

    public function setConfig(array $config)
    {
        $this->config = $config;
        return $this;
    }

    public function hideInTable()
    {
        $this->visibleInTable = false;
        return $this;
    }

    public function hideInCreate()
    {
        $this->visibility = false;
        return $this;
    }

    public function hideInImport()
    {
        $this->visibleInImport = false;
        return $this;
    }

    public function inRelation($relation)
    {
        $this->inRelation = $relation;
        $this->hideInCreate();
        return $this;
    }

    public function getBind()
    {
        return (!empty($this->inRelation)) ? $this->inRelation.'.'.$this->bind : $this->bind;
    }

    public function isVisible()
    {
        return $this->visibility;
    }

    public function isVisibleImport()
    {
        return $this->visibility && $this->visibleInImport;
    }

    public function isVisibleInTable()
    {
        return $this->visibleInTable;
    }

    public function toTable()
    {
        return [
            'title' => $this->title,
            'name' => $this->getBind(),
            'type' => $this->type,
        ];
    }

    public function toArray()
    {
        return [
            'title' => $this->title,
            'bind' => $this->bind,
            'type' => $this->type
        ];
    }

    public function isRequired()
    {
        return $this->required;
    }

    public function setRequired()
    {
        $this->required = true;
        return $this;
    }
}

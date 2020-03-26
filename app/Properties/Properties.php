<?php

namespace App\Properties;

use App\Lib\FormGroup;

abstract class Properties
{
    protected $reference = 'general';

    /** @var Property */
    protected $properties = [];
    protected $relations = [];
    protected $importRelations = [];

    public function __construct()
    {
        $this->register();
    }

    /**
     * Add property in to internal collection
     * @param  Property  $property
     * @return Property
     */
    public function addProperty(Property $property)
    {
        return $this->properties[$property->getBind()] = $property;
    }

    /**
     * This is a relation for import with GlobalImport class
     * @param  string  $title
     * @param  string  $foreignMethod  Foreign Method executed for relation
     * @param  string  $modelClass  Class for model relation
     * @param  string  $foreignKey  Property reference of Model
     * @param string $localMethod Local Method
     */
    public function addImportRelation(string $title, string $modelClass, string $foreignMethod, string $foreignKey, string $localMethod)
    {
        $this->importRelations[] = [
            'title' => $title,
            'bind' => 'relation:'.$foreignMethod.':'.$foreignKey.':'.$localMethod,
            'class_name' => $modelClass,
        ];
    }

    /**
     * Return Array of import relations
     * @return array
     */
    public function getImportRelation() {
        return $this->importRelations;
    }

    /**
     * This method executed for register properties
     * @return void
     */
    abstract function register(): void;

    /**
     * Convert properties for a Table in format for vuetable 2
     * @param  array  $columns
     * @return array
     * @throws \Exception
     */
    public function toTable(array $columns)
    {
        $data = [];

        //dd($columns);

        if(count($columns) > 0) {
            foreach ($columns as $column) {

                if(isset($this->properties[$column])) {
                    //throw new \Exception('Do not have this column default');
                    $data[] = $this->properties[$column]->toTable();
                }

            }
        } else {
            foreach($this->properties as $property) {
                if($property->isVisibleInTable()) {
                    $data[] = $property->toTable();
                }
            }
        }

        return $data;
    }

    public function getRequiredProperties($withPassword = true)
    {
        $data = [];

        foreach($this->properties as $property) {
            if($property->isRequired() && ($withPassword || $property->getType() != 'password')) {
                $data[] = $property->toArray();
            }
        }

        return $data;
    }

    /**
     * Return collection of attributes for import
     * @return array
     */
    public function toImportAttributes()
    {
        $data = [];

        foreach ($this->importRelations as $importRelation) {
            $data[] = $importRelation;
        }

        foreach($this->properties as $property) {
            if($property->isVisibleImport()) {
                $data[] = $property->toArray();
            }
        }

        return $data;
    }

    /**
     * Get all attributes, this not contains attributes of imports
     * @return array
     */
    public function getAttributes()
    {
        $data = [];
        foreach($this->properties as $property) {
            if($property->isVisible()) {
                $data[] = $property->toArray();
            }
        }
        return $data;
    }

    /**
     * This aggregate properties a FormGroup
     * @param  FormGroup  $form
     * @param  array  $columns
     * @param  array  $cssClass
     * @return array
     * @throws \Exception
     */
    public function toForm(FormGroup $form, array $columns = [], $cssClass = [])
    {
        //TODO Refactor
        $data = [];

        if(count($columns) > 0) {
            foreach ($columns as $column) {

                if(!isset($this->properties[$column])) {
                    throw new \Exception('Do not have this column default');
                }

                $property = $this->properties[$column];

                $addInput = $property->isRequired() ? 'addInputRequired' : 'addInput';

                $form->{$addInput}(
                    $property->getTitle(),
                    $property->getBind(),
                    $property->getType(),
                    ($cssClass[$property->getBind()] ?? ($property->getClass() ?? 'col-lg-12')),
                    $property->getConfig()
                );
            }
        } else {
            foreach($this->properties as $property) {
                if($property->isVisible()) {
                    $addInput = $property->isRequired() ? 'addInputRequired' : 'addInput';

                    $form->{$addInput}(
                        $property->getTitle(),
                        $property->getBind(),
                        $property->getType(),
                        ($cssClass[$property->getBind()] ?? ($property->getClass() ?? 'col-lg-12')),
                        $property->getConfig()
                    );
                }
            }
        }

        return $data;
    }
}

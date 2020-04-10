<?php


namespace App\Forms;


use App\Lib\FormGenerator;
use App\Lib\FormGroup;

class ChapterForm implements FormContract
{

    public static function storeForm(): FormGenerator
    {
        $formGenerator = new FormGenerator();

        $formGenerator->group('General', function (FormGroup $form) {

            $form->addInput('Número Orden', 'order', 'number');
            $form->addInput('Nombre', 'name', 'text');
            $form->addInput('Video URL', 'url', 'text');
        });

        return $formGenerator;
    }
}
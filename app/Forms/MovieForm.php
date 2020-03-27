<?php


namespace App\Forms;


use App\Lib\FormGenerator;
use App\Lib\FormGroup;

class MovieForm implements FormContract
{

    public static function storeForm(): FormGenerator
    {
        $formGenerator = new FormGenerator();

        $formGenerator->group('General', function (FormGroup $form) {

            $form->addInput('Cover URL', 'cover', 'text');
            $form->addInput('Cover', 'cover', 'image');
            $form->addInput('Nombre', 'name', 'text');
            $form->addInput('Video URL', 'url', 'text');
        });

        return $formGenerator;
    }
}

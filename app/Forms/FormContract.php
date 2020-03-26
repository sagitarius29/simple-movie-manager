<?php

namespace App\Forms;

use App\Lib\FormGenerator;

interface FormContract
{
    public static function storeForm(): FormGenerator;
}

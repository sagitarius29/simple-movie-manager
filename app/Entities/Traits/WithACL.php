<?php


namespace App\Entities\Traits;


trait WithACL
{
    public function getAclAttribute()
    {
        return [
            'update' => true,
            'delete' => true
        ];
    }
}

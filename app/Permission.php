<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    function getName() {
        $name = $this->display_name;
        if($name === '')
            $name = $this->name;
        return $name;
    }
}

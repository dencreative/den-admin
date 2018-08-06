<?php

namespace App\Playbooks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];
    protected $table = 'playbook_categories';

    public function entries()
    {
        return $this->belongsToMany(Entry::class, "playbook_entries_categories");
    }
}
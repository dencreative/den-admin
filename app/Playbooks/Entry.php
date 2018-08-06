<?php

namespace App\Playbooks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use Auth;

class Entry extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'body', 'creator_id'];
    protected $table = 'playbook_entries';
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Boot the model.
     */
    public static function boot()
    {
        parent::boot();
        static::updating(function($entry) {
            $entry->adjust();
        });
    }

    public function creator() {
        return $this->belongsTo(User::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class, "playbook_entries_categories");
    }

    /**
     * Fetch all user adjustments for the document.
     */
    public function revisions()
    {
        return $this->belongsToMany(User::class, 'playbook_entries_adjustments')
            ->withTimestamps()
            ->withPivot(['before', 'after'])
            ->latest('pivot_updated_at');
    }

    /**
     * Record an adjustment to the document.
     *
     * @param integer|null $userId
     * @param array|null   $diff
     */
    public function adjust($userId = null, $diff = null)
    {
        return $this->revisions()->attach(
            $userId ?: Auth::id(),
            $diff ?: $this->getDifferences()
        );
    }

    /**
     * Fetch a diff for the model's current state.
     */
    protected function getDifferences()
    {
        $changed = $this->getDirty();
        $before = json_encode(array_intersect_key($this->fresh()->toArray(), $changed));
        $after  = json_encode($changed);
        return compact('before', 'after');
    }
}
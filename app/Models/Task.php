<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['project_id','title','status','due_date','priority','notes','is_flagged_overdue'];

    protected $casts = [
        'due_date' => 'date',
        'is_flagged_overdue' => 'boolean',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function isOverdue()
    {
        return $this->due_date && $this->due_date->isPast() && $this->status !== 'done';
    }

    public function scopeFlaggedOverdue($query)
    {
        return $query->where('is_flagged_overdue', true);
    }

    public function scopeOverdueNotFlagged($query)
    {
        return $query->where('due_date', '<', now())
                    ->whereIn('status', ['todo', 'in_progress'])
                    ->where('is_flagged_overdue', false);
    }
}

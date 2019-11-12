<?php

namespace App\Models;

use App\Utils\QuickSorter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{

    const TODO = 1;
    const DOING = 2;
    const DONE = 3;

    protected $fillable = [
        'status',
        'title',
        'description'
    ];


    /**
     * @return BelongsTo
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');

    }

    /**
     * @param Builder $query
     * @return Builder[]|Collection
     */
    public function scopeSortByStatus(Builder $query)
    {
        $status_order = [
            Task::DOING => 1,
            Task::TODO => 2,
            Task::DONE => 3
        ];

        $data = $query->get()->toArray();
        $customSorter = new QuickSorter($data);
        $sortedArray = $customSorter->sortBy("status", $status_order)->sortBy("title")->toArray();

        return collect($sortedArray);
    }
}

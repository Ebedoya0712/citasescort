<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['department_id', 'name'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public static function getGroupedOptions()
    {
        $options = [];
        $departments = \App\Models\Department::with('cities')->orderBy('name')->get();
        foreach ($departments as $dept) {
            $cities = $dept->cities()->orderBy('name')->pluck('name', 'name')->toArray();
            if (!empty($cities)) {
                $options[$dept->name] = $cities;
            }
        }
        return $options;
    }
}

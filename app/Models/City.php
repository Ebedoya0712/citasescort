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

    public static function getDepartments()
    {
        $departments = [
            'Amazonas',
            'Áncash',
            'Apurímac',
            'Arequipa',
            'Ayacucho',
            'Cajamarca',
            'Callao',
            'Cusco',
            'Huancavelica',
            'Huánuco',
            'Ica',
            'Junín',
            'La Libertad',
            'Lambayeque',
            'Lima',
            'Loreto',
            'Madre de Dios',
            'Moquegua',
            'Pasco',
            'Piura',
            'Puno',
            'San Martín',
            'Tacna',
            'Tumbes',
            'Ucayali'
        ];

        return array_combine($departments, $departments);
    }
}

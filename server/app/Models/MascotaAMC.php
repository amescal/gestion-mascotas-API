<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MascotaAMC extends Model
{
    use HasFactory;

    // Asociación de la tabla 'mascotas' con el modelo.
    protected $table = 'mascotas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nombre',
        'descripcion',
        'tipo',
        'publica',
        'megusta',
    ];

    //Establecemos la relación 1:N entre User y MascotaAMC, añadimos use...BelongsTo
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPrecio extends Model
{
    use HasFactory;

    protected $table = 'tipo_precios';
    protected $fillable = [
        'nombre',
        'estado'
    ];

    const ESTADOS = [
        '1' => 'HABILITADO',
        '2' => 'NO HABILITADO'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1': 
                return "HABILITADO";
            case '2': 
                return "NO HABILITADO";
        }
    }
}
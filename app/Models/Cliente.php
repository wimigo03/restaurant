<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Paquete;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'pais',
        'fecha_i',
        'paquete_id',
        'razon_social',
        'nombre',
        'telefono',
        'nit',
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

    public function paquete(){
        return $this->belongsTo(Paquete::class,'paquete_id','id');
    }
}

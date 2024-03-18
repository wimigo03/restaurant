<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empresa;
use App\Models\Cliente;
use App\Models\User;

class InicioMesFiscal extends Model
{
    use HasFactory;

    protected $table = 'inicio_mes_fiscal';
    protected $fillable = [
        'configuracion_id',
        'empresa_id',
        'cliente_id',
        'user_id',
        'fecha',
        'dia',
        'mes',
        'estado'
    ];

    const ESTADOS = [
        '1' => 'HABILITADO',
        '2' => 'NO HABILITADO'
    ];

    const MESES = [
        '01' => 'ENERO',
        '02' => 'FEBRERO',
        '03' => 'MARZO',
        '04' => 'ABRIL',
        '05' => 'MAYO',
        '06' => 'JUNIO',
        '07' => 'JULIO',
        '08' => 'AGOSTO',
        '09' => 'SEPTIEMBRE',
        '10' => 'OCTUBRE',
        '11' => 'NOVIEMBRE',
        '12' => 'DICIEMBRE',
    ];

    const DIAS = [
        '01' => '1',
        '02' => '2',
        '03' => '3',
        '04' => '4',
        '05' => '5',
        '06' => '6',
        '07' => '7',
        '08' => '8',
        '09' => '9',
        '10' => '10',
        '11' => '11',
        '12' => '12',
        '13' => '13',
        '14' => '14',
        '15' => '15',
        '16' => '16',
        '17' => '17',
        '18' => '18',
        '19' => '19',
        '20' => '20',
        '21' => '21',
        '22' => '22',
        '23' => '23',
        '24' => '24',
        '25' => '25',
        '26' => '26',
        '27' => '27',
        '28' => '28',
        '29' => '29',
        '30' => '30'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1': 
                return "HABILITADO";
            case '2': 
                return "NO HABILITADO";
        }
    }

    public function getMesGestionAttribute(){
        switch ($this->mes) {
            case '1': 
                return "ENERO";
            case '2': 
                return "FEBRERO";
            case '3': 
                return "MARZO";
            case '4': 
                return "ABRIL";
            case '5': 
                return "MAYO";
            case '6': 
                return "JUNIO";
            case '7': 
                return "JULIO";
            case '8': 
                return "AGOSTO";
            case '9': 
                return "SEPTIEMBRE";
            case '10': 
                return "OCTUBRE";
            case '11': 
                return "NOVIEMBRE";
            case '12': 
                return "DICIEMBRE";
        }
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class,'empresa_id','id');
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class,'cliente_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function scopeByEmpresa($query, $empresa_id){
        if($empresa_id){
            return $query->where('empresa_id', $empresa_id);
        }
    }
}
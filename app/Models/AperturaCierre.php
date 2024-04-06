<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Cargo;
use App\Models\Empresa;
use App\Models\Cliente;
use Carbon\Carbon;

class AperturaCierre extends Model
{
    use HasFactory;

    protected $table = 'apertura_cierres';
    protected $fillable = [
        'user_id',
        'cargo_id',
        'empresa_id',
        'cliente_id',
        'codigo',
        'fecha_inicial',
        'fecha_cierre',
        'monto_apertura',
        'obervaciones',
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

    public function getcolorBadgeStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "badge-with-padding badge badge-success";
            case '2':
                return "badge-with-padding badge badge-danger";
        }
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function cargo(){
        return $this->belongsTo(Cargo::class,'cargo_id','id');
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class,'empresa_id','id');
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class,'cliente_id','id');
    }

    public function scopeByEmpresa($query, $empresa_id){
        if($empresa_id){
            return $query->where('empresa_id', $empresa_id);
        }
    }

    public function scopeByCodigo($query, $codigo){
        if($codigo){
            return $query->where('codigo', $codigo);
        }
    }

    public function scopeByUser($query, $user_id){
        if($user_id){
            return $query->where('user_id', $user_id);
        }
    }

    public function scopeByCargo($query, $cargo_id){
        if($cargo_id){
            return $query->where('cargo_id', $cargo_id);
        }
    }

    public function scopeByMonto($query, $monto){
        if($monto){
            $monto = floatval(str_replace(",", "", $monto));
            return $query->where('monto_apertura', 'like', $monto . '%');
        }
    }

    public function scopeByFechaInicio($query, $fecha_inicio){
        if ($fecha_inicio) {
            $fecha_inicio = date('Y-m-d', strtotime(str_replace('/', '-', $fecha_inicio)));
            return $query->where('fecha_inicial', $fecha_inicio);
        }
    }

    public function scopeByFechaCierre($query, $fecha_cierre){
        if ($fecha_cierre) {
            $fecha_cierre = date('Y-m-d', strtotime(str_replace('/', '-', $fecha_cierre)));
            return $query->where('fecha_cierre', $fecha_cierre);
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado){
            return $query->where('estado', $estado);
        }
    }
}

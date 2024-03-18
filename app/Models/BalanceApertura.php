<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empresa;
use App\Models\Cliente;
use App\Models\User;
use App\Models\Cargo;
use App\Models\Comprobante;
use App\Models\ComprobanteF;
use App\Models\TipoCambio;
use Carbon\Carbon;

class BalanceApertura extends Model
{
    use HasFactory;

    protected $table = 'balance_apertura';
    protected $fillable = [
        'empresa_id',
        'cliente_id',
        'user_id',
        'cargo_id',
        'comprobante_id',
        'tipo_cambio_id',
        'gestion',
        'base',
        'estado'
    ];

    const ESTADOS = [
        '1' => 'PENDIENTE',
        '2' => 'APROBADO',
        '3' => 'ANULADO'
    ];

    const BASES = [
        '1' => 'I',
        '2' => 'F'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1': 
                return "PENDIENTE";
            case '2': 
                return "APROBADO";
            case '3': 
                return "ANULADO";
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

    public function cargo(){
        return $this->belongsTo(Cargo::class,'cargo_id','id');
    }

    public function comprobante(){
        return $this->belongsTo(Comprobante::class,'comprobante_id','id');
    }

    public function tipo_cambio(){
        return $this->belongsTo(TipoCambio::class,'tipo_cambio_id','id');
    }

    public function scopeByEmpresa($query, $empresa_id){
        if($empresa_id)  
            return $query->where('empresa_id', $empresa_id);
    }

    public function getNroComprobanteAttribute(){
        if($this->base == 1){
            $comprobante = Comprobante::select('nro_comprobante')->where('id',$this->comprobante_id)->first();
        }else{
            $comprobante = ComprobanteF::select('nro_comprobante')->where('id',$this->comprobante_id)->first();
        }
        return $comprobante->nro_comprobante;
    }

    /*public function scopeByNroComprobante($query, $nro_comprobante){
        if($nro_comprobante)  
            return $query->where('nro_comprobante', $nro_comprobante);
    }

    public function scopeByConcepto($query, $concepto){
        if($concepto)  
            return $query->where('concepto', 'like', '%' . $concepto . '%');
    }

    public function scopeByTipo($query, $tipo){
        if($tipo)  
            return $query->where('tipo', $tipo);
    }

    public function scopeByEstado($query, $estado){
        if($estado)  
            return $query->where('estado', $estado);
    }

    public function scopeByMonto($query, $monto){
        if($monto)  
            return $query->where('monto', 'like', '%' . $monto . '%');
    }

    public function scopeByCopia($query, $copia){
        if($copia)  
            return $query->where('copia', $copia);
    }*/
}

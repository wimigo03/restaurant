<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empresa;
use App\Models\PiCliente;
use App\Models\Sucursal;
use App\Models\Zona;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';
    protected $fillable = [
        'mesa_id',
        'zona_id',
        'sucursal_id',
        'empresa_id',
        'pi_cliente_id',
        'user_id',
        'cargo_id',
        'anombrede',
        'cantidad_clientes',
        'date_i',
        'date_f',
        'descuento',
        'total',
        'estado'
    ];

    const ESTADOS = [
        '1' => 'PROCESANDO',
        '2' => 'GENERADO',
        '3' => 'ANULADO'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "EN PROCESO";
            case '2':
                return "GENERADO";
            case '3':
                return "SERVIDO";
        }
    }

    public function getcolorStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "badge-with-padding badge badge-success";
            case '2':
                return "badge-with-padding badge badge-danger";
            case '3':
                return "badge-with-padding badge badge-warning";
        }
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class,'empresa_id','id');
    }

    public function cliente(){
        return $this->belongsTo(PiCliente::class,'pi_cliente_id','id');
    }

    public function sucursal(){
        return $this->belongsTo(Sucursal::class,'sucursal_id','id');
    }

    public function zona(){
        return $this->belongsTo(Zona::class,'zona_id','id');
    }

    /*public function scopeByPiCliente($query, $pi_cliente_id){
        if($pi_cliente_id != null){
            return $query->where('pi_cliente_id', $pi_cliente_id);
        }
    }

    public function scopeByEmpresa($query, $empresa_id){
        if($empresa_id != null){
            return $query->where('mesas.empresa_id', $empresa_id);
        }
    }

    public function scopeBySucursal($query, $sucursal_id){
        if($sucursal_id != null){
            return $query->where('mesas.sucursal_id', $sucursal_id);
        }
    }

    public function scopeByZona($query, $zona_id){
        if($zona_id != null){
            return $query->where('mesas.zona_id', $zona_id);
        }
    }

    public function scopeByNumero($query, $numero){
        if($numero != null){
            return $query->where('mesas.numero', $numero);
        }
    }

    public function scopeBySillas($query, $sillas){
        if($sillas != null){
            return $query->where('mesas.sillas', $sillas);
        }
    }

    public function scopeByDetalle($query, $detalle){
        if($detalle != null){
            return $query->where('mesas.detalle', 'like', '%' . $detalle . '%');
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado != null){
            return $query->where('mesas.estado', $estado);
        }
    }*/
}

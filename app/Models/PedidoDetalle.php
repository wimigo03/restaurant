<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empresa;
use App\Models\PiCliente;
use App\Models\Sucursal;
use App\Models\Zona;
use App\Models\Categoria;
use App\Models\Producto;

class PedidoDetalle extends Model
{
    use HasFactory;

    protected $table = 'pedido_detalles';
    protected $fillable = [
        'pedido_id',
        'mesa_id',
        'zona_id',
        'sucursal_id',
        'empresa_id',
        'pi_cliente_id',
        'precio_producto_id',
        'producto_id',
        'categoria_id',
        'unidad_id',
        'categoria_master_id',
        'moneda_id',
        'pais_id',
        'tipo_precio_id',
        'user_id',
        'cargo_id',
        'cantidad',
        'precio',
        'estado'
    ];

    const ESTADOS = [
        '1' => 'HABILITADO',
        '2' => 'GENERADO',
        '3' => 'ELIMINADO'
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "HABILITADO";
            case '2':
                return "ELIMINADO";
        }
    }

    public function getcolorStatusAttribute(){
        switch ($this->estado) {
            case '1':
                return "badge-with-padding badge badge-success";
            case '2':
                return "badge-with-padding badge badge-danger";
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

    public function categoria_master(){
        return $this->belongsTo(Categoria::class,'categoria_master_id','id');
    }

    public function producto(){
        return $this->belongsTo(Producto::class,'producto_id','id');
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

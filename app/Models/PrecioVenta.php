<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;
use App\Models\Empresa;
use App\Models\Cliente;
use App\Models\Categoria;
use App\Models\PlanCuenta;
use App\Models\Unidad;
use App\Models\Moneda;
use App\Models\Paises;
use App\Models\TipoPrecio;

class PrecioVenta extends Model
{
    use HasFactory;

    protected $table = 'precio_ventas';
    protected $fillable = [
        'producto_id',
        'empresa_id',
        'cliente_id',
        'categoria_id',
        'categoria_master_id',
        'plan_cuenta_id',
        'unidad_id',
        'moneda_id',
        'pais_id',
        'tipo_precio_id',
        'costo',
        'p_descuento',
        'costo_final',
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

    public function producto(){
        return $this->belongsTo(Producto::class,'producto_id','id');
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class,'empresa_id','id');
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class,'cliente_id','id');
    }

    public function categoria(){
        return $this->belongsTo(Categoria::class,'categoria_id','id');
    }

    public function categoria_master(){
        return $this->belongsTo(Categoria::class,'categoria_master_id','id');
    }

    public function plan_cuenta(){
        return $this->belongsTo(PlanCuenta::class,'zona_id','id');
    }

    public function unidad(){
        return $this->belongsTo(Unidad::class,'unidad_id','id');
    }

    public function moneda(){
        return $this->belongsTo(Moneda::class,'moneda_id','id');
    }

    public function pais(){
        return $this->belongsTo(Paises::class,'pais_id','id');
    }

    public function tipo_p(){
        return $this->belongsTo(TipoPrecio::class,'tipo_precio_id','id');
    }

    public function scopeByEmpresa($query, $empresa_id){
        if($empresa_id){
            return $query->where('precio_ventas.empresa_id', $empresa_id);
        }
    }
}
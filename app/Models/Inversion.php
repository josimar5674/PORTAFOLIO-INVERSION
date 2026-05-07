<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comercial;

class Inversion extends Model
{
public function clientes()
{
    return $this->belongsToMany(Cliente::class, 'inversion_cliente');
}
protected $table = 'inversiones';
protected $fillable = [
    'cliente_id',
    'nombre',
    'clave',
    'ubicacion',
    'descripcion'
];

// Relación
public function avaluos()
{
    return $this->hasMany(Avaluo::class);
}

public function ultimoAvaluo()
{
    return $this->hasOne(Avaluo::class)->latestOfMany();
}

public function getValorTerrenoAttribute()
{
    return $this->ultimoAvaluo->valor_terreno ?? 0;
}

public function getValorConstruccionAttribute()
{
    return $this->ultimoAvaluo->valor_construccion ?? 0;
}

public function getValorTotalAttribute()
{
    return $this->ultimoAvaluo->valor_total ?? 0;
}

public function getDepreciacionAnualAttribute()
{
    $vidaUtil = 20; // años (podés hacerlo dinámico después)

    if ($this->valor_construccion == 0) return 0;

    return $this->valor_construccion / $vidaUtil;
}

public function getValorNetoAttribute()
{
    return $this->valor_total - $this->depreciacion_anual;
}


public function getRendimientoPorcentajeAttribute()
{
    // ejemplo básico (luego lo conectamos con ingresos reales)
    if ($this->valor_total == 0) return 0;

    $ganancia = 0; // placeholder (luego usamos unidades)

    return ($ganancia / $this->valor_total) * 100;
}

public function servicios()
{
    return $this->hasMany(Servicio::class);
}

public function getCostoOperativoMensualAttribute()
{
    return $this->servicios->sum('costo_mensual');
}

public function getCostoOperativoAnualAttribute()
{
    return $this->costo_operativo_mensual * 12;
}

public function comercial()

{

    return $this->hasMany(Comercial::class);

}

public function entidades()
{
    return $this->belongsToMany(
        Entidad::class,
        'entidad_inversion'
    );
}




}

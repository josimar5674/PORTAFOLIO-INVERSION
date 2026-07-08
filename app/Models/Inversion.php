<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comercial;
use App\Models\EstadoResultado;

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
    'descripcion',
    'tasa_descuento',
    'tasa_impuestos',
    'tasa_crecimiento',
    'otros_gastos',
    'gasto_financiero'

];

// Relación
public function avaluos()
{
    return $this->hasMany(Avaluo::class);
}

public function ultimoAvaluo()

{

    return $this->hasOne(Avaluo::class)
      ->ofMany('fecha_avaluo', 'max');

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

public function activosRegistrales()
{
    return $this->hasMany(ActivoRegistral::class);
}


public function estadosResultado()
{
    return $this->hasMany(EstadoResultado::class);
}

public function ultimoEstadoResultado()

{

    return $this->hasOne(EstadoResultado::class)

        ->latestOfMany('anio');

}

public function usuarios()
{
    return $this->belongsToMany(
        User::class,
        'user_inversion'
    );
}
public function documentos()
{
    return $this->morphMany(
        Document::class,
        'documentable'
    );
}

public function notas()
{
    return $this->morphMany(
        Note::class,
        'notable'
    );
}


}

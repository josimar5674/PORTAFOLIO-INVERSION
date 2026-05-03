@extends('layouts.app')

@section('content')
<div class="form-card" style="width:80%; max-width:80%;">

    <div class="form-title">
        ⚙️ Perfil Operativo - Servicios (Inversión #{{ $inversion_id }})
    </div>

    <form method="POST" action="/inversiones/{{ $inversion_id }}/servicios">
        @csrf

        <input type="hidden" name="inversion_id" value="{{ $inversion_id }}">

        <table style="width:100%; border-collapse: collapse;">
            <thead>
                <tr style="background:#f3f4f6;">
                    <th>Clave</th>
                    <th>Prestador</th>
                    <th>Categoría</th>
                    <th>Servicio</th>
                    <th>Relación</th>
                    <th>Costo Mensual</th>
                    <th>Costo Anual</th>
                    <th></th>
                </tr>
            </thead>

            <tbody id="tablaServicios">
                <tr>
                    <td><input type="text" name="clave[]" class="form-control"></td>
                    <td><input type="text" name="prestador[]" class="form-control"></td>
                    <td><input type="text" name="categoria[]" class="form-control"></td>
                    <td><input type="text" name="servicio[]" class="form-control"></td>
                    <td><input type="text" name="relacion[]" class="form-control"></td>

                    <td>
                        <input type="number" step="0.01" name="costo_mensual[]" 
                               class="form-control costo-mensual" 
                               oninput="calcularFila(this)">
                    </td>

                    <td>
                        <input type="number" step="0.01" name="costo_anual[]" 
                               class="form-control costo-anual" readonly>
                    </td>

                    <td>
                        <button type="button" onclick="eliminarFila(this)">🗑️</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div style="margin-top:10px;">
            <button type="button" onclick="agregarFila()" class="btn-secondary">
                ➕ AGREGAR MÁS
            </button>
        </div>

        <div style="margin-top:20px; text-align:right;">
            <strong>TOTAL ANUAL: $ <span id="totalGeneral">0.00</span></strong>
        </div>

        <div style="margin-top:20px;">
            <button type="submit" class="btn-primary-custom">💾 Guardar</button>
        </div>
        

    </form>

</div>

<script>
function calcularFila(input) {
    const fila = input.closest('tr');
    const mensual = parseFloat(input.value) || 0;
    const anual = mensual * 12;

    fila.querySelector('.costo-anual').value = anual.toFixed(2);

    calcularTotal();
}

function calcularTotal() {
    let total = 0;

    document.querySelectorAll('.costo-anual').forEach(input => {
        total += parseFloat(input.value) || 0;
    });

    document.getElementById('totalGeneral').innerText = total.toFixed(2);
}

function agregarFila() {
    const tabla = document.getElementById('tablaServicios');

    const nuevaFila = tabla.rows[0].cloneNode(true);

    nuevaFila.querySelectorAll('input').forEach(input => input.value = '');

    tabla.appendChild(nuevaFila);
}

function eliminarFila(btn) {
    const fila = btn.closest('tr');

    if (document.querySelectorAll('#tablaServicios tr').length > 1) {
        fila.remove();
        calcularTotal();
    }
}
</script>

@endsection
@extends('layouts.app')
@section('content')


<div class="form-card" style="width:90%; max-width:90%;">

<div class="form-title">
    💰 Perfil Comercial (Inversión #{{ $inversion_id }})
</div>

<form method="POST" action="/inversiones/{{ $inversion_id }}/comercial">
    @csrf

    <input type="hidden" name="inversion_id" value="{{ $inversion_id }}">

    <table style="width:100%; border-collapse: collapse;">
        <thead>
            <tr style="background:#f3f4f6;">
                <th>Producto</th>
                <th>Cliente</th>
                <th>Cantidad</th>
                <th>Unidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
                <th></th>
            </tr>
        </thead>

        <tbody id="tablaComercial">
            <tr>
                <td><input type="text" name="producto[]" class="form-control"></td>
                <td><input type="text" name="cliente[]" class="form-control"></td>

                <td>
                    <input type="number" step="0.01" name="cantidad[]" 
                           class="form-control cantidad"
                           oninput="calcularFila(this)">
                </td>

                <td>
                    <input type="text" name="unidad[]" class="form-control">
                </td>

                <td>
                    <input type="number" step="0.01" name="precio[]" 
                           class="form-control precio"
                           oninput="calcularFila(this)">
                </td>

                <td>
                    <input type="number" step="0.01" name="subtotal[]" 
                           class="form-control subtotal" readonly>
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
        <strong>TOTAL: L <span id="totalGeneral">0.00</span></strong>
    </div>

    <div style="margin-top:20px;">
        <button type="submit" class="btn-primary-custom">💾 Guardar</button>
    </div>

</form>

</div>


<script>

function calcularFila(input) {
    const fila = input.closest('tr');

    const cantidad = parseFloat(fila.querySelector('.cantidad').value) || 0;
    const precio = parseFloat(fila.querySelector('.precio').value) || 0;

    const subtotal = cantidad * precio;

    fila.querySelector('.subtotal').value = subtotal.toFixed(2);

    calcularTotal();
}

function calcularTotal() {
    let total = 0;

    document.querySelectorAll('.subtotal').forEach(input => {
        total += parseFloat(input.value) || 0;
    });

    document.getElementById('totalGeneral').innerText = total.toFixed(2);
}

function agregarFila() {
    const tabla = document.getElementById('tablaComercial');

    const nuevaFila = tabla.rows[0].cloneNode(true);

    nuevaFila.querySelectorAll('input').forEach(input => input.value = '');

    tabla.appendChild(nuevaFila);
}

function eliminarFila(btn) {
    const fila = btn.closest('tr');

    if (document.querySelectorAll('#tablaComercial tr').length > 1) {
        fila.remove();
        calcularTotal();
    }
}

</script>

@endsection

document.addEventListener('DOMContentLoaded', () => {

    const container = document.getElementById('socios-container');

    if (!container) {
        return;
    }

    const template = document.getElementById('filaSocio');
    const btnAgregar = document.getElementById('agregarSocio');
    const totalTexto = document.getElementById('totalPorcentaje');

    let indiceSocio = 0;

    function recalcular() {

        let total = 0;

        document.querySelectorAll('.porcentaje').forEach(input => {

            total += parseFloat(input.value) || 0;

        });

        totalTexto.textContent = total.toFixed(2) + "%";

        if (Math.abs(total - 100) < 0.01) {

            totalTexto.style.color = "#16a34a";

        } else if (total > 100) {

            totalTexto.style.color = "#dc2626";

        } else {

            totalTexto.style.color = "#ca8a04";

        }

    }

    function agregarSocio(clienteId = "", porcentaje = "") {

        const clone = template.content.cloneNode(true);

        const fila = clone.querySelector('.fila-socio');

        const select = fila.querySelector('select');

        const input = fila.querySelector('.porcentaje');

        select.name = `socios[${indiceSocio}][cliente_id]`;
        input.name = `socios[${indiceSocio}][porcentaje]`;

        if (clienteId !== "") {
            select.value = clienteId;
        }

        if (porcentaje !== "") {
            input.value = porcentaje;
        }

        indiceSocio++;

        container.appendChild(clone);

        recalcular();

    }

    btnAgregar.addEventListener('click', () => {

        agregarSocio();

    });

    container.addEventListener('input', function (e) {

        if (e.target.classList.contains('porcentaje')) {

            recalcular();

        }

    });

    container.addEventListener('click', function (e) {

        if (e.target.classList.contains('btnEliminar')) {

            e.target.closest('.fila-socio').remove();

            recalcular();

        }

    });

    if (
        window.sociosActuales &&
        window.sociosActuales.length > 0
    ) {

        window.sociosActuales.forEach(socio => {

            agregarSocio(
                socio.cliente_id,
                socio.porcentaje
            );

        });

    } else {

        agregarSocio();

    }

});
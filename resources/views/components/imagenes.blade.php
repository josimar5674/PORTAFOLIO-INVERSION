
<style>

.imagenes-component {
    margin: 28px 0 45px 0;
    padding-bottom: 35px;
    border-bottom: 1px solid var(--border);
}

    .imagenes-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }

    .imagenes-header strong {
        font-size: 16px;
    }

</style>


<div class="imagenes-header">

    <div>
        <strong>📷 Imágenes</strong>

            @if(auth()->user()->role === 'admin')

        <button
            type="button"
            class="btn-secondary"
            style="cursor: pointer;"
            onclick="document.getElementById('inputImagenes').click()">

            + Agregar

        </button>

    @endif
    </div>



</div>


    {{-- FORMULARIO PARA SUBIR IMÁGENES --}}

    <form
        id="formImagenes"
        method="POST"
        action="{{ route('imagenes.store') }}"
        enctype="multipart/form-data"
        style="display:none;">

        @csrf

        <input
            type="hidden"
            name="imageable_type"
            value="{{ get_class($modelo) }}">

        <input
            type="hidden"
            name="imageable_id"
            value="{{ $modelo->id }}">

        <input
            type="file"
            id="inputImagenes"
            name="imagenes[]"
            multiple
            accept="image/jpeg,image/png,image/webp"
            onchange="document.getElementById('formImagenes').submit()">

    </form>


    {{-- GALERÍA --}}

    <div class="imagenes-grid">

        @forelse($modelo->imagenes as $imagen)

            <div class="imagen-item">

                <img
                    src="{{ asset('storage/' . $imagen->ruta) }}"
                    alt="{{ $imagen->descripcion ?? 'Imagen' }}"
                >

                <div class="imagen-overlay">

                    <button
                        type="button"
                        class="imagen-action"
                        title="Ver imagen"
                        onclick="verImagen({{ $imagen->id }})">

                        👁️

                    </button>

                 @if(auth()->user()->role === 'admin')

    <form
        method="POST"
        action="{{ route('imagenes.destroy', $imagen->id) }}"
        onsubmit="event.preventDefault(); confirmarEliminacion(this);">

        @csrf
        @method('DELETE')

        <button
            type="submit"
            class="imagen-action imagen-delete"
            title="Eliminar imagen">

            🗑️

        </button>

    </form>

@endif

                </div>

            </div>

        @empty

            <div class="imagenes-empty">
                No hay imágenes.
            </div>

        @endforelse

    </div>

{{-- VISOR DE IMÁGENES --}}

<div id="imageViewerModal" class="image-viewer">

    <div class="image-viewer-box">

        <button
            type="button"
            class="image-viewer-close"
            onclick="cerrarVisorImagen()">

            ✕

        </button>


        <button
            type="button"
            class="image-viewer-arrow image-viewer-prev"
            onclick="imagenAnterior()">

            ‹

        </button>


        <div class="image-viewer-content">

            <img
                id="imageViewerImage"
                src=""
                alt="Imagen">

            <div
                id="imageViewerDescription"
                class="image-viewer-description">
            </div>

            <div
                id="imageViewerCounter"
                class="image-viewer-counter">
            </div>

            <a
                id="imageViewerDownload"
                class="image-viewer-download"
                href="#"
                download>

                ⬇ Descargar

            </a>

        </div>


        <button
            type="button"
            class="image-viewer-arrow image-viewer-next"
            onclick="imagenSiguiente()">

            ›

        </button>

    </div>

  

</div>

  <br>



<style>

    .imagenes-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 15px;
    }


    .imagen-item {
        position: relative;

        width: 100px;
        height: 75px;

        border-radius: 10px;
        overflow: hidden;

        border: 1px solid var(--border);

        background: #f3f4f6;

        cursor: pointer;

        transition:
            transform 0.25s ease,
            box-shadow 0.25s ease;

        z-index: 1;
    }


    .imagen-item img {
        width: 100%;
        height: 100%;

        object-fit: cover;

        display: block;

        transition:
            transform 0.35s ease,
            filter 0.25s ease;
    }


    /* Efecto al pasar el mouse */

    .imagen-item:hover {

        transform: scale(1.35);

        box-shadow:
            0 8px 20px rgba(0, 0, 0, 0.18);

        z-index: 10;
    }


    .imagen-item:hover img {

        transform: scale(1.08);

        filter: brightness(0.65);
    }


    /* Capa oscura */

    .imagen-overlay {

        position: absolute;

        inset: 0;

        display: flex;

        align-items: center;

        justify-content: center;

        gap: 8px;

        opacity: 0;

        transition: opacity 0.25s ease;

        background: rgba(0, 0, 0, 0.20);
    }


    .imagen-item:hover .imagen-overlay {

        opacity: 1;
    }


    /* Botones */

    .imagen-action {

        width: 34px;
        height: 34px;

        border: none;
        border-radius: 50%;

        background: rgba(255, 255, 255, 0.92);

        cursor: pointer;

        display: flex;

        align-items: center;
        justify-content: center;

        font-size: 16px;

        transition:
            transform 0.2s ease,
            background 0.2s ease;
    }


    .imagen-action:hover {

        transform: scale(1.12);

        background: white;
    }


    .imagen-delete {

        color: #dc2626;
    }


    .imagen-overlay form {

        margin: 0;
    }


    .imagenes-empty {

        color: #9ca3af;

        font-size: 13px;

        padding: 8px 0;
    }


    /* En dispositivos táctiles no dependemos del hover */

    @media (hover: none) {

        .imagen-item {

            cursor: pointer;
        }

        .imagen-overlay {

            opacity: 1;

            background: linear-gradient(
                transparent 45%,
                rgba(0,0,0,0.45)
            );

            align-items: flex-end;

            padding-bottom: 5px;
        }

        .imagen-item:hover {

            transform: none;

            box-shadow: none;
        }

        .imagen-item:hover img {

            transform: none;

            filter: none;
        }

    }

</style>


<style>

    /* =========================================================
       VISOR DE IMÁGENES
    ========================================================= */

    .image-viewer {

        position: fixed;

        inset: 0;

        z-index: 9999;

        display: none;

        align-items: center;

        justify-content: center;

        padding: 30px;

        background: rgba(0, 0, 0, 0.88);

        backdrop-filter: blur(5px);

        opacity: 0;

        transition: opacity 0.25s ease;
    }



    .image-viewer.show {

        display: flex;

        opacity: 1;
    }


    .image-viewer-box {

        position: relative;

        width: min(1100px, 95vw);

        height: min(800px, 90vh);

        display: flex;

        align-items: center;

        justify-content: center;
    }


    .image-viewer-content {

        max-width: 90%;

        max-height: 90%;

        display: flex;

        flex-direction: column;

        align-items: center;

        justify-content: center;
    }


    .image-viewer-content img {

        max-width: 100%;

        max-height: 70vh;

        object-fit: contain;

        border-radius: 10px;

        box-shadow:
            0 20px 60px rgba(0, 0, 0, 0.45);

        animation: imageViewerIn 0.25s ease;
    }


    @keyframes imageViewerIn {

        from {
            opacity: 0;
            transform: scale(0.96);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }

    }


    .image-viewer-close {

        position: absolute;

        top: 10px;

        right: 10px;

        width: 42px;

        height: 42px;

        border: none;

        border-radius: 50%;

        background: rgba(255,255,255,0.12);

        color: white;

        font-size: 25px;

        cursor: pointer;

        z-index: 5;

        transition:
            background 0.2s ease,
            transform 0.2s ease;
    }


    .image-viewer-close:hover {

        background: rgba(255,255,255,0.22);

        transform: scale(1.08);
    }


    .image-viewer-arrow {

        position: absolute;

        top: 50%;

        transform: translateY(-50%);

        width: 48px;

        height: 48px;

        border: none;

        border-radius: 50%;

        background: rgba(255,255,255,0.14);

        color: white;

        font-size: 40px;

        line-height: 1;

        cursor: pointer;

        z-index: 5;

        transition:
            background 0.2s ease,
            transform 0.2s ease;
    }


    .image-viewer-arrow:hover {

        background: rgba(255,255,255,0.25);

    }


    .image-viewer-prev {

        left: 0;
    }


    .image-viewer-next {

        right: 0;
    }


    .image-viewer-description {

        margin-top: 14px;

        color: rgba(255,255,255,0.9);

        font-size: 14px;

        text-align: center;

        max-width: 700px;
    }


    .image-viewer-counter {

        margin-top: 6px;

        color: rgba(255,255,255,0.55);

        font-size: 13px;
    }


    .image-viewer-download {

        display: inline-block;

        margin-top: 14px;

        padding: 8px 15px;

        border-radius: 8px;

        background: rgba(255,255,255,0.12);

        color: white;

        text-decoration: none;

        font-size: 13px;

        transition:
            background 0.2s ease,
            transform 0.2s ease;
    }


    .image-viewer-download:hover {

        background: rgba(255,255,255,0.22);

        transform: translateY(-1px);
    }


    @media (max-width: 700px) {

        .image-viewer {

            padding: 15px;
        }


        .image-viewer-box {

            width: 100%;

            height: 90vh;
        }


        .image-viewer-content {

            max-width: 82%;
        }


        .image-viewer-content img {

            max-height: 65vh;
        }


        .image-viewer-arrow {

            width: 42px;

            height: 42px;

            font-size: 34px;
        }


        .image-viewer-prev {

            left: 2px;
        }


        .image-viewer-next {

            right: 2px;
        }

    }

</style>

@php
    $imagenesGaleria = $modelo->imagenes->map(function ($imagen) {
        return [
            'id' => $imagen->id,
            'src' => asset('storage/' . $imagen->ruta),
            'descripcion' => $imagen->descripcion ?? '',
        ];
    })->values()->toArray();
@endphp

<script>

    const imagenesGaleria = @json($imagenesGaleria);

    let imagenActual = 0;


    function verImagen(id)
    {
        const indice = imagenesGaleria.findIndex(
            imagen => imagen.id === id
        );

        if (indice === -1) {
            return;
        }

        imagenActual = indice;

        mostrarImagenActual();

        document
            .getElementById('imageViewerModal')
            .classList.add('show');

        document.body.style.overflow = 'hidden';
    }

    // ...el resto de tu JavaScript


    function mostrarImagenActual()
    {
        if (!imagenesGaleria.length) {
            return;
        }

        const imagen = imagenesGaleria[imagenActual];


        document
            .getElementById('imageViewerImage')
            .src = imagen.src;


        document
            .getElementById('imageViewerDescription')
            .textContent =
                imagen.descripcion;


        document
            .getElementById('imageViewerCounter')
            .textContent =
                `${imagenActual + 1} / ${imagenesGaleria.length}`;


        document
            .getElementById('imageViewerDownload')
            .href = imagen.src;
    }


    function cerrarVisorImagen()
    {
        document
            .getElementById('imageViewerModal')
            .classList.remove('show');

        document.body.style.overflow = '';
    }


    function imagenAnterior()
    {
        if (!imagenesGaleria.length) {
            return;
        }

        imagenActual--;

        if (imagenActual < 0) {
            imagenActual =
                imagenesGaleria.length - 1;
        }

        mostrarImagenActual();
    }


    function imagenSiguiente()
    {
        if (!imagenesGaleria.length) {
            return;
        }

        imagenActual++;

        if (
            imagenActual >=
            imagenesGaleria.length
        ) {
            imagenActual = 0;
        }

        mostrarImagenActual();
    }


    document
        .getElementById('imageViewerModal')
        .addEventListener('click', function(event) {

            if (event.target === this) {
                cerrarVisorImagen();
            }

        });


    document.addEventListener(
        'keydown',
        function(event) {

            const modal =
                document.getElementById(
                    'imageViewerModal'
                );

            if (!modal.classList.contains('show')) {
                return;
            }


            if (event.key === 'Escape') {

                cerrarVisorImagen();

            }


            if (event.key === 'ArrowLeft') {

                imagenAnterior();

            }


            if (event.key === 'ArrowRight') {

                imagenSiguiente();

            }

        }
    );

</script>

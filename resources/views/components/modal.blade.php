<div id="{{ $id }}" class="modal-overlay-custom">

    <div class="modal-window-custom">

        <div class="modal-header-custom">

            <h3>{{ $title }}</h3>

            <button
                type="button"
                class="modal-close-custom"
                onclick="cerrarModal('{{ $id }}')">

                ✕

            </button>

        </div>

        <div class="modal-body-custom">

            {{ $slot }}

        </div>

    </div>

</div>
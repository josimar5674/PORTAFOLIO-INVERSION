<div class="card-seccion">

    <h3>📄 Documentos</h3>

    <form
        method="POST"
        action="/documentos"
        enctype="multipart/form-data">

        @csrf

        <input
            type="hidden"
            name="documentable_type"
            value="{{ $modelClass }}">

        <input
            type="hidden"
            name="documentable_id"
            value="{{ $modelo->id }}">

        <div style="
            display:flex;
            gap:10px;
            margin-bottom:15px;
        ">

            <input
                type="text"
                name="nombre"
                class="form-control"
                placeholder="Nombre del documento..."
                required>

            <input
                type="file"
                name="archivo"
                class="form-control"
                required>

            <button
                type="submit"
                class="btn-primary-custom">
        Subir
                📤

            </button>

        </div>

    </form>

    @forelse($modelo->documentos()->latest()->get() as $documento)

    <div class="card-info">

            <div style="flex:1;">

                <div>

                    📄 <strong>{{ $documento->nombre }}</strong>

                </div>

                <small style="color:#6b7280;">

                    {{ $documento->created_at->format('d/m/Y H:i') }}

                </small>

            </div>

            <input
    type="hidden"
    name="return_url"
    value="{{ url()->full() }}">

            <div style="display:flex; gap:10px; align-items:center;">

                <a
                    href="{{ asset('storage/'.$documento->archivo) }}"
                    target="_blank"
                    class="btn-secondary">

                    Ver

                </a>

                <form
                    method="POST"
                    action="/documentos/{{ $documento->id }}">

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        style="
                            border:none;
                            background:none;
                            color:#ef4444;
                            cursor:pointer;
                            font-size:16px;
                        ">

                        🗑️

                    </button>

                </form>

            </div>

        </div>

    @empty

        <div style="
            color:#6b7280;
            padding:10px;
        ">

            No hay documentos cargados.

        </div>

    @endforelse

</div>
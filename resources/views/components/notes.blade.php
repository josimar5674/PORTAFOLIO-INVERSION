<div class="card-seccion">

    <h3>📝 Notas</h3>

    <form
        method="POST"
        action="/notes">

        @csrf

        <input
            type="hidden"
            name="notable_type"
            value="{{ $modelClass }}">

        <input
            type="hidden"
            name="notable_id"
            value="{{ $modelo->id }}">

        <div style="
            display:flex;
            gap:10px;
            margin-bottom:15px;
        ">

            <input
                type="text"
                name="note"
                class="form-control"
                placeholder="Escriba una nota..."
                required>

            <button
                type="submit"
                class="btn-primary-custom">

                ➕

            </button>

        </div>

    </form>

    @forelse($modelo->notas()->latest()->get() as $nota)

           <div class="card-info">


            <div style="flex:1;">

                <div>

                    {{ $nota->note }}

                </div>

                <small style="
                    color:#6b7280;
                ">

                    {{ $nota->created_at->format('d/m/Y H:i') }}

                </small>

            </div>

            <form
                method="POST"
                action="/notes/{{ $nota->id }}">

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

    @empty

        <div style="
            color:#6b7280;
            padding:10px;
        ">

            No hay notas registradas.

        </div>

    @endforelse

</div>
<div>

    <!-- ===================================== -->
    <!-- HEADER -->
    <!-- ===================================== -->

    <h3>
        📧 Google Workspace
    </h3>

    <p style="
        color:var(--text-secondary);
        margin-top:-5px;
        margin-bottom:25px;
    ">
        Configuración de la conexión con Google Workspace
        para el envío de correos electrónicos.
    </p>


    <!-- ===================================== -->
    <!-- ESTADO DE CONEXIÓN -->
    <!-- ===================================== -->

    <div class="card-info" style="
        margin-bottom:20px;
    ">

        <div>

            <strong>
                🔌 Estado de conexión
            </strong>

            <div style="
                color:var(--text-secondary);
                margin-top:5px;
            ">

                @if(isset($googleConnected) && $googleConnected)

                    <span style="
                        color:#16a34a;
                        font-weight:600;
                    ">
                        ● Conectado
                    </span>

                    @if(isset($googleAccount))

                        <div style="
                            margin-top:5px;
                            color:var(--text-secondary);
                        ">
                            Cuenta:
                            {{ $googleAccount }}
                        </div>

                    @endif

                    @if(isset($googleConnectedAt))

                        <div style="
                            margin-top:5px;
                            color:var(--text-secondary);
                        ">
                            Conectado:
                            {{ $googleConnectedAt }}
                        </div>

                    @endif

                @else

                    <span style="
                        color:#dc2626;
                        font-weight:600;
                    ">
                        ● No conectado
                    </span>

                    <div style="
                        margin-top:5px;
                    ">
                        Todavía no se ha establecido una conexión con Google.
                    </div>

                @endif

            </div>

        </div>

    </div>


    <!-- ===================================== -->
    <!-- FORMULARIO DE CONFIGURACIÓN -->
    <!-- ===================================== -->

    <form
        method="POST"
        action="{{ route('google.save') }}"
    >

        @csrf


        <!-- ===================================== -->
        <!-- CREDENCIALES GOOGLE CLOUD -->
        <!-- ===================================== -->

        <div class="card-info" style="
            margin-bottom:20px;
        ">

            <div style="width:100%;">

                <strong>
                    🔑 Credenciales de Google Cloud
                </strong>

                <p style="
                    color:var(--text-secondary);
                    margin-top:5px;
                    margin-bottom:20px;
                ">
                    Introduce las credenciales OAuth 2.0
                    obtenidas desde Google Cloud Console.
                </p>


                <!-- CLIENT ID -->

                <div class="form-group" style="
                    margin-bottom:18px;
                ">

                    <label>
                        Client ID
                    </label>

                    <input
                        type="text"
                        name="client_id"
                        class="form-control"
                        value="{{ old('client_id', $googleClientId ?? '') }}"
                        placeholder="Ej. 123456789012-xxxxxxxxxxxxxxxx.apps.googleusercontent.com"
                        required
                    >

                </div>


                <!-- CLIENT SECRET -->

                <div class="form-group" style="
                    margin-bottom:18px;
                ">

                    <label>
                        Client Secret
                    </label>

                    <input
                        type="password"
                        name="client_secret"
                        class="form-control"
                        placeholder="Ingresa el Client Secret"
                        required
                    >

                </div>


                <!-- REDIRECT URI -->

                <div class="form-group">

                    <label>
                        Redirect URI
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ route('google.callback') }}"
                        readonly
                    >

                    <small style="
                        display:block;
                        margin-top:6px;
                        color:var(--text-secondary);
                    ">
                        Esta dirección deberá agregarse en Google Cloud
                        como URI de redirección autorizada.
                    </small>

                </div>

            </div>

        </div>


        <!-- ===================================== -->
        <!-- CONFIGURACIÓN DEL CORREO -->
        <!-- ===================================== -->

        <div class="card-info" style="
            margin-bottom:20px;
        ">

            <div style="width:100%;">

                <strong>
                    ✉️ Configuración del correo
                </strong>

                <p style="
                    color:var(--text-secondary);
                    margin-top:5px;
                    margin-bottom:20px;
                ">
                    Datos utilizados para identificar la cuenta
                    que realizará el envío de correos.
                </p>


                <!-- CORREO -->

                <div class="form-group" style="
                    margin-bottom:18px;
                ">

                    <label>
                        Correo de Google Workspace
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', $googleEmail ?? '') }}"
                        placeholder="correo@tuempresa.com"
                        required
                    >

                </div>


                <!-- NOMBRE DEL REMITENTE -->

                <div class="form-group">

                    <label>
                        Nombre del remitente
                    </label>

                    <input
                        type="text"
                        name="sender_name"
                        class="form-control"
                        value="{{ old('sender_name', $googleSenderName ?? '') }}"
                        placeholder="Nombre que aparecerá en los correos"
                    >

                </div>

            </div>

        </div>

<!-- ===================================== -->
<!-- BOTONES -->
<!-- ===================================== -->

<div style="
    display:flex;
    justify-content:flex-end;
    gap:10px;
    margin-top:20px;
">

    <!-- GUARDAR -->

    <button
        type="submit"
        class="btn-primary-custom"
    >
        💾 Guardar configuración
    </button>

    <!-- CONECTAR -->

    @if(!isset($googleConnected) || !$googleConnected)

        <a
            href="{{ route('google.connect') }}"
            class="btn-primary-custom"
            style="
                text-decoration:none;
                display:inline-flex;
                align-items:center;
            "
        >
            🔐 Conectar con Google
        </a>

    @endif

</div>

</form>


<!-- ===================================== -->
<!-- DESCONECTAR -->
<!-- ===================================== -->

@if(isset($googleConnected) && $googleConnected)

    <form
        method="POST"
        action="{{ route('google.disconnect') }}"
        style="
            display:flex;
            justify-content:flex-end;
            margin-top:10px;
        "
    >

        @csrf

        <button
            type="submit"
            class="btn-secondary"
        >
            🔌 Desconectar Google
        </button>

    </form>

@endif
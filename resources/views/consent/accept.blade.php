<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aceptación de Términos – SIRN</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sirn.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #071526;
            color: #daeeff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── HEADER ── */
        .consent-header {
            background: rgba(7,21,38,.95);
            border-bottom: 1px solid rgba(34,186,187,.2);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .consent-header img { height: 36px; width: auto; }
        .consent-header-brand {
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: -.01em;
        }
        .consent-header-brand span { color: #22BABB; }
        .consent-header-badge {
            margin-left: auto;
            background: rgba(245,158,11,.12);
            border: 1px solid rgba(245,158,11,.3);
            color: #fbbf24;
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            padding: .3rem .75rem;
            border-radius: 20px;
        }

        /* ── MAIN ── */
        .consent-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            max-width: 960px;
            width: 100%;
            margin: 0 auto;
            padding: 2rem 1.5rem 3rem;
            gap: 2rem;
        }

        .consent-intro {
            text-align: center;
            padding: 1.5rem 1rem;
        }
        .consent-intro h1 {
            font-size: clamp(1.4rem, 3vw, 1.9rem);
            font-weight: 800;
            color: #fff;
            line-height: 1.2;
            margin-bottom: .6rem;
        }
        .consent-intro h1 em { color: #22BABB; font-style: normal; }
        .consent-intro p {
            font-size: .88rem;
            color: #8fa3bf;
            max-width: 560px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* ── DOCUMENT PANELS ── */
        .doc-panels {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        @media (max-width: 700px) {
            .doc-panels { grid-template-columns: 1fr; }
        }

        .doc-panel {
            background: rgba(255,255,255,.03);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 14px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .doc-panel-header {
            padding: .9rem 1.3rem;
            background: rgba(34,186,187,.06);
            border-bottom: 1px solid rgba(34,186,187,.12);
            display: flex;
            align-items: center;
            gap: .6rem;
        }
        .doc-panel-icon {
            width: 28px; height: 28px;
            background: rgba(34,186,187,.15);
            border: 1px solid rgba(34,186,187,.3);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .doc-panel-title {
            font-size: .82rem;
            font-weight: 700;
            color: #daeeff;
            line-height: 1.3;
        }
        .doc-panel-version {
            margin-left: auto;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #22BABB;
            background: rgba(34,186,187,.1);
            border: 1px solid rgba(34,186,187,.2);
            padding: .18rem .55rem;
            border-radius: 6px;
            white-space: nowrap;
        }
        .doc-panel-body {
            padding: 1rem 1.3rem;
            overflow-y: auto;
            max-height: 340px;
            font-size: .8rem;
            color: #a8c4df;
            line-height: 1.65;
            flex: 1;
        }
        .doc-panel-body::-webkit-scrollbar { width: 5px; }
        .doc-panel-body::-webkit-scrollbar-track { background: rgba(255,255,255,.03); }
        .doc-panel-body::-webkit-scrollbar-thumb { background: rgba(34,186,187,.3); border-radius: 10px; }

        .doc-panel-body h3 {
            font-size: .75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: #22BABB;
            margin: 1rem 0 .4rem;
        }
        .doc-panel-body h3:first-child { margin-top: 0; }
        .doc-panel-body p { margin-bottom: .55rem; }
        .doc-panel-body ul {
            padding-left: 1.1rem;
            margin-bottom: .55rem;
        }
        .doc-panel-body ul li { margin-bottom: .25rem; }

        /* ── FORM ── */
        .consent-form-card {
            background: rgba(255,255,255,.03);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 14px;
            padding: 1.8rem 2rem;
        }
        .consent-form-title {
            font-size: .92rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 1.3rem;
        }

        .consent-check-row {
            display: flex;
            align-items: flex-start;
            gap: .8rem;
            padding: 1rem 1.2rem;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,.07);
            background: rgba(255,255,255,.02);
            margin-bottom: .9rem;
            transition: border-color .2s, background .2s;
        }
        .consent-check-row:has(input:checked) {
            border-color: rgba(34,186,187,.35);
            background: rgba(34,186,187,.04);
        }
        .consent-check-row input[type="checkbox"] {
            width: 18px; height: 18px;
            flex-shrink: 0;
            margin-top: .15rem;
            accent-color: #22BABB;
            cursor: pointer;
        }
        .consent-check-label {
            font-size: .83rem;
            color: #a8c4df;
            line-height: 1.5;
            cursor: pointer;
        }
        .consent-check-label strong { color: #daeeff; }

        .consent-errors {
            margin-bottom: 1.2rem;
            padding: .9rem 1.2rem;
            background: rgba(239,68,68,.07);
            border: 1px solid rgba(239,68,68,.2);
            border-radius: 10px;
        }
        .consent-errors p {
            color: #f87171;
            font-size: .82rem;
            font-weight: 700;
            margin-bottom: .35rem;
        }
        .consent-errors ul {
            padding-left: 1rem;
            color: #fca5a5;
            font-size: .8rem;
        }

        .consent-submit {
            width: 100%;
            padding: .9rem 1.2rem;
            border-radius: 11px;
            border: none;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            font-size: .92rem;
            font-weight: 700;
            color: #071526;
            background: linear-gradient(130deg, #22BABB 0%, #0d9488 100%);
            transition: opacity .2s, transform .15s;
            letter-spacing: .02em;
            margin-top: .5rem;
        }
        .consent-submit:hover { opacity: .88; }
        .consent-submit:active { transform: scale(.98); }
        .consent-submit:disabled {
            opacity: .4;
            cursor: not-allowed;
            transform: none;
        }

        .consent-legal-note {
            text-align: center;
            font-size: .72rem;
            color: rgba(143,163,191,.5);
            margin-top: .75rem;
            line-height: 1.5;
        }

        /* Scroll indicator */
        .scroll-hint {
            text-align: center;
            font-size: .7rem;
            color: rgba(143,163,191,.45);
            margin-top: .4rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .3rem;
        }
    </style>
</head>
<body>

{{-- ── HEADER ── --}}
<header class="consent-header">
    <img src="{{ asset('images/logo-sirn.png') }}" alt="SIRN">
    <span class="consent-header-brand">SIR<span>N</span></span>
    <span class="consent-header-badge">⚠ Acción requerida</span>
</header>

{{-- ── MAIN ── --}}
<main class="consent-main">

    {{-- Intro --}}
    <div class="consent-intro">
        <h1>Para continuar, debes aceptar<br><em>los documentos legales</em></h1>
        <p>
            Antes de acceder al portal, lee cuidadosamente los siguientes documentos.
            Tu consentimiento es obligatorio y queda registrado con fecha, hora y dirección IP,
            conforme a la <strong style="color:#daeeff;">Ley 1581 de 2012</strong> de Colombia.
        </p>
    </div>

    {{-- Paneles de documentos --}}
    <div class="doc-panels">

        {{-- Panel 1: Política de Datos --}}
        <div class="doc-panel">
            <div class="doc-panel-header">
                <div class="doc-panel-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#22BABB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 9h6M9 13h6M9 17h4"/>
                    </svg>
                </div>
                <span class="doc-panel-title">Política de Tratamiento<br>de Datos Personales</span>
                <span class="doc-panel-version">v{{ $privacyVersion }}</span>
            </div>
            <div class="doc-panel-body" id="panel-privacy">
                <h3>1. Identificación del Responsable</h3>
                <p>La presente plataforma es operada por la comunidad responsable de la gestión de información entre iglesias participantes con fines de organización de ayudas comunitarias. El "Responsable del Tratamiento" es la entidad o administración designada por la red de iglesias que utiliza este sistema.</p>

                <h3>2. Marco Legal Aplicable</h3>
                <p>Esta política se rige por la Ley 1581 de 2012, el Decreto 1377 de 2013 y demás normas concordantes sobre protección de datos personales en la República de Colombia.</p>

                <h3>3. Datos Objeto de Tratamiento</h3>
                <ul>
                    <li>Datos de identificación (nombre completo u otros identificadores)</li>
                    <li>Datos de contacto (teléfono, correo electrónico)</li>
                    <li>Información de pertenencia a iglesias o comunidades religiosas</li>
                    <li>Información relacionada con necesidades sociales o de asistencia</li>
                    <li>Registros de solicitudes y asignación de ayudas</li>
                </ul>

                <h3>4. Finalidades del Tratamiento</h3>
                <ul>
                    <li>Gestión y coordinación de ayudas comunitarias</li>
                    <li>Registro y seguimiento de solicitudes de apoyo social</li>
                    <li>Organización interna entre iglesias participantes</li>
                    <li>Comunicación entre administradores, representantes y miembros</li>
                    <li>Generación de reportes internos operativos y sociales</li>
                </ul>

                <h3>5. Acceso a la Información</h3>
                <p>El acceso está limitado estrictamente a administradores del sistema y representantes oficialmente autorizados de cada iglesia. Cada representante accede únicamente a la información de su iglesia asignada.</p>

                <h3>6. Derechos del Titular</h3>
                <ul>
                    <li>Conocer, actualizar y rectificar sus datos personales</li>
                    <li>Solicitar prueba de la autorización otorgada</li>
                    <li>Ser informado sobre el uso dado a sus datos</li>
                    <li>Presentar quejas ante la Superintendencia de Industria y Comercio (SIC)</li>
                    <li>Revocar la autorización y/o solicitar supresión de datos</li>
                    <li>Acceder de forma gratuita a sus datos personales</li>
                </ul>

                <h3>7. Medidas de Seguridad</h3>
                <p>La plataforma implementa medidas técnicas, administrativas y organizativas razonables para proteger los datos personales contra pérdida, uso indebido, acceso no autorizado, alteración o destrucción.</p>

                <h3>8. Transferencia de Datos</h3>
                <p>Los datos no serán vendidos, cedidos ni transferidos a terceros ajenos a la comunidad, salvo autorización expresa del titular, requerimiento de autoridad competente, o cumplimiento de obligaciones legales.</p>

                <h3>9. Conservación</h3>
                <p>Los datos serán conservados durante el tiempo necesario para cumplir las finalidades descritas o mientras el titular mantenga relación activa con la comunidad.</p>

                <h3>10. Modificaciones</h3>
                <p>Esta política puede ser modificada para adaptarse a cambios normativos o técnicos. Las modificaciones serán publicadas en la plataforma y exigirán nueva aceptación.</p>
            </div>
            <p class="scroll-hint">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
                Desplázate para leer el documento completo
            </p>
        </div>

        {{-- Panel 2: Términos y Condiciones --}}
        <div class="doc-panel">
            <div class="doc-panel-header">
                <div class="doc-panel-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#22BABB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                </div>
                <span class="doc-panel-title">Términos y Condiciones<br>del Sistema</span>
                <span class="doc-panel-version">v{{ $termsVersion }}</span>
            </div>
            <div class="doc-panel-body" id="panel-terms">
                <h3>1. Objeto</h3>
                <p>El presente sistema es una plataforma digital de gestión y coordinación de información entre iglesias y organizaciones religiosas participantes de la Red de Iglesias de Neiva (SIRN).</p>

                <h3>2. Acceso y Uso Autorizado</h3>
                <p>El acceso está limitado a representantes oficialmente autorizados de cada iglesia registrada. El usuario se compromete a:</p>
                <ul>
                    <li>Usar el sistema exclusivamente para los fines para los que fue diseñado</li>
                    <li>Mantener la confidencialidad de sus credenciales de acceso</li>
                    <li>No compartir su cuenta con terceros no autorizados</li>
                    <li>Reportar inmediatamente cualquier uso no autorizado de su cuenta</li>
                </ul>

                <h3>3. Responsabilidades del Usuario</h3>
                <p>El representante autorizado es responsable de:</p>
                <ul>
                    <li>La veracidad y exactitud de la información ingresada</li>
                    <li>La actualización periódica de los datos de su iglesia</li>
                    <li>El cumplimiento de las políticas de uso del sistema</li>
                    <li>Las acciones realizadas bajo sus credenciales de acceso</li>
                </ul>

                <h3>4. Propiedad de la Información</h3>
                <p>La información registrada por cada iglesia es de propiedad de la respectiva organización religiosa. Al usar el sistema, el representante autoriza su almacenamiento y uso conforme a los fines establecidos en la Política de Tratamiento de Datos.</p>

                <h3>5. Modificaciones al Sistema</h3>
                <p>El administrador se reserva el derecho de modificar, suspender o descontinuar cualquier funcionalidad cuando las circunstancias lo requieran.</p>

                <h3>6. Suspensión de Acceso</h3>
                <p>El acceso podrá ser suspendido en caso de:</p>
                <ul>
                    <li>Uso fraudulento o no autorizado</li>
                    <li>Ingreso de información falsa o engañosa</li>
                    <li>Incumplimiento de los presentes términos</li>
                    <li>Solicitud del representante legal de la organización</li>
                </ul>

                <h3>7. Limitación de Responsabilidad</h3>
                <p>El sistema se proporciona "tal como está". El administrador no garantiza disponibilidad ininterrumpida y no será responsable por pérdidas derivadas de la indisponibilidad temporal del servicio.</p>

                <h3>8. Jurisdicción</h3>
                <p>Los presentes términos se rigen por la legislación colombiana vigente, especialmente la Ley 1581 de 2012, la Ley 1341 de 2009 y demás normas aplicables.</p>

                <h3>9. Vigencia</h3>
                <p>Estos términos entran en vigor desde su aceptación y se mantienen vigentes durante toda la relación del usuario con el sistema. Cambios en los términos requerirán nueva aceptación.</p>
            </div>
            <p class="scroll-hint">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
                Desplázate para leer el documento completo
            </p>
        </div>

    </div>{{-- /doc-panels --}}

    {{-- Formulario de aceptación --}}
    <div class="consent-form-card">
        <p class="consent-form-title">✔ Confirma tu aceptación</p>

        @if($errors->any())
        <div class="consent-errors">
            <p>Debes aceptar todos los documentos para continuar:</p>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('consent.store') }}">
            @csrf

            <label class="consent-check-row">
                <input type="checkbox" name="accept_privacy" value="1" id="chk_privacy"
                       {{ old('accept_privacy') ? 'checked' : '' }}>
                <span class="consent-check-label">
                    He leído y <strong>acepto la Política de Tratamiento y Protección de Datos Personales</strong>
                    (v{{ $privacyVersion }}) y autorizo el uso de mi información conforme a lo establecido,
                    en cumplimiento de la Ley 1581 de 2012 de Colombia.
                </span>
            </label>

            <label class="consent-check-row">
                <input type="checkbox" name="accept_terms" value="1" id="chk_terms"
                       {{ old('accept_terms') ? 'checked' : '' }}>
                <span class="consent-check-label">
                    He leído y <strong>acepto los Términos y Condiciones del Sistema</strong>
                    (v{{ $termsVersion }}) y me comprometo a cumplir las normas de uso establecidas.
                </span>
            </label>

            <button type="submit" class="consent-submit" id="btn-accept">
                Acepto ambos documentos y deseo continuar →
            </button>
        </form>

        <p class="consent-legal-note">
            Al confirmar, se registrará tu consentimiento con fecha, hora y dirección IP.<br>
            Este registro tiene validez legal conforme a la Ley 1581 de 2012 (Colombia).
        </p>
    </div>

</main>

<script>
    // Habilitar/deshabilitar botón según checkboxes
    const chkPrivacy = document.getElementById('chk_privacy');
    const chkTerms   = document.getElementById('chk_terms');
    const btnAccept  = document.getElementById('btn-accept');

    function updateBtn() {
        btnAccept.disabled = !(chkPrivacy.checked && chkTerms.checked);
    }

    chkPrivacy.addEventListener('change', updateBtn);
    chkTerms.addEventListener('change', updateBtn);
    updateBtn(); // estado inicial
</script>

</body>
</html>

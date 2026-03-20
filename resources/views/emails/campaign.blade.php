<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $campaign->subject }}</title>
    <style>
        body {
            margin: 0; padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            color: #1E293B;
        }
        .email-wrapper {
            max-width: 640px;
            margin: 0 auto;
            background: #ffffff;
        }
        .email-header {
            background: linear-gradient(135deg, #0a1f5c 0%, #0f2d7a 45%, #1E3A8A 100%);
            padding: 32px 30px;
            text-align: center;
        }
        .email-header h1 {
            color: #ffffff;
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 6px;
        }
        .email-header p {
            color: #93C5FD;
            font-size: 13px;
            margin: 0;
        }
        .email-body {
            padding: 30px;
            font-size: 15px;
            line-height: 1.7;
            color: #334155;
        }
        .email-body img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin: 16px 0;
        }
        .email-images {
            padding: 0 30px 20px;
        }
        .email-images img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 12px;
            display: block;
        }
        .email-footer {
            background: #F8FAFC;
            border-top: 1px solid #E2E8F0;
            padding: 20px 30px;
            text-align: center;
            font-size: 12px;
            color: #94A3B8;
        }
        .greeting {
            font-size: 14px;
            color: #64748B;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
    <div style="padding: 20px 10px; background-color: #f4f6f9;">
        <div class="email-wrapper">

            {{-- Header --}}
            <div class="email-header">
                <h1>SER – Sistema Estratégico Religioso</h1>
                <p>Neiva, Huila – Colombia</p>
            </div>

            {{-- Body --}}
            <div class="email-body">
                <p class="greeting">Hola <strong>{{ $iglesia->pastor_full_name ?: $iglesia->official_name }}</strong>,</p>

                {!! $campaign->message !!}
            </div>

            {{-- Imágenes incrustadas inline (CID pre-computado) --}}
            @if($images->isNotEmpty() && !empty($imageSrcs))
                <div class="email-images">
                    @foreach($images as $img)
                        @if(isset($imageSrcs[$img->id]))
                            <img src="{{ $imageSrcs[$img->id] }}"
                                 alt="{{ $img->original_name ?? 'Imagen de campaña' }}">
                        @endif
                    @endforeach
                </div>
            @endif

            {{-- Footer --}}
            <div class="email-footer">
                <p>Este correo fue enviado desde el <strong>Sistema Estratégico Religioso de Neiva</strong>.</p>
                <p style="margin-top: 8px;">© {{ date('Y') }} SER – Neiva, Huila</p>
            </div>

        </div>
    </div>
</body>
</html>

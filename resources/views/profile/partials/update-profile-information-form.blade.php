<section>
    @if (session('status') === 'profile-updated')
        <div class="p-alert-ok" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            Perfil actualizado correctamente.
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" novalidate>
        @csrf @method('PATCH')

        <div class="p-grid-2" style="margin-bottom: 20px;">

            {{-- Nombre --}}
            <div>
                <label class="p-label" for="name">Nombre completo</label>
                <input id="name" name="name" type="text"
                       class="p-input {{ $errors->profileUpdate->has('name') ? 'has-error' : '' }}"
                       value="{{ old('name', $user->name) }}"
                       required autocomplete="name">
                @error('name', 'profileUpdate')
                    <p class="p-error">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="p-label" for="email">Correo electrónico</label>
                <input id="email" name="email" type="email"
                       class="p-input {{ $errors->profileUpdate->has('email') ? 'has-error' : '' }}"
                       value="{{ old('email', $user->email) }}"
                       required autocomplete="username">
                @error('email', 'profileUpdate')
                    <p class="p-error">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        {{-- Verificación pendiente --}}
        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="flex items-start gap-3 bg-amber-50 border border-amber-200 rounded-xl p-4 mb-5">
                <svg class="w-4 h-4 text-amber-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-xs font-bold text-amber-800">Correo sin verificar</p>
                    <p class="text-xs text-amber-700 mt-0.5">
                        Tu correo no está verificado.
                        <button form="send-verification" class="underline font-semibold hover:text-amber-900">
                            Reenviar verificación
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="text-xs text-green-600 font-semibold mt-1">¡Enlace enviado a tu correo!</p>
                    @endif
                </div>
            </div>
            <form id="send-verification" method="POST" action="{{ route('verification.send') }}">@csrf</form>
        @endif

        <button type="submit" class="p-btn-save">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            Guardar cambios
        </button>
    </form>
</section>
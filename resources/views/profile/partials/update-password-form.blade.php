<section>
    @if (session('status') === 'password-updated')
        <div class="p-alert-ok">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            Contraseña actualizada correctamente.
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" novalidate>
        @csrf @method('PUT')

        <div style="display:flex; flex-direction:column; gap:16px; margin-bottom:20px;">

            {{-- Contraseña actual --}}
            <div>
                <label class="p-label" for="current_password">Contraseña actual</label>
                <div class="p-pwd-wrap">
                    <input id="current_password" name="current_password" type="password"
                           class="p-input {{ $errors->updatePassword->has('current_password') ? 'has-error' : '' }}"
                           placeholder="••••••••••"
                           autocomplete="current-password">
                    <button type="button" class="p-pwd-eye" onclick="sirn_togglePwd('current_password', this)" aria-label="Ver contraseña">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                </div>
                @error('current_password', 'updatePassword')
                    <p class="p-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                @enderror
            </div>

            <div class="p-grid-2">
                {{-- Nueva contraseña --}}
                <div>
                    <label class="p-label" for="password">Nueva contraseña</label>
                    <div class="p-pwd-wrap">
                        <input id="password" name="password" type="password"
                               class="p-input {{ $errors->updatePassword->has('password') ? 'has-error' : '' }}"
                               placeholder="••••••••••"
                               autocomplete="new-password">
                        <button type="button" class="p-pwd-eye" onclick="sirn_togglePwd('password', this)" aria-label="Ver contraseña">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                    @error('password', 'updatePassword')
                        <p class="p-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirmar --}}
                <div>
                    <label class="p-label" for="password_confirmation">Confirmar contraseña</label>
                    <div class="p-pwd-wrap">
                        <input id="password_confirmation" name="password_confirmation" type="password"
                               class="p-input"
                               placeholder="••••••••••"
                               autocomplete="new-password">
                        <button type="button" class="p-pwd-eye" onclick="sirn_togglePwd('password_confirmation', this)" aria-label="Ver contraseña">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="p-btn-save">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            Actualizar contraseña
        </button>
    </form>

    <script>
        function sirn_togglePwd(id, btn) {
            const input = document.getElementById(id);
            input.type  = input.type === 'password' ? 'text' : 'password';
            btn.style.color = input.type === 'text' ? '#1E3A8A' : '#94A3B8';
        }
    </script>
</section>
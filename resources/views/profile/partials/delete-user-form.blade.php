<section>
    <div class="p-danger-zone">
        <p class="p-danger-title">Eliminar cuenta</p>
        <p class="p-danger-desc">
            Una vez eliminada tu cuenta, todos los datos serán borrados permanentemente.
            Esta acción <strong>no se puede deshacer</strong>.
        </p>
        <button type="button" class="p-btn-danger" onclick="sirn_abrirModalDelete()">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            Eliminar mi cuenta
        </button>
    </div>

    {{-- Modal confirmación --}}
    <div id="sirn-modal-delete" class="p-modal-overlay" role="dialog" aria-modal="true">
        <div class="p-modal-box">
            <div class="p-modal-header">
                <div class="p-modal-icon">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <p class="p-modal-title">¿Eliminar cuenta?</p>
                    <p class="p-modal-sub">Esta acción no se puede deshacer</p>
                </div>
            </div>

            <div class="p-modal-body">
                <p>Para confirmar la eliminación de tu cuenta, ingresa tu contraseña actual.</p>

                <form id="sirn-form-delete" method="POST" action="{{ route('profile.destroy') }}">
                    @csrf @method('DELETE')
                    <div>
                        <label class="p-label" for="delete_password">Contraseña actual</label>
                        <div class="p-pwd-wrap">
                            <input id="delete_password" name="password" type="password"
                                   class="p-input {{ $errors->userDeletion->has('password') ? 'has-error' : '' }}"
                                   placeholder="••••••••••"
                                   autocomplete="current-password">
                            <button type="button" class="p-pwd-eye" onclick="sirn_togglePwd('delete_password', this)">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                        @error('password', 'userDeletion')
                            <p class="p-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                        @enderror
                    </div>
                </form>
            </div>

            <div class="p-modal-footer">
                <button type="button" class="p-btn-modal-cancel" onclick="sirn_cerrarModalDelete()">Cancelar</button>
                <button type="submit" form="sirn-form-delete" class="p-btn-modal-confirm">Sí, eliminar cuenta</button>
            </div>
        </div>
    </div>

    <script>
        function sirn_abrirModalDelete() {
            document.getElementById('sirn-modal-delete').classList.add('show');
            document.body.style.overflow = 'hidden';
            setTimeout(() => document.getElementById('delete_password')?.focus(), 100);
        }
        function sirn_cerrarModalDelete() {
            document.getElementById('sirn-modal-delete').classList.remove('show');
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') sirn_cerrarModalDelete();
        });
        @if($errors->userDeletion->isNotEmpty())
            document.addEventListener('DOMContentLoaded', () => sirn_abrirModalDelete());
        @endif
    </script>
</section>
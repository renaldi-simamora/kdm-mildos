<section>
    <header style="margin-bottom: 24px;">
        <h2 style="font-size: 17px; font-weight: 800; color: #0f172a; letter-spacing: -0.3px;">
            Profile Information
        </h2>
        <p style="font-size: 13px; color: #64748b; margin-top: 4px;">
            Informasi nama dan peran akun Anda di KDM Mildos.
        </p>
    </header>

    {{-- USER BADGE / AVATAR PREVIEW --}}
    <div style="display: flex; align-items: center; gap: 16px; padding: 16px 18px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; margin-bottom: 24px;">
        <div style="width: 48px; height: 48px; border-radius: 50%; background: #ffd900; color: #111; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 900; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.06);">
            {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
        </div>
        <div style="flex: 1; min-width: 0;">
            <div style="font-size: 15px; font-weight: 700; color: #0f172a;">
                {{ $user->name }}
            </div>
            <div style="display: flex; align-items: center; gap: 8px; margin-top: 4px;">
                @php
                    $roleLabel = ucfirst($user->role ?? 'Staff');
                    $roleBg = match(strtolower($user->role ?? '')) {
                        'superadmin', 'owner' => '#ffd900',
                        'hrd' => '#eaf1ff',
                        default => '#f1f5f9'
                    };
                    $roleColor = match(strtolower($user->role ?? '')) {
                        'superadmin', 'owner' => '#111',
                        'hrd' => '#2f7bf6',
                        default => '#475569'
                    };
                @endphp
                <span style="display: inline-flex; align-items: center; gap: 4px; padding: 2px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 700; background: {{ $roleBg }}; color: {{ $roleColor }};">
                    <span data-lucide="shield-check" style="width: 13px; height: 13px;"></span>
                    {{ $roleLabel }}
                </span>
                <span style="font-size: 12px; color: #94a3b8;">
                    {{ '@' . ($user->username ?? strtolower(str_replace(' ', '', $user->name))) }}
                </span>
            </div>
        </div>
    </div>

    <form method="post" action="{{ route('profile.update') }}" style="display: flex; flex-direction: column; gap: 20px;">
        @csrf
        @method('patch')

        {{-- Hidden email input to ensure backend FormRequest validation passes --}}
        <input type="hidden" name="email" value="{{ old('email', $user->email) }}">

        {{-- NAMA FIELD --}}
        <div>
            <label for="name" style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Nama Lengkap <span style="color: #ef4444;">*</span>
            </label>
            <div style="position: relative;">
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $user->name) }}"
                    required
                    autofocus
                    autocomplete="name"
                    class="filter-input"
                    style="width: 100%; padding-left: 38px;"
                    placeholder="Masukkan nama lengkap"
                />
                <span data-lucide="user" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #94a3b8; pointer-events: none;"></span>
            </div>
            @error('name')
                <p style="font-size: 12px; color: #ef4444; margin-top: 6px; font-weight: 500;">
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- ROLE FIELD (READONLY / DISPLAY) --}}
        <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                Role / Peran
            </label>
            <div style="position: relative;">
                <input
                    type="text"
                    value="{{ ucfirst($user->role ?? 'Staff') }}"
                    disabled
                    readonly
                    class="filter-input"
                    style="width: 100%; padding-left: 38px; background-color: #f8fafc; color: #64748b; cursor: not-allowed;"
                />
                <span data-lucide="shield" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #94a3b8; pointer-events: none;"></span>
            </div>
            <p style="font-size: 11.5px; color: #94a3b8; margin-top: 6px; display: flex; align-items: center; gap: 4px;">
                <span data-lucide="info" style="width: 13px; height: 13px;"></span>
                Role akun ditentukan oleh sistem administrator dan tidak dapat diubah secara manual.
            </p>
        </div>

        {{-- SUBMIT BUTTON --}}
        <div style="display: flex; align-items: center; gap: 12px; margin-top: 6px; padding-top: 18px; border-top: 1px solid #f1f5f9;">
            <button type="submit" class="btn-primary-orange" style="padding: 10px 24px;">
                <span data-lucide="save" style="width: 16px; height: 16px;"></span>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </form>
</section>

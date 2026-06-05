<div class="ng-profile-card ng-profile-card-session">
    <div class="ng-profile-side">
        <div>
            <div class="ng-profile-badge">
                <span></span>
                Active Sessions
            </div>

            <h2 class="ng-profile-title">
                Browser Sessions
            </h2>

            <p class="ng-profile-desc">
                Pantau perangkat yang sedang aktif menggunakan akun ini dan keluar dari sesi lain jika diperlukan.
            </p>
        </div>

        <div class="ng-profile-mini">
            <span>Keamanan Login</span>
            <strong>Dipantau</strong>
            <small>Kelola sesi browser aktif</small>
        </div>
    </div>

    <div class="ng-profile-form">
        {{ $this->form }}

        <x-filament-actions::modals />
    </div>
</div>
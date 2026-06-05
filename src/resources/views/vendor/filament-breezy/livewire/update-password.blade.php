<div class="ng-profile-card ng-profile-card-password">
    <div class="ng-profile-side">
        <div>
            <div class="ng-profile-badge">
                <span></span>
                Security
            </div>

            <h2 class="ng-profile-title">
                Password
            </h2>

            <p class="ng-profile-desc">
                Perbarui password akun secara berkala agar akses dashboard admin tetap aman.
            </p>
        </div>

        <div class="ng-profile-mini">
            <span>Minimal Password</span>
            <strong>8 Karakter</strong>
            <small>Gunakan kombinasi yang kuat</small>
        </div>
    </div>

    <div class="ng-profile-form">
        <form wire:submit.prevent="submit" class="space-y-5">
            {{ $this->form }}

            <div class="ng-profile-action">
                <x-filament::button type="submit" form="submit" class="ng-profile-submit">
                    Update Password
                </x-filament::button>
            </div>
        </form>
    </div>
</div>
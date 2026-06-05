<div class="ng-profile-card ng-profile-card-personal">
    <div class="ng-profile-side">
        <div>
            <div class="ng-profile-badge">
                <span></span>
                Profile Account
            </div>

            <h2 class="ng-profile-title">
                Personal Information
            </h2>

            <p class="ng-profile-desc">
                Kelola informasi akun admin yang digunakan untuk mengakses dashboard POS Ngunjuk.
            </p>
        </div>

        <div class="ng-profile-mini">
            <span>Status Akun</span>
            <strong>Aktif</strong>
            <small>Data profil utama pengguna</small>
        </div>
    </div>

    <div class="ng-profile-form">
        <form wire:submit.prevent="submit" class="space-y-5">
            {{ $this->form }}

            <div class="ng-profile-action">
                <x-filament::button type="submit" form="submit" class="ng-profile-submit">
                    Update Profile
                </x-filament::button>
            </div>
        </form>
    </div>
</div>
<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Users\Pages;

use App\Filament\Admin\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected ?string $heading = 'Tambah User Baru';

    protected ?string $subheading = 'Buat akun baru untuk super admin atau karyawan yang akan menggunakan sistem POS Ngunjuk.';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

<x-filament-panels::page>
    @php
        $user = $record;
        $user->loadMissing('roles');

        $backUrl = \App\Filament\Admin\Resources\Users\UserResource::getUrl('index');
        $editUrl = \App\Filament\Admin\Resources\Users\UserResource::getUrl('edit', ['record' => $user]);

        $roles = $user->roles
            ->pluck('name')
            ->map(fn ($role) => str($role)->replace('_', ' ')->title()->toString())
            ->values();

        $roleText = $roles->isNotEmpty() ? $roles->implode(', ') : '-';

        $avatarPath = $user->avatar_url;

        if ($avatarPath && str_starts_with($avatarPath, 'http')) {
            $avatarUrl = $avatarPath;
        } elseif ($avatarPath) {
            $avatarUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($avatarPath);
        } else {
            $hash = md5(mb_strtolower(mb_trim((string) $user->email)));
            $avatarUrl = 'https://www.gravatar.com/avatar/' . $hash . '?d=mp&r=g&s=250';
        }

        $cards = [
            [
                'label' => 'Nama User',
                'value' => $user->name ?? '-',
                'caption' => 'Akun pengguna',
                'icon' => '▣',
                'color' => '#f97316',
            ],
            [
                'label' => 'Role',
                'value' => $roleText,
                'caption' => 'Hak akses sistem',
                'icon' => '✓',
                'color' => '#10b981',
            ],
            [
                'label' => 'Dibuat',
                'value' => $user->created_at?->translatedFormat('d M Y') ?? '-',
                'caption' => 'Tanggal akun dibuat',
                'icon' => '◇',
                'color' => '#3b82f6',
            ],
            [
                'label' => 'Update',
                'value' => $user->updated_at?->diffForHumans() ?? '-',
                'caption' => 'Terakhir diperbarui',
                'icon' => '↗',
                'color' => '#8b5cf6',
            ],
        ];
    @endphp

    <div class="ng-user-detail-page">
        <section class="ng-user-detail-hero">
            <article class="ng-user-detail-hero-main">
                <div>
                    <span class="ng-user-kicker">POS Ngunjuk</span>
                    <h1>Detail User</h1>
                    <p>
                        Informasi lengkap akun pengguna, role akses, email, avatar, waktu pembuatan akun,
                        dan waktu terakhir data diperbarui.
                    </p>
                </div>

                <div class="ng-user-hero-actions">
                    <a href="{{ $backUrl }}" class="ng-user-back-btn">
                        ← Kembali
                    </a>

                    <a href="{{ $editUrl }}" class="ng-user-edit-btn">
                        Edit User
                    </a>
                </div>
            </article>

            <article class="ng-user-detail-profile-card">
                <img src="{{ $avatarUrl }}" alt="{{ $user->name }}" class="ng-user-avatar">

                <div>
                    <span>User Terpilih</span>
                    <strong>{{ $user->name }}</strong>
                    <small>{{ $user->email }}</small>
                </div>
            </article>
        </section>

        <section class="ng-user-detail-kpi-grid">
            @foreach ($cards as $card)
                <article class="ng-user-detail-kpi" style="--accent: {{ $card['color'] }};">
                    <div class="ng-user-detail-kpi-icon">
                        {{ $card['icon'] }}
                    </div>

                    <div>
                        <span>{{ $card['label'] }}</span>
                        <strong>{{ $card['value'] }}</strong>
                        <p>{{ $card['caption'] }}</p>
                    </div>
                </article>
            @endforeach
        </section>

        <section class="ng-user-detail-grid">
            <article class="ng-user-detail-card">
                <div class="ng-user-card-head">
                    <div>
                        <h2>Informasi Akun</h2>
                        <p>Ringkasan profil pengguna sistem POS.</p>
                    </div>

                    <span class="ng-role-pill">
                        {{ $roleText }}
                    </span>
                </div>

                <div class="ng-user-info-list">
                    <div>
                        <span>Nama User</span>
                        <strong>{{ $user->name ?? '-' }}</strong>
                    </div>

                    <div>
                        <span>Email</span>
                        <strong>{{ $user->email ?? '-' }}</strong>
                    </div>

                    <div>
                        <span>Role Akses</span>
                        <strong>{{ $roleText }}</strong>
                    </div>

                    <div>
                        <span>ID User</span>
                        <strong>#{{ $user->id }}</strong>
                    </div>

                    <div>
                        <span>Dibuat</span>
                        <strong>{{ $user->created_at?->translatedFormat('d F Y H:i') ?? '-' }}</strong>
                    </div>

                    <div>
                        <span>Terakhir Update</span>
                        <strong>{{ $user->updated_at?->translatedFormat('d F Y H:i') ?? '-' }}</strong>
                    </div>
                </div>
            </article>

            <article class="ng-user-detail-card">
                <div class="ng-user-card-head">
                    <div>
                        <h2>Avatar User</h2>
                        <p>Foto profil akun pengguna.</p>
                    </div>
                </div>

                <div class="ng-user-avatar-preview">
                    <img src="{{ $avatarUrl }}" alt="{{ $user->name }}">

                    <strong>{{ $user->name }}</strong>
                    <span>{{ $user->email }}</span>
                </div>
            </article>
        </section>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-user-detail-page) {
            background:
                linear-gradient(120deg, rgba(255, 248, 237, .10), rgba(255, 224, 185, .02)),
                url('/images/pos-orange-bg.png'),
                radial-gradient(circle at 15% 8%, rgba(255, 255, 255, .32) 0 130px, transparent 280px),
                radial-gradient(circle at 88% 78%, rgba(255, 118, 0, .42) 0 250px, transparent 520px),
                radial-gradient(circle at 20% 96%, rgba(255, 181, 83, .28) 0 220px, transparent 500px),
                linear-gradient(135deg, #fff3df 0%, #ffd394 48%, #ff9c45 100%) !important;
            background-size: cover !important;
            background-position: center !important;
            background-attachment: fixed !important;
        }

        body:has(.ng-user-detail-page) .fi-main,
        body:has(.ng-user-detail-page) .fi-main-ctn,
        body:has(.ng-user-detail-page) .fi-page,
        body:has(.ng-user-detail-page) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-user-detail-page) .fi-page {
            padding: 0 !important;
        }

        body:has(.ng-user-detail-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-user-detail-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-user-detail-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-user-detail-page) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-user-detail-page) .fi-sidebar-item a {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-user-detail-page) .fi-sidebar-item-active a,
        body:has(.ng-user-detail-page) .fi-sidebar-item a:hover {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        .ng-user-detail-page {
            width: 100%;
            min-height: 100vh;
            padding: 18px 18px 28px;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-user-detail-page * {
            box-sizing: border-box;
        }

        .ng-user-detail-hero {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(340px, .65fr);
            gap: 12px;
            margin-bottom: 12px;
        }

        .ng-user-detail-hero-main,
        .ng-user-detail-profile-card,
        .ng-user-detail-kpi,
        .ng-user-detail-card {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .56);
            background: rgba(255, 247, 235, .18);
            box-shadow:
                0 20px 48px rgba(101, 58, 21, .10),
                0 0 0 1px rgba(255, 255, 255, .10) inset,
                inset 0 1px 0 rgba(255, 255, 255, .56);
            backdrop-filter: blur(13px);
        }

        .ng-user-detail-hero-main {
            min-height: 126px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 20px 22px;
            border-radius: 24px;
        }

        .ng-user-kicker {
            display: inline-flex;
            width: fit-content;
            padding: 6px 12px;
            margin-bottom: 9px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .42);
            border: 1px solid rgba(255, 255, 255, .54);
            color: #d95d00;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .10em;
            text-transform: uppercase;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .62);
            backdrop-filter: blur(10px);
        }

        .ng-user-detail-hero-main h1 {
            margin: 0;
            color: #21160d;
            font-size: 30px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .ng-user-detail-hero-main p {
            max-width: 760px;
            margin: 7px 0 0;
            color: #765d45;
            font-size: 12px;
            font-weight: 650;
            line-height: 1.5;
        }

        .ng-user-hero-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .ng-user-back-btn,
        .ng-user-edit-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 0 17px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 950;
            text-decoration: none !important;
            white-space: nowrap;
        }

        .ng-user-back-btn {
            color: #6f5844 !important;
            background: rgba(255, 255, 255, .42);
            border: 1px solid rgba(255, 255, 255, .55);
        }

        .ng-user-edit-btn {
            color: #fff !important;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 14px 26px rgba(238, 101, 0, .26);
        }

        .ng-user-detail-profile-card {
            min-height: 126px;
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 20px 22px;
            border-radius: 24px;
        }

        .ng-user-avatar {
            width: 62px;
            height: 62px;
            border-radius: 20px;
            object-fit: cover;
            border: 1px solid rgba(255, 255, 255, .58);
            box-shadow: 0 14px 26px rgba(101, 58, 21, .14);
        }

        .ng-user-detail-profile-card span,
        .ng-user-detail-profile-card small {
            display: block;
            color: #765d45;
            font-size: 11px;
            font-weight: 850;
        }

        .ng-user-detail-profile-card strong {
            display: block;
            margin: 7px 0;
            color: #21160d;
            font-size: 22px;
            line-height: 1.1;
            font-weight: 950;
        }

        .ng-user-detail-kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
            margin-bottom: 12px;
        }

        .ng-user-detail-kpi {
            min-height: 90px;
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 14px;
            border-radius: 20px;
        }

        .ng-user-detail-kpi-icon {
            display: grid;
            place-items: center;
            flex: 0 0 auto;
            width: 40px;
            height: 40px;
            border-radius: 14px;
            color: #fff;
            background: linear-gradient(135deg, var(--accent), #d95d00);
            box-shadow: 0 14px 24px rgba(249, 115, 22, .20);
            font-size: 15px;
            font-weight: 950;
        }

        .ng-user-detail-kpi span {
            display: block;
            color: #6f5946;
            font-size: 11px;
            font-weight: 900;
        }

        .ng-user-detail-kpi strong {
            display: block;
            margin-top: 6px;
            color: #23160d;
            font-size: 18px;
            line-height: 1.15;
            font-weight: 950;
            letter-spacing: -.03em;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ng-user-detail-kpi p {
            margin: 6px 0 0;
            color: #6f5946;
            font-size: 10px;
            font-weight: 850;
        }

        .ng-user-detail-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(320px, .65fr);
            gap: 12px;
        }

        .ng-user-detail-card {
            border-radius: 24px;
        }

        .ng-user-card-head {
            min-height: 58px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 15px 20px;
            background: rgba(255, 247, 235, .10);
            border-bottom: 1px solid rgba(114, 74, 41, .07);
        }

        .ng-user-card-head h2 {
            margin: 0;
            color: #25170d;
            font-size: 17px;
            line-height: 1.2;
            font-weight: 950;
            letter-spacing: -.03em;
        }

        .ng-user-card-head p {
            margin: 5px 0 0;
            color: #7b624c;
            font-size: 12px;
            font-weight: 750;
        }

        .ng-role-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 30px;
            padding: 0 12px;
            border-radius: 999px;
            color: #078657;
            background: rgba(16, 185, 129, .12);
            border: 1px solid rgba(16, 185, 129, .22);
            font-size: 11px;
            font-weight: 950;
            white-space: nowrap;
        }

        .ng-user-info-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            padding: 18px 20px 20px;
        }

        .ng-user-info-list div {
            min-height: 74px;
            padding: 14px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .20);
            border: 1px solid rgba(255, 255, 255, .38);
        }

        .ng-user-info-list span {
            display: block;
            color: #6f5946;
            font-size: 11px;
            font-weight: 900;
        }

        .ng-user-info-list strong {
            display: block;
            margin-top: 7px;
            color: #23160d;
            font-size: 14px;
            font-weight: 950;
            word-break: break-word;
        }

        .ng-user-avatar-preview {
            padding: 24px;
            text-align: center;
        }

        .ng-user-avatar-preview img {
            width: 140px;
            height: 140px;
            border-radius: 34px;
            object-fit: cover;
            border: 1px solid rgba(255, 255, 255, .58);
            box-shadow: 0 18px 36px rgba(101, 58, 21, .14);
        }

        .ng-user-avatar-preview strong,
        .ng-user-avatar-preview span {
            display: block;
        }

        .ng-user-avatar-preview strong {
            margin-top: 14px;
            color: #21160d;
            font-size: 18px;
            font-weight: 950;
        }

        .ng-user-avatar-preview span {
            margin-top: 6px;
            color: #765d45;
            font-size: 12px;
            font-weight: 750;
        }

        @media (max-width: 1500px) {
            .ng-user-detail-hero,
            .ng-user-detail-grid {
                grid-template-columns: 1fr;
            }

            .ng-user-detail-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 900px) {
            .ng-user-detail-page {
                padding: 14px;
            }

            .ng-user-detail-hero-main {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-user-detail-kpi-grid,
            .ng-user-info-list {
                grid-template-columns: 1fr;
            }
        }
    </style>
</x-filament-panels::page>
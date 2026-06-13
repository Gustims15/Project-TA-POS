<x-filament-panels::page>
    @php
        $role = $record;
        $role->loadMissing('permissions');

        $backUrl = \App\Filament\Admin\Resources\Roles\RoleResource::getUrl('index');
        $editUrl = \App\Filament\Admin\Resources\Roles\RoleResource::getUrl('edit', ['record' => $role]);

        $roleName = str($role->name ?? '-')->replace('_', ' ')->title()->toString();
        $guardName = $role->guard_name ?? 'web';
        $permissions = $role->permissions ?? collect();

        $cards = [
            [
                'label' => 'Nama Role',
                'value' => $roleName,
                'caption' => 'Role akses sistem',
                'icon' => '▣',
                'color' => '#f97316',
            ],
            [
                'label' => 'Guard Name',
                'value' => $guardName,
                'caption' => 'Guard role',
                'icon' => '◇',
                'color' => '#3b82f6',
            ],
            [
                'label' => 'Total Permission',
                'value' => number_format($permissions->count(), 0, ',', '.'),
                'caption' => 'Hak akses aktif',
                'icon' => '✓',
                'color' => '#10b981',
            ],
            [
                'label' => 'Update',
                'value' => $role->updated_at?->diffForHumans() ?? '-',
                'caption' => 'Terakhir diperbarui',
                'icon' => '↗',
                'color' => '#8b5cf6',
            ],
        ];
    @endphp

    <div class="ng-role-detail-page">
        <section class="ng-role-detail-hero">
            <article class="ng-role-detail-hero-main">
                <div>
                    <span class="ng-role-kicker">POS Ngunjuk</span>
                    <h1>Detail Role</h1>
                    <p>
                        Informasi lengkap role pengguna, guard, jumlah permission, dan daftar hak akses
                        yang dimiliki role ini pada sistem POS.
                    </p>
                </div>

                <div class="ng-role-hero-actions">
                    <a href="{{ $backUrl }}" class="ng-role-back-btn">
                        ← Kembali
                    </a>

                    <a href="{{ $editUrl }}" class="ng-role-edit-btn">
                        Edit Role
                    </a>
                </div>
            </article>

            <article class="ng-role-detail-profile-card">
                <div class="ng-role-avatar">
                    {{ mb_strtoupper(mb_substr($roleName, 0, 1)) }}
                </div>

                <div>
                    <span>Role Terpilih</span>
                    <strong>{{ $roleName }}</strong>
                    <small>{{ number_format($permissions->count(), 0, ',', '.') }} permission</small>
                </div>
            </article>
        </section>

        <section class="ng-role-detail-kpi-grid">
            @foreach ($cards as $card)
                <article class="ng-role-detail-kpi" style="--accent: {{ $card['color'] }};">
                    <div class="ng-role-detail-kpi-icon">
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

        <section class="ng-role-detail-grid">
            <article class="ng-role-detail-card">
                <div class="ng-role-card-head">
                    <div>
                        <h2>Informasi Role</h2>
                        <p>Ringkasan role dan konfigurasi guard.</p>
                    </div>

                    <span class="ng-guard-pill">
                        {{ $guardName }}
                    </span>
                </div>

                <div class="ng-role-info-list">
                    <div>
                        <span>Nama Role</span>
                        <strong>{{ $roleName }}</strong>
                    </div>

                    <div>
                        <span>Guard Name</span>
                        <strong>{{ $guardName }}</strong>
                    </div>

                    <div>
                        <span>Total Permission</span>
                        <strong>{{ number_format($permissions->count(), 0, ',', '.') }}</strong>
                    </div>

                    <div>
                        <span>ID Role</span>
                        <strong>#{{ $role->id }}</strong>
                    </div>

                    <div>
                        <span>Dibuat</span>
                        <strong>{{ $role->created_at?->translatedFormat('d F Y H:i') ?? '-' }}</strong>
                    </div>

                    <div>
                        <span>Terakhir Update</span>
                        <strong>{{ $role->updated_at?->translatedFormat('d F Y H:i') ?? '-' }}</strong>
                    </div>
                </div>
            </article>

            <article class="ng-role-detail-card">
                <div class="ng-role-card-head">
                    <div>
                        <h2>Access Summary</h2>
                        <p>Status kelengkapan permission role.</p>
                    </div>
                </div>

                <div class="ng-role-access-summary">
                    <div class="ng-role-big-number">
                        {{ number_format($permissions->count(), 0, ',', '.') }}
                    </div>

                    <strong>Permission Aktif</strong>

                    <span>
                        Role {{ $roleName }} memiliki {{ number_format($permissions->count(), 0, ',', '.') }} hak akses yang terhubung.
                    </span>
                </div>
            </article>
        </section>

        <section class="ng-role-detail-card ng-role-permission-card">
            <div class="ng-role-card-head">
                <div>
                    <h2>Daftar Permission</h2>
                    <p>Semua permission yang terhubung dengan role ini.</p>
                </div>

                <span class="ng-permission-count-pill">
                    {{ number_format($permissions->count(), 0, ',', '.') }} Permission
                </span>
            </div>

            <div class="ng-permission-list">
                @forelse ($permissions as $permission)
                    <div class="ng-permission-item">
                        <span>{{ $loop->iteration }}</span>

                        <strong>
                            {{ str($permission->name)->replace('_', ' ')->replace('.', ' ')->title() }}
                        </strong>

                        <small>
                            {{ $permission->name }}
                        </small>
                    </div>
                @empty
                    <div class="ng-empty-permission">
                        <strong>Belum ada permission</strong>
                        <span>Role ini belum memiliki hak akses yang terhubung.</span>
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-role-detail-page) {
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

        body:has(.ng-role-detail-page) .fi-main,
        body:has(.ng-role-detail-page) .fi-main-ctn,
        body:has(.ng-role-detail-page) .fi-page,
        body:has(.ng-role-detail-page) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-role-detail-page) .fi-page {
            padding: 0 !important;
        }

        body:has(.ng-role-detail-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-role-detail-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-role-detail-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-role-detail-page) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-role-detail-page) .fi-sidebar-item a {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-role-detail-page) .fi-sidebar-item-active a,
        body:has(.ng-role-detail-page) .fi-sidebar-item a:hover {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        .ng-role-detail-page {
            width: 100%;
            min-height: 100vh;
            padding: 18px 18px 28px;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-role-detail-page * {
            box-sizing: border-box;
        }

        .ng-role-detail-hero {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(340px, .65fr);
            gap: 12px;
            margin-bottom: 12px;
        }

        .ng-role-detail-hero-main,
        .ng-role-detail-profile-card,
        .ng-role-detail-kpi,
        .ng-role-detail-card {
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

        .ng-role-detail-hero-main {
            min-height: 126px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 20px 22px;
            border-radius: 24px;
        }

        .ng-role-kicker {
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

        .ng-role-detail-hero-main h1 {
            margin: 0;
            color: #21160d;
            font-size: 30px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .ng-role-detail-hero-main p {
            max-width: 760px;
            margin: 7px 0 0;
            color: #765d45;
            font-size: 12px;
            font-weight: 650;
            line-height: 1.5;
        }

        .ng-role-hero-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .ng-role-back-btn,
        .ng-role-edit-btn {
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

        .ng-role-back-btn {
            color: #6f5844 !important;
            background: rgba(255, 255, 255, .42);
            border: 1px solid rgba(255, 255, 255, .55);
        }

        .ng-role-edit-btn {
            color: #fff !important;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 14px 26px rgba(238, 101, 0, .26);
        }

        .ng-role-detail-profile-card {
            min-height: 126px;
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 20px 22px;
            border-radius: 24px;
        }

        .ng-role-avatar {
            width: 62px;
            height: 62px;
            display: grid;
            place-items: center;
            border-radius: 20px;
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 14px 26px rgba(238, 101, 0, .24);
            font-size: 22px;
            font-weight: 950;
        }

        .ng-role-detail-profile-card span,
        .ng-role-detail-profile-card small {
            display: block;
            color: #765d45;
            font-size: 11px;
            font-weight: 850;
        }

        .ng-role-detail-profile-card strong {
            display: block;
            margin: 7px 0;
            color: #21160d;
            font-size: 22px;
            line-height: 1.1;
            font-weight: 950;
        }

        .ng-role-detail-kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
            margin-bottom: 12px;
        }

        .ng-role-detail-kpi {
            min-height: 90px;
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 14px;
            border-radius: 20px;
        }

        .ng-role-detail-kpi-icon {
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

        .ng-role-detail-kpi span {
            display: block;
            color: #6f5946;
            font-size: 11px;
            font-weight: 900;
        }

        .ng-role-detail-kpi strong {
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

        .ng-role-detail-kpi p {
            margin: 6px 0 0;
            color: #6f5946;
            font-size: 10px;
            font-weight: 850;
        }

        .ng-role-detail-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(320px, .65fr);
            gap: 12px;
            margin-bottom: 12px;
        }

        .ng-role-detail-card {
            border-radius: 24px;
        }

        .ng-role-card-head {
            min-height: 58px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 15px 20px;
            background: rgba(255, 247, 235, .10);
            border-bottom: 1px solid rgba(114, 74, 41, .07);
        }

        .ng-role-card-head h2 {
            margin: 0;
            color: #25170d;
            font-size: 17px;
            line-height: 1.2;
            font-weight: 950;
            letter-spacing: -.03em;
        }

        .ng-role-card-head p {
            margin: 5px 0 0;
            color: #7b624c;
            font-size: 12px;
            font-weight: 750;
        }

        .ng-guard-pill,
        .ng-permission-count-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 30px;
            padding: 0 12px;
            border-radius: 999px;
            color: #c25500;
            background: rgba(249, 115, 22, .12);
            border: 1px solid rgba(249, 115, 22, .22);
            font-size: 11px;
            font-weight: 950;
            white-space: nowrap;
        }

        .ng-role-info-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            padding: 18px 20px 20px;
        }

        .ng-role-info-list div {
            min-height: 74px;
            padding: 14px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .20);
            border: 1px solid rgba(255, 255, 255, .38);
        }

        .ng-role-info-list span {
            display: block;
            color: #6f5946;
            font-size: 11px;
            font-weight: 900;
        }

        .ng-role-info-list strong {
            display: block;
            margin-top: 7px;
            color: #23160d;
            font-size: 14px;
            font-weight: 950;
            word-break: break-word;
        }

        .ng-role-access-summary {
            padding: 24px;
            text-align: center;
        }

        .ng-role-big-number {
            width: 120px;
            height: 120px;
            display: grid;
            place-items: center;
            margin: 0 auto 14px;
            border-radius: 34px;
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 18px 36px rgba(238, 101, 0, .22);
            font-size: 34px;
            font-weight: 950;
        }

        .ng-role-access-summary strong,
        .ng-role-access-summary span {
            display: block;
        }

        .ng-role-access-summary strong {
            color: #21160d;
            font-size: 18px;
            font-weight: 950;
        }

        .ng-role-access-summary span {
            max-width: 280px;
            margin: 6px auto 0;
            color: #765d45;
            font-size: 12px;
            font-weight: 750;
            line-height: 1.5;
        }

        .ng-permission-list {
            padding: 14px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }

        .ng-permission-item {
            min-height: 74px;
            display: grid;
            grid-template-columns: 34px minmax(0, 1fr);
            column-gap: 10px;
            align-items: center;
            padding: 12px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .20);
            border: 1px solid rgba(255, 255, 255, .38);
        }

        .ng-permission-item > span {
            grid-row: span 2;
            display: grid;
            place-items: center;
            width: 34px;
            height: 34px;
            border-radius: 12px;
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            font-size: 12px;
            font-weight: 950;
        }

        .ng-permission-item strong {
            color: #23160d;
            font-size: 12px;
            font-weight: 950;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .ng-permission-item small {
            color: #8b7057;
            font-size: 10px;
            font-weight: 750;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .ng-empty-permission {
            grid-column: 1 / -1;
            padding: 18px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .20);
            border: 1px solid rgba(255, 255, 255, .38);
        }

        .ng-empty-permission strong,
        .ng-empty-permission span {
            display: block;
        }

        .ng-empty-permission strong {
            color: #23160d;
            font-size: 14px;
            font-weight: 950;
        }

        .ng-empty-permission span {
            margin-top: 5px;
            color: #765d45;
            font-size: 12px;
            font-weight: 750;
        }

        @media (max-width: 1500px) {
            .ng-role-detail-hero,
            .ng-role-detail-grid {
                grid-template-columns: 1fr;
            }

            .ng-role-detail-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .ng-permission-list {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 900px) {
            .ng-role-detail-page {
                padding: 14px;
            }

            .ng-role-detail-hero-main {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-role-detail-kpi-grid,
            .ng-role-info-list,
            .ng-permission-list {
                grid-template-columns: 1fr;
            }
        }
    </style>
</x-filament-panels::page>
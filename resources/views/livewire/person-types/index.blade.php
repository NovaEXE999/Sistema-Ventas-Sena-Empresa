<div class="persontypes-scope flex h-full w-full flex-1 flex-col gap-4 rounded-xl p-4 sm:p-6">
    <style>
        .persontypes-scope {
            --sena-green-600: #0E7A3B;
            --sena-green-500: #1AA855;
            --sena-green-300: #43C678;
            --accent-amber: #F6A300;
            --accent-cyan: #2EC7D6;
            --error: #E5484D;
            --warning: #F6A300;
            --success: #1AA855;

            background: var(--surface);
            color: var(--text);
            border-radius: 16px;
            box-shadow: var(--shadow);
        }

        [data-theme="light"] .persontypes-scope,
        .theme-light .persontypes-scope {
            --surface: #FFFFFF;
            --surface-2: #F5F7F9;
            --text: #0E1420;
            --muted: #4A5568;
            --border: #E2E8F0;
            --shadow: 0 8px 24px -12px rgba(14, 20, 32, 0.18);
        }

        [data-theme="dark"] .persontypes-scope,
        .theme-dark .persontypes-scope {
            --surface: #0F1720;
            --surface-2: #121C27;
            --text: #E6EDF3;
            --muted: #8BA0B5;
            --border: rgba(255, 255, 255, 0.08);
            --shadow: 0 12px 36px -18px rgba(0, 0, 0, 0.6);
            color-scheme: dark;
        }

        .persontypes-muted {
            color: var(--muted);
        }

        .btn-primary {
            background: var(--sena-green-500);
            border-radius: 12px;
            border: 1px solid var(--sena-green-500);
            color: #FFFFFF;
            font-size: 0.85rem;
            font-weight: 700;
            padding: 8px 14px;
            box-shadow: 0 12px 22px -14px rgba(26, 168, 85, 0.7);
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            transition: transform 0.15s ease, filter 0.15s ease, box-shadow 0.15s ease;
            white-space: nowrap;
        }

        .btn-primary:hover {
            filter: brightness(1.03);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: var(--surface-2);
            border-radius: 10px;
            border: 1px solid var(--border);
            color: var(--text);
            font-size: 0.75rem;
            font-weight: 600;
            padding: 6px 10px;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            transition: background 0.15s ease, border-color 0.15s ease, transform 0.12s ease;
        }

        .btn-secondary:hover {
            background: rgba(26, 168, 85, 0.08);
            border-color: rgba(26, 168, 85, 0.45);
        }

        .btn-danger {
            background: var(--error);
            border-radius: 10px;
            border: 1px solid var(--error);
            color: #FFFFFF;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 6px 10px;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            transition: filter 0.15s ease, transform 0.12s ease;
        }

        .btn-danger:hover {
            filter: brightness(1.05);
            transform: translateY(-1px);
        }

        .btn-success {
            background: var(--success);
            border-radius: 10px;
            border: 1px solid var(--success);
            color: #FFFFFF;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 6px 10px;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            transition: filter 0.15s ease, transform 0.12s ease;
        }

        .btn-success:hover {
            filter: brightness(1.05);
            transform: translateY(-1px);
        }

        .persontypes-alert {
            border-radius: 14px;
            border: 1px solid rgba(26, 168, 85, 0.45);
            background: rgba(26, 168, 85, 0.08);
            color: var(--text);
            box-shadow: 0 10px 24px -14px rgba(26, 168, 85, 0.35);
            overflow: hidden;
        }

        .persontypes-alert-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
        }

        .persontypes-alert-icon {
            background: linear-gradient(135deg, var(--sena-green-500), var(--accent-cyan));
            color: #FFFFFF;
            border-radius: 9999px;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 24px -14px rgba(26, 168, 85, 0.65);
        }

        .persontypes-alert-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--sena-green-500);
        }

        .persontypes-alert-text {
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text);
        }

        .persontypes-table-wrapper {
            border-radius: 16px;
            border: 1px solid var(--border);
            overflow: hidden;
            background: var(--surface-2);
        }

        .persontypes-table-title {
            text-align: center;
            padding: 0.75rem 1rem;
            font-weight: 700;
            font-size: 0.9rem;
            color: #ffffff;
            background: var(--sena-green-500);
        }

        .persontypes-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
            color: var(--text);
        }

        .persontypes-table thead th {
            padding: 0.75rem 1rem;
            text-align: left;
            font-weight: 700;
            font-size: 0.8rem;
            color: var(--muted);
            background: rgba(26, 168, 85, 0.08);
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .persontypes-table tbody td {
            padding: 0.75rem 1rem;
            border-top: 1px solid var(--border);
            vertical-align: middle;
        }

        .persontypes-table tbody tr:first-child td {
            border-top: none;
        }

        .persontypes-table tbody tr:nth-child(even) {
            background: rgba(14, 122, 59, 0.03);
        }

        [data-theme="dark"] .persontypes-scope .persontypes-table tbody tr:nth-child(even),
        .theme-dark .persontypes-scope .persontypes-table tbody tr:nth-child(even) {
            background: rgba(14, 122, 59, 0.05);
        }

        .persontypes-table tbody tr:hover {
            background: rgba(26, 168, 85, 0.10);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            border-radius: 9999px;
            padding: 4px 10px;
            font-size: 0.7rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .badge-status-active {
            background: rgba(26, 168, 85, 0.14);
            color: #0E7A3B;
            border: 1px solid rgba(26, 168, 85, 0.4);
        }

        .badge-status-inactive {
            background: rgba(229, 72, 77, 0.14);
            color: #B4232A;
            border: 1px solid rgba(229, 72, 77, 0.4);
        }
    </style>

    @if (session('success'))
        <div
            x-data="{ alertIsVisible: true }"
            x-show="alertIsVisible"
            class="persontypes-alert"
            role="alert"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
        >
            <div class="persontypes-alert-header">
                <div class="persontypes-alert-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="flex flex-col gap-0.5">
                    <h3 class="persontypes-alert-title">Mensajes de Tipos de personas</h3>
                    <p class="persontypes-alert-text">{{ session('success') }}</p>
                </div>
                <button
                    type="button"
                    @click="alertIsVisible = false"
                    class="ml-auto btn-secondary"
                    aria-label="dismiss alert"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="2" class="w-4 h-4 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cerrar
                </button>
            </div>
        </div>
    @endif

    @php($isAdmin = auth()->user()?->isAdmin())

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-start">
        @if ($isAdmin)
            <a href="{{ route('persontypes.create') }}" wire:navigate class="btn-primary" role="button">
                Registrar un tipo de persona
            </a>
        @endif
    </div>

    <div class="persontypes-table-wrapper w-full">
        <h2 class="persontypes-table-title">Tipos de persona</h2>

        <div class="overflow-x-auto">
            <table class="persontypes-table">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Estado</th>
                    @if ($isAdmin)
                        <th scope="col" class="text-center">Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($persontypes as $persontype)
                    <tr>
                        <td>{{ $persontype->name }}</td>
                        <td>
                            <span class="badge {{ $persontype->status ? 'badge-status-active' : 'badge-status-inactive' }}">
                                {{ $persontype->status ? 'Activa' : 'Inactiva' }}
                            </span>
                        </td>

                        @if ($isAdmin)
                            <td class="text-center">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="{{ route('persontypes.update', $persontype) }}" wire:navigate>
                                        <button type="button" class="btn-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                            </svg>
                                            Editar
                                        </button>
                                    </a>

                                    @if ($persontype->status)
                                        <button
                                            wire:click="toggleStatus({{ $persontype->id }})"
                                            wire:confirm="¿Estás seguro de inhabilitar el tipo de persona {{ $persontype->name }}?"
                                            type="button"
                                            class="btn-danger"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                            Inhabilitar
                                        </button>
                                    @else
                                        <button
                                            wire:click="toggleStatus({{ $persontype->id }})"
                                            wire:confirm="¿Estás seguro de habilitar el tipo de persona {{ $persontype->name }}?"
                                            type="button"
                                            class="btn-success"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                                            </svg>
                                            Habilitar
                                        </button>
                                    @endif
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $isAdmin ? 3 : 2 }}" class="persontypes-muted text-center py-4">
                            No hay tipos de personas registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
        <div class="p-4">
            {{ $persontypes->links() }}
        </div>
    </div>
</div>

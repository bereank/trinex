<x-filament::card class="shadow-sm border border-gray-200/70">
    <div class="overflow-x-auto">
        <table class="filament-tables-table w-full min-w-max divide-y divide-gray-100">
            <thead>
                <tr class="bg-gray-50/70">
                    <th class="filament-tables-header-cell px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Step
                    </th>
                    <th class="filament-tables-header-cell px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Approver
                    </th>
                    <th class="filament-tables-header-cell px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Status
                    </th>
                    <th class="filament-tables-header-cell px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Comment
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($details as $detail)
                    <tr class="hover:bg-gray-50/60 transition-colors duration-150">
                        <td class="px-5 py-3.5 text-sm text-gray-700 font-medium">
                            {{ $detail->approvalstage?->Name ?? '—' }}
                        </td>

                        <td class="px-5 py-3.5 text-sm text-gray-700">
                            {{ $detail->authorizer->name ?? '—' }}
                        </td>

                        <td class="px-5 py-3.5 whitespace-nowrap">
                            @php
                                $statusMap = [
                                    'Y'     => ['label' => 'Approved',  'color' => 'success'],
                                    'N'     => ['label' => 'Rejected',  'color' => 'danger'],
                                    null    => ['label' => 'Pending',   'color' => 'warning'],
                                    'W'     => ['label' => 'Pending',   'color' => 'warning'],
                                ];

                                $status = $statusMap[$detail->Status ?? null] ?? ['label' => 'Unknown', 'color' => 'gray'];
                            @endphp

                            <x-filament::badge 
                                :color="$status['color']"
                                size="sm"
                            >
                                {{ $status['label'] }}
                            </x-filament::badge>
                        </td>

                        <td class="px-5 py-3.5 text-sm text-gray-600 max-w-xl">
                            @if($detail->Remarks)
                                <div 
                                    class="whitespace-pre-line line-clamp-2 hover:line-clamp-none transition-all duration-200 cursor-help group relative"
                                    title="{{ $detail->Remarks }}"
                                >
                                    {{ Str::limit($detail->Remarks, 90) }}

                                    @if(strlen($detail->Remarks) > 90)
                                        <span class="absolute bottom-0 right-0 bg-gradient-to-l from-white via-white to-transparent pl-8 pointer-events-none group-hover:opacity-0 transition-opacity">
                                            ...
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span class="text-gray-400 italic text-xs">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-10 text-center text-gray-500 text-sm italic">
                            No approval steps recorded yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-filament::card>
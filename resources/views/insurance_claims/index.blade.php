<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Insurance Claim Approval') }}
        </h2>
    </x-slot>
    // Insurance Claim Approval/Rejection Buttons in View (resources/views/insurance_claims/index.blade.php)

    @foreach($claims as $claim)
    <tr class="flex flex-col sm:table-row mb-4 sm:mb-0 border-b">
        <td class="sm:border px-4 py-2">{{ $claim->first_name }}</td>
        <td class="sm:border px-4 py-2">{{ $claim->insurance_provider }}</td>
        <td class="sm:border px-4 py-2">{{ $claim->insurance_number }}</td>
        <td class="sm:border px-4 py-2">{{ $claim->status }}</td>
        <td class="sm:border px-4 py-2">
            @if($claim->status === 'pending')
                <form action="{{ route('insurance-claims.approve', $claim) }}" method="POST" class="inline">
                    @csrf @method('PUT')
                    <button class="bg-green-500 text-white px-2 py-1 rounded text-sm sm:text-base">Approve</button>
                </form>
                <form action="{{ route('insurance-claims.reject', $claim) }}" method="POST" class="inline ml-2">
                    @csrf @method('PUT')
                    <button class="bg-red-500 text-white px-2 py-1 rounded text-sm sm:text-base">Reject</button>
                </form>
            @else
                <span class="text-gray-600 italic">{{ ucfirst($claim->status) }}</span>
            @endif
        </td>
    </tr>
    @endforeach
</x-app-layout>
@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <!-- Page Title and Actions -->
        <div class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ __('Laporan Pengeluaran') }}</h1>
                    <p class="text-gray-600 mt-1">{{ __('Laporan biaya dari penggunaan bahan dan material') }}</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('admin.laporan_keuangan.pengeluaran.export', ['tanggal_dari' => $startDate, 'tanggal_sampai' => $endDate]) }}" 
                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        {{ __('Export Excel') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <form method="GET" action="{{ route('admin.laporan_keuangan.pengeluaran') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Tanggal Dari') }}</label>
                    <input type="date" name="tanggal_dari" value="{{ $startDate }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Tanggal Sampai') }}</label>
                    <input type="date" name="tanggal_sampai" value="{{ $endDate }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200">
                        {{ __('Filter') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <!-- Card Total Pengeluaran -->
            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-md p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm font-semibold">{{ __('Total Pengeluaran Bahan') }}</p>
                        <p class="text-3xl font-bold mt-2">Rp {{ number_format($totalPenggunaanBahan, 0, ',', '.') }}</p>
                        <p class="text-red-100 text-xs mt-1">{{ $startDateParsed->format('d M Y') }} - {{ $endDateParsed->format('d M Y') }}</p>
                    </div>
                    <div class="text-red-100">
                        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M19.5 10a.5.5 0 00-.5-.5h-3.793l1.148-1.148a.5.5 0 00-.707-.707l-2 2a.5.5 0 000 .707l2 2a.5.5 0 00.707-.707L15.207 10.5H19a.5.5 0 00.5-.5z" clip-rule="evenodd"></path>
                            <path fill-rule="evenodd" d="M11 3a1 1 0 10-2 0 1 1 0 002 0zM8 5a3 3 0 11-6 0 3 3 0 016 0zM14.5 9a.5.5 0 100-1 .5.5 0 000 1zM2 13a6 6 0 1112 0 6 6 0 01-12 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Card Kategori Terbanyak -->
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-md p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-semibold">{{ __('Jumlah Item Pengeluaran') }}</p>
                        <p class="text-3xl font-bold mt-2">{{ $expensesByCategory->count() }}</p>
                        <p class="text-orange-100 text-xs mt-1">{{ __('jenis bahan yang digunakan') }}</p>
                    </div>
                    <div class="text-orange-100">
                        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path>
                            <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary by Category -->
        @if($expensesByCategory->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Expense By Category -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('Pengeluaran Berdasarkan Kategori') }}</h3>
                <div class="space-y-3">
                    @foreach($expensesByCategory as $category)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="flex-1">
                                <p class="font-medium text-gray-700">{{ $category['kategori'] }}</p>
                                <p class="text-xs text-gray-500">{{ $category['jumlah_item'] }} item</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-900">Rp {{ number_format($category['total'], 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ round(($category['total'] / $totalPenggunaanBahan) * 100) }}%
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Category Distribution Chart -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('Distribusi Pengeluaran') }}</h3>
                <div class="space-y-4">
                    @foreach($expensesByCategory as $category)
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">{{ substr($category['kategori'], 0, 20) }}...</span>
                                <span class="text-sm text-gray-500">{{ round(($category['total'] / $totalPenggunaanBahan) * 100) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-gradient-to-r from-red-500 to-red-600 h-2.5 rounded-full" 
                                     style="width: {{ round(($category['total'] / $totalPenggunaanBahan) * 100) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Expense Details Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">{{ __('Detail Pengeluaran') }}</h3>
            </div>
            
            @if($allExpenses->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __('Tanggal') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __('Kategori Bahan') }}</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __('Jumlah') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __('Total Biaya (Rp)') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($allExpenses as $item)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ \Carbon\Carbon::parse($item['tanggal'])->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                            {{ $item['kategori'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm text-gray-700">
                                        {{ number_format($item['jumlah'], 2, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-semibold text-gray-900">
                                        Rp {{ number_format($item['total'], 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 border-t-2 border-gray-300">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-800">{{ __('TOTAL PENGELUARAN') }}</td>
                                <td class="px-6 py-4 text-right text-lg font-bold text-red-600">
                                    Rp {{ number_format($totalPenggunaanBahan, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <p class="mt-4 text-gray-500 text-lg">{{ __('Tidak ada data pengeluaran untuk periode ini') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

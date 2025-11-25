@extends('layouts.app')

@section('title', 'Manajemen Pengrajin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                    <div class="flex items-center">
                        {{-- Ikon Pengrajin --}}
                        <div class="bg-gradient-to-r from-teal-500 to-cyan-500 p-2 rounded-lg mr-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h2a2 2 0 002-2V8a2 2 0 00-2-2h-2M9 16a2 2 0 11-4 0 2 2 0 014 0zM12 21h4m-4 0v-4a2 2 0 012-2h2a2 2 0 012 2v4m-4-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2h4a2 2 0 002-2v-4z"/>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900">Manajemen Pengrajin</h1>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <a href="{{ route('admin.pengrajin.create') }}"
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Pengrajin
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Notifications --}}
        @if (Session::has('success'))
            <div class="mb-6">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-400 p-4 rounded-lg shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                <strong>Berhasil!</strong> {{ Session::get('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (Session::has('error'))
            <div class="mb-6">
                <div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">
                                <strong>Gagal!</strong> {{ Session::get('error') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Live Filter Section --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 mb-6">
            <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                {{-- Live Search --}}
                <div class="relative w-full sm:w-64">
                    <input type="text" id="liveSearch" placeholder="Cari nama atau kode pengrajin..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                {{-- Live Status Filter --}}
                <select id="statusFilter" class="w-full sm:w-48 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                    <option value="">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="non-aktif">Non-Aktif</option>
                </select>

                {{-- Clear Filters --}}
                <button id="clearFilters" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors duration-200">
                    <svg class="h-4 w-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Clear
                </button>
            </div>

            {{-- Results Info --}}
            <div class="mt-4 text-sm text-gray-600">
                Menampilkan <span id="visibleCount">0</span> dari <span id="totalCount">0</span> pengrajin
                <span id="filteredInfo" class="hidden text-blue-600 font-medium"></span>
            </div>
        </div>

        {{-- Main Content Card --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="pengrajinTable">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tl-lg cursor-pointer hover:bg-gray-100" onclick="sortTable(0)">
                                No
                                <span class="sort-indicator ml-1 text-gray-400">↕</span>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer hover:bg-gray-100" onclick="sortTable(1)">
                                Kode Pengrajin
                                <span class="sort-indicator ml-1 text-gray-400">↕</span>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer hover:bg-gray-100" onclick="sortTable(2)">
                                Nama Pengrajin
                                <span class="sort-indicator ml-1 text-gray-400">↕</span>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer hover:bg-gray-100" onclick="sortTable(3)">
                                Telepon
                                <span class="sort-indicator ml-1 text-gray-400">↕</span>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer hover:bg-gray-100" onclick="sortTable(4)">
                                Status
                                <span class="sort-indicator ml-1 text-gray-400">↕</span>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tr-lg">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                        @forelse ($pengrajins as $pengrajin)
                            <tr class="hover:bg-gray-50 transition duration-150 ease-in-out table-row" 
                                data-name="{{ strtolower($pengrajin->nama_pengrajin) }}"
                                data-code="{{ strtolower($pengrajin->kode_pengrajin) }}"
                                data-status="{{ $pengrajin->is_active ? 'aktif' : 'non-aktif' }}"
                                data-phone="{{ strtolower($pengrajin->telepon ?? '-') }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $pengrajin->kode_pengrajin }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $pengrajin->nama_pengrajin }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $pengrajin->telepon ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <form action="{{ route('admin.pengrajin.toggleStatus', $pengrajin->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $pengrajin->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}
                                            transition duration-150 ease-in-out">
                                            {{ $pengrajin->is_active ? 'Aktif' : 'Non-Aktif' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.pengrajin.edit', $pengrajin->id) }}" class="text-blue-600 hover:text-blue-900 mr-4 transition duration-150 ease-in-out">Edit</a>
                                    <form action="{{ route('admin.pengrajin.destroy', $pengrajin->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengrajin ini? Aksi ini tidak dapat dibatalkan!');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition duration-150 ease-in-out">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr id="noDataRow">
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    Belum ada data pengrajin.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- No Results Message --}}
            <div id="noResultsMessage" class="hidden text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada hasil ditemukan</h3>
                <p class="mt-1 text-sm text-gray-500">Coba ubah filter atau kata kunci pencarian Anda.</p>
            </div>
        </div>
    </div>
</div>

{{-- Live Table JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('liveSearch');
    const statusFilter = document.getElementById('statusFilter');
    const clearButton = document.getElementById('clearFilters');
    const tableRows = document.querySelectorAll('.table-row');
    const noResultsMessage = document.getElementById('noResultsMessage');
    const table = document.getElementById('pengrajinTable');
    const visibleCountSpan = document.getElementById('visibleCount');
    const totalCountSpan = document.getElementById('totalCount');
    const filteredInfo = document.getElementById('filteredInfo');
    
    let currentSort = { column: -1, direction: 'asc' };
    
    // Set initial counts
    totalCountSpan.textContent = tableRows.length;
    updateVisibleCount();

    // Live search functionality
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const statusValue = statusFilter.value.toLowerCase();
        let visibleRows = 0;
        let hasVisibleRows = false;

        tableRows.forEach(row => {
            const name = row.getAttribute('data-name');
            const code = row.getAttribute('data-code');
            const status = row.getAttribute('data-status');
            const phone = row.getAttribute('data-phone');
            
            let matchesSearch = true;
            let matchesStatus = true;

            // Check search term
            if (searchTerm) {
                matchesSearch = name.includes(searchTerm) || 
                               code.includes(searchTerm) ||
                               phone.includes(searchTerm);
            }

            // Check status filter
            if (statusValue) {
                matchesStatus = status === statusValue;
            }

            // Show/hide row
            if (matchesSearch && matchesStatus) {
                row.style.display = '';
                visibleRows++;
                hasVisibleRows = true;
                
                // Update row number
                const firstCell = row.querySelector('td:first-child');
                firstCell.textContent = visibleRows;
            } else {
                row.style.display = 'none';
            }
        });

        // Show/hide no results message
        if (hasVisibleRows) {
            noResultsMessage.classList.add('hidden');
            table.style.display = '';
        } else {
            noResultsMessage.classList.remove('hidden');
            table.style.display = 'none';
        }

        updateVisibleCount();
        updateFilterInfo();
    }

    function updateVisibleCount() {
        const visibleRows = document.querySelectorAll('.table-row[style=""], .table-row:not([style])').length;
        visibleCountSpan.textContent = visibleRows;
    }

    function updateFilterInfo() {
        const searchTerm = searchInput.value.trim();
        const statusValue = statusFilter.value;
        const hasFilters = searchTerm || statusValue;

        if (hasFilters) {
            let filterText = 'Filter aktif: ';
            const filters = [];
            
            if (searchTerm) filters.push(`pencarian "${searchTerm}"`);
            if (statusValue) filters.push(`status ${statusValue}`);
            
            filterText += filters.join(', ');
            filteredInfo.textContent = filterText;
            filteredInfo.classList.remove('hidden');
        } else {
            filteredInfo.classList.add('hidden');
        }
    }

    // Event listeners
    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);

    // Clear filters
    clearButton.addEventListener('click', function() {
        searchInput.value = '';
        statusFilter.value = '';
        filterTable();
    });

    // Sorting functionality
    window.sortTable = function(columnIndex) {
        const tbody = document.getElementById('tableBody');
        const rows = Array.from(tableRows);
        const isNumeric = columnIndex === 0; // Only first column (No) is numeric
        
        // Determine sort direction
        if (currentSort.column === columnIndex) {
            currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
        } else {
            currentSort.direction = 'asc';
        }
        currentSort.column = columnIndex;

        // Sort rows
        rows.sort((a, b) => {
            let aVal = a.children[columnIndex].textContent.trim();
            let bVal = b.children[columnIndex].textContent.trim();

            if (isNumeric) {
                aVal = parseInt(aVal) || 0;
                bVal = parseInt(bVal) || 0;
            } else {
                aVal = aVal.toLowerCase();
                bVal = bVal.toLowerCase();
            }

            if (currentSort.direction === 'asc') {
                return aVal > bVal ? 1 : aVal < bVal ? -1 : 0;
            } else {
                return aVal < bVal ? 1 : aVal > bVal ? -1 : 0;
            }
        });

        // Update sort indicators
        document.querySelectorAll('.sort-indicator').forEach((indicator, index) => {
            if (index === columnIndex) {
                indicator.textContent = currentSort.direction === 'asc' ? '↑' : '↓';
                indicator.classList.remove('text-gray-400');
                indicator.classList.add('text-blue-600');
            } else {
                indicator.textContent = '↕';
                indicator.classList.remove('text-blue-600');
                indicator.classList.add('text-gray-400');
            }
        });

        // Reorder DOM elements
        rows.forEach(row => tbody.appendChild(row));
        
        // Update row numbers and reapply filters
        filterTable();
    };

    // Add smooth transitions
    const style = document.createElement('style');
    style.textContent = `
        .table-row {
            transition: opacity 0.2s ease-in-out, transform 0.2s ease-in-out;
        }
        .table-row[style*="none"] {
            opacity: 0;
            transform: scale(0.95);
        }
    `;
    document.head.appendChild(style);
});
</script>
@endsection
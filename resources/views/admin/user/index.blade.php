@extends('layouts.app')

@section('title', 'Manajemen User')

@push('styles')
<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.tailwindcss.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
<!-- SweetAlert2 -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-lg">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h2 class="text-2xl font-bold text-gray-900">Manajemen User</h2>
                <div class="flex flex-col sm:flex-row gap-2">
                    <button id="bulkActionBtn"
                        class="hidden px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition duration-200">
                        <i class="fas fa-tasks mr-2"></i>Bulk Action
                    </button>
                    <button id="refreshBtn"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">
                        <i class="fas fa-sync-alt mr-2"></i>Refresh
                    </button>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <!-- Filter Controls -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter Status</label>
                    <select id="statusFilter"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Semua Status</option>
                        <option value="1">Aktif</option>
                        <option value="0">Non-Aktif</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter Role</label>
                    <select id="roleFilter"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Semua Role</option>
                        <option value="admin">Admin</option>
                        <option value="client">Client</option>
                        <option value="kasir">Kasir</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Entries per Page</label>
                    <select id="lengthMenu"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table id="usersTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Bergabung</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50" data-user-id="{{ $user->id }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                @if($user->username)
                                <div class="text-sm text-gray-500">{{ $user->username }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($user->role == 'admin') bg-red-100 text-red-800 
                                    @elseif($user->role == 'client') bg-blue-100 text-blue-800 
                                    @elseif($user->role == 'kasir') bg-green-100 text-green-800 
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($user->role ?? 'User') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer status-toggle"
                                        data-user-id="{{ $user->id }}" {{ $user->is_active ? 'checked' : '' }}>
                                    <div
                                        class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                </label>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->format('d M Y') }}
                                <div class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button class="view-user text-blue-600 hover:text-blue-900"
                                        data-user-id="{{ $user->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="edit-user text-indigo-600 hover:text-indigo-900"
                                        data-user-id="{{ $user->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="delete-user text-red-600 hover:text-red-900"
                                        data-user-id="{{ $user->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination & Info -->
            <div
                class="flex flex-col sm:flex-row justify-between items-center mt-4 px-4 py-3 bg-gray-50 border-t border-gray-200">
                <div class="text-sm text-gray-700 mb-2 sm:mb-0">
                    Menampilkan {{ $users->firstItem() ?? 0 }} sampai {{ $users->lastItem() ?? 0 }} dari
                    {{ $users->total() }} entries
                </div>
                <div class="pagination-wrapper">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View User Modal -->
<div id="viewUserModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Detail User</h3>
                <button class="close-modal text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="userDetailContent" class="text-center">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div id="editUserModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Edit User</h3>
                <button class="close-modal text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editUserForm">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" id="editName" name="name"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="editEmail" name="email"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Role</label>
                        <select id="editRole" name="role"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                            <option value="user">User</option>
                            <option value="client">Client</option>
                            <option value="kasir">Kasir</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="flex items-center justify-between pt-4">
                        <button type="button"
                            class="close-modal px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function () {
        // Initialize DataTable with custom info display
        let table = $('#usersTable').DataTable({
            responsive: true,
            paging: false, // Disable DataTables pagination since we're using Laravel pagination
            info: false, // Disable default info
            lengthChange: false, // Disable length menu since we're using custom
            // Fixed DOM configuration to show search bar
            dom: '<"flex flex-col md:flex-row md:items-center md:justify-between mb-4"<"mb-2 md:mb-0"><"mb-2 md:mb-0"f>>rt',
            language: {
                search: "",
                searchPlaceholder: "Cari user...",
                zeroRecords: "Tidak ada data yang ditemukan",
                emptyTable: "Tidak ada data tersedia"
            },
            // Fixed column definitions to match actual table structure (6 columns: 0-5)
            columnDefs: [{
                    orderable: false,
                    targets: [3, 5]
                }, // Disable sorting for status toggle and actions
                {
                    searchable: false,
                    targets: [3, 5]
                } // Disable search for status toggle and actions
            ],
            order: [
                [0, 'asc']
            ], // Sort by name by default
            drawCallback: function () {
                // Re-bind events after table redraw
                bindEvents();
            }
        });

        // Style the search input
        $('div.dataTables_filter input').addClass(
            'px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500');
        $('div.dataTables_filter input').attr('placeholder', 'Cari user...');

        // Custom filters
        $('#statusFilter').on('change', function () {
            let value = this.value;
            if (value === '1') {
                table.column(3).search('checked', true, false).draw();
            } else if (value === '0') {
                table.column(3).search('^((?!checked).)*$', true, false).draw();
            } else {
                table.column(3).search('').draw();
            }
        });

        $('#roleFilter').on('change', function () {
            table.column(2).search(this.value).draw();
        });

        // Refresh button - since this is static data, just reload the page
        $('#refreshBtn').on('click', function () {
            location.reload();
        });

        // Select all checkbox functionality (if you add checkboxes later)
        $(document).on('change', '#selectAll', function () {
            $('.user-checkbox').prop('checked', this.checked);
            toggleBulkActions();
        });

        // Individual checkbox
        $(document).on('click', '.user-checkbox', function () {
            let totalCheckboxes = $('.user-checkbox').length;
            let checkedCheckboxes = $('.user-checkbox:checked').length;

            $('#selectAll').prop('checked', totalCheckboxes === checkedCheckboxes);
            toggleBulkActions();
        });

        // Toggle bulk actions
        function toggleBulkActions() {
            let checkedBoxes = $('.user-checkbox:checked').length;
            if (checkedBoxes > 0) {
                $('#bulkActionBtn').removeClass('hidden');
            } else {
                $('#bulkActionBtn').addClass('hidden');
            }
        }

        // Status toggle
        function bindEvents() {
            $('.status-toggle').off('change').on('change', function () {
                let userId = $(this).data('user-id');
                let isActive = $(this).prop('checked');

                updateUserStatus(userId, isActive);
            });

            // View user
            $('.view-user').off('click').on('click', function () {
                let userId = $(this).data('user-id');
                viewUser(userId);
            });

            // Edit user
            $('.edit-user').off('click').on('click', function () {
                let userId = $(this).data('user-id');
                editUser(userId);
            });

            // Delete user
            $('.delete-user').off('click').on('click', function () {
                let userId = $(this).data('user-id');
                deleteUser(userId);
            });
        }

        // Initial bind
        bindEvents();

        // Update user status
        function updateUserStatus(userId, isActive) {
            fetch(`/user/${userId}/is-active`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        is_active: isActive
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) { // Periksa success yang dikirimkan dari Laravel
                        showToast('success', `User ${isActive ? 'diaktifkan' : 'dinonaktifkan'} berhasil`);
                    } else {
                        showToast('error', data.message || 'Gagal mengubah status user');
                        // Revert toggle if failed
                        $(`.status-toggle[data-user-id="${userId}"]`).prop('checked', !isActive);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('error', 'Terjadi kesalahan');
                    // Revert toggle if failed
                    $(`.status-toggle[data-user-id="${userId}"]`).prop('checked', !isActive);
                });
        }


        // View user
        function viewUser(userId) {
            fetch(`/admin/users/${userId}`)
                .then(response => response.json())
                .then(user => {
                    let avatarHtml = user.avatar ?
                        `<img class="h-20 w-20 rounded-full mx-auto mb-4 object-cover" src="/storage/${user.avatar}" alt="Avatar">` :
                        `<div class="h-20 w-20 rounded-full bg-gray-300 flex items-center justify-center mx-auto mb-4">
                     <i class="fas fa-user text-gray-600 text-2xl"></i>
                   </div>`;

                    let statusBadge = user.is_active ?
                        '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>' :
                        '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Non-Aktif</span>';

                    let roleBadge = user.role == 'admin' ?
                        '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Admin</span>' :
                        user.role == 'client' ?
                        '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Client</span>' :
                        user.role == 'kasir' ?
                        '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Kasir</span>' :
                        '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">User</span>';

                    $('#userDetailContent').html(`
                ${avatarHtml}
                <h4 class="text-xl font-bold text-gray-900 mb-2">${user.name}</h4>
                <p class="text-gray-600 mb-4">${user.email}</p>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="font-medium">Role:</span>
                        ${roleBadge}
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">Status:</span>
                        ${statusBadge}
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">Bergabung:</span>
                        <span>${new Date(user.created_at).toLocaleDateString('id-ID')}</span>
                    </div>
                    ${user.username ? `
                    <div class="flex justify-between">
                        <span class="font-medium">Username:</span>
                        <span>${user.username}</span>
                    </div>
                    ` : ''}
                </div>
            `);

                    $('#viewUserModal').removeClass('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('error', 'Gagal mengambil data user');
                });
        }

        // Edit user
        function editUser(userId) {
            fetch(`/admin/users/${userId}`)
                .then(response => response.json())
                .then(user => {
                    $('#editName').val(user.name);
                    $('#editEmail').val(user.email);
                    $('#editRole').val(user.role || 'user');
                    $('#editUserForm').data('user-id', userId);
                    $('#editUserModal').removeClass('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('error', 'Gagal mengambil data user');
                });
        }

        // Delete user
        function deleteUser(userId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data user akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/users/${userId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                $(`tr[data-user-id="${userId}"]`).fadeOut(() => {
                                    table.row($(`tr[data-user-id="${userId}"]`)).remove()
                                        .draw();
                                });
                                showToast('success', 'User berhasil dihapus');
                            } else {
                                showToast('error', data.message || 'Gagal menghapus user');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('error', 'Terjadi kesalahan');
                        });
                }
            });
        }

        // Edit form submission
        $('#editUserForm').on('submit', function (e) {
            e.preventDefault();
            let userId = $(this).data('user-id');
            let formData = new FormData(this);

            fetch(`/admin/users/${userId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        $('#editUserModal').addClass('hidden');
                        location.reload(); // Reload to update the table
                        showToast('success', 'User berhasil diupdate');
                    } else {
                        showToast('error', data.message || 'Gagal mengupdate user');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('error', 'Terjadi kesalahan');
                });
        });

        // Close modal
        $('.close-modal').on('click', function () {
            $('#viewUserModal, #editUserModal').addClass('hidden');
        });

        // Close modal when clicking outside
        $(window).on('click', function (e) {
            if (e.target.id === 'viewUserModal' || e.target.id === 'editUserModal') {
                $('#viewUserModal, #editUserModal').addClass('hidden');
            }
        });

        // Toast notification
        function showToast(type, message) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            Toast.fire({
                icon: type,
                title: message
            });
        }
    });

</script>
@endpush

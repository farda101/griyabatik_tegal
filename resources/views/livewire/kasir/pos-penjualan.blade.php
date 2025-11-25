<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center">
                    {{-- Ikon POS Kasir --}}
                    <div class="bg-gradient-to-r from-teal-500 to-blue-500 p-2 rounded-lg mr-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">POS Kasir</h1>
                </div>
                <p class="text-gray-600 mt-2 ml-12">Lakukan transaksi penjualan batik dengan cepat dan mudah.</p>
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
        {{-- Notifikasi Validasi Livewire --}}
        @if ($errors->any())
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
                                <strong>Perhatian!</strong> Ada beberapa masalah validasi:
                            </p>
                            <ul class="mt-1 list-disc list-inside text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Bagian Kiri: Input Produk dan Keranjang --}}
            <div class="md:col-span-2 bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="mb-6">
                    <h3 class="font-bold text-xl text-gray-900 mb-4 pb-2 border-b-2 border-indigo-200 flex items-center">
                        <svg class="h-6 w-6 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Scan QR Code / Input Produk
                    </h3>
                    
                    {{-- QR Scanner Section --}}
                    <div class="mb-4 p-4 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                        <div class="text-center">
                            <button id="startQrScan" type="button"
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200 mb-3">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M12 12h-4.01M7 8h2m1-4H8a4 4 0 00-4 4v1h4V8z"/>
                                </svg>
                                <span id="scanButtonText">Scan QR Code</span>
                            </button>
                            <div id="qrReader" class="hidden">
                                <video id="qrVideo" class="w-full max-w-md mx-auto rounded-lg shadow-lg"></video>
                                <button id="stopQrScan" type="button"
                                    class="mt-3 inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition duration-200">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Stop Scan
                                </button>
                            </div>
                            <p class="text-sm text-gray-600 mt-2">
                                <svg class="h-4 w-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Arahkan kamera HP ke QR Code produk batik
                            </p>
                        </div>
                    </div>

                    {{-- Manual Input Section --}}
                    <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-3">
                        <input type="text" wire:model.live.debounce.300ms="searchBatik" id="manualInput"
                            placeholder="Atau masukkan kode batik manual"
                            class="flex-grow rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                            @error('searchBatik') border-red-500 @enderror"
                            wire:keydown.enter="searchAndAddBatik"
                        >
                        <input type="number" wire:model.live="qtyToAdd" min="1"
                            class="w-full sm:w-20 rounded-lg border-gray-300 shadow-sm sm:text-sm text-center p-2.5"
                            placeholder="Qty"
                        >
                        <button wire:click="searchAndAddBatik" type="button"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah
                        </button>
                    </div>
                    @error('searchBatik')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <h3 class="font-bold text-xl text-gray-900 mb-4 pb-2 border-b-2 border-purple-200 flex items-center">
                    <svg class="h-6 w-6 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Keranjang Belanja
                </h3>
                <div class="overflow-x-auto border border-gray-200 rounded-lg shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tl-lg">Batik</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Harga</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Qty</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Subtotal</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($cart as $index => $item)
                                <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $item['nama_batik'] }} ({{ $item['kode_batik'] }})
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        Rp {{ number_format($item['harga_jual'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <input type="number" wire:model.live="cart.{{ $index }}.qty"
                                            wire:change="updateCartItemQty({{ $index }}, $event.target.value)"
                                            min="1" class="w-16 border-gray-300 rounded-md shadow-sm text-center p-1">
                                        @error('cart.' . $index . '.qty')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        Rp {{ number_format($item['harga_jual'] * $item['qty'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button wire:click="removeCartItem({{ $index }})" type="button"
                                            class="text-red-600 hover:text-red-900 transition duration-150 ease-in-out">
                                            <svg class="h-5 w-5 inline-block -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-sm text-gray-500 text-center">
                                        Keranjang kosong. Scan QR Code atau tambahkan item manual.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Bagian Kanan: Ringkasan Penjualan --}}
            <div class="md:col-span-1 bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <h3 class="font-bold text-xl text-gray-900 mb-4 pb-2 border-b-2 border-green-200 flex items-center">
                    <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Ringkasan Penjualan
                </h3>

                {{-- Info Kasir --}}
                <div class="mb-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-blue-900">Kasir: {{ auth()->user()->name }}</p>
                            <p class="text-xs text-blue-700">{{ date('d M Y, H:i') }} WIB</p>
                        </div>
                    </div>
                </div>

                <div class="mb-4 p-4 border-y border-gray-200">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Total Harga:</span>
                        <span class="text-2xl font-bold text-gray-900">Rp {{ number_format($total_harga, 0, ',', '.') }}</span>
                        <input type="hidden" wire:model="total_harga" name="total_harga">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="total_bayar" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Dibayar</label>
                    <input type="number" wire:model.live="total_bayar" id="total_bayar"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-2xl font-bold p-2.5
                        @error('total_bayar') border-red-500 @enderror"
                        step="0.01" min="0" placeholder="0">
                    @error('total_bayar')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4 p-4 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-700">Kembalian:</span>
                        <span class="text-2xl font-bold text-gray-900">Rp {{ number_format($kembalian, 0, ',', '.') }}</span>
                        <input type="hidden" wire:model="kembalian" name="kembalian">
                    </div>
                    @if ($paymentStatusMessage)
                        <p class="text-red-500 text-sm mt-2 text-right font-semibold">{{ $paymentStatusMessage }}</p>
                    @endif
                </div>

                <div class="mt-6">
                    <button wire:click="processSale" wire:loading.attr="disabled" type="button"
                        class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200 text-lg"
                        {{ count($cart) === 0 || $total_bayar < $total_harga ? 'disabled' : '' }}>
                        <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span wire:loading.remove>Proses Pembayaran</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- QR Code Scanner Script --}}
<<<<<<< HEAD
=======
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>
>>>>>>> 903583dba47c81235784b0eb5f8c2866eaef41f8
<script>
document.addEventListener('DOMContentLoaded', function() {
    let qrScanner = null;
    let isScanning = false;
    
    const startButton = document.getElementById('startQrScan');
    const stopButton = document.getElementById('stopQrScan');
    const qrReader = document.getElementById('qrReader');
    const qrVideo = document.getElementById('qrVideo');
    const scanButtonText = document.getElementById('scanButtonText');
    const manualInput = document.getElementById('manualInput');

    // Start QR scanning
    startButton.addEventListener('click', async function() {
        try {
            // Request camera permission
            const stream = await navigator.mediaDevices.getUserMedia({ 
                video: { 
                    facingMode: 'environment' // Use back camera on mobile
                } 
            });
            
            qrVideo.srcObject = stream;
            qrVideo.play();
            
            // Show video element and hide start button
            qrReader.classList.remove('hidden');
            startButton.style.display = 'none';
            scanButtonText.textContent = 'Scanning...';
            isScanning = true;

            // Start QR code detection
            detectQRCode();
            
        } catch (error) {
            console.error('Error accessing camera:', error);
            alert('Gagal mengakses kamera. Pastikan browser memiliki izin kamera dan gunakan HTTPS.');
        }
    });

    // Stop QR scanning
    stopButton.addEventListener('click', function() {
        stopScanning();
    });

    function stopScanning() {
        if (qrVideo.srcObject) {
            const tracks = qrVideo.srcObject.getTracks();
            tracks.forEach(track => track.stop());
            qrVideo.srcObject = null;
        }
        
        qrReader.classList.add('hidden');
        startButton.style.display = 'inline-flex';
        scanButtonText.textContent = 'Scan QR Code';
        isScanning = false;
    }

    // QR Code detection using HTML5 canvas
    function detectQRCode() {
        if (!isScanning) return;

        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        
        if (qrVideo.readyState === qrVideo.HAVE_ENOUGH_DATA) {
            canvas.width = qrVideo.videoWidth;
            canvas.height = qrVideo.videoHeight;
            ctx.drawImage(qrVideo, 0, 0, canvas.width, canvas.height);
            
            try {
                // Use jsQR library for QR code detection
                const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const code = jsQR(imageData.data, imageData.width, imageData.height);
                
                if (code) {
                    // QR Code detected
                    console.log('QR Code detected:', code.data);
                    
                    // Process the QR code data
                    processQRCode(code.data);
                    
                    // Stop scanning after successful detection
                    stopScanning();
                    return;
                }
            } catch (error) {
                console.log('QR detection error:', error);
            }
        }
        
        // Continue scanning
        requestAnimationFrame(detectQRCode);
    }

    function processQRCode(qrData) {
        try {
            // Parse QR code data (assuming it's JSON format)
            const data = JSON.parse(qrData);
            
            if (data.kode) {
                // Set the manual input field with the scanned code
                manualInput.value = data.kode;
                manualInput.dispatchEvent(new Event('input', { bubbles: true }));
                
                // Trigger Livewire search
                @this.set('searchBatik', data.kode);
                @this.call('searchAndAddBatik');
                
                // Show success message
                showToast('QR Code berhasil dipindai: ' + data.kode, 'success');
            } else {
                showToast('Format QR Code tidak valid', 'error');
            }
        } catch (error) {
            // If not JSON, treat as plain text (kode batik)
            manualInput.value = qrData;
            manualInput.dispatchEvent(new Event('input', { bubbles: true }));
            
            @this.set('searchBatik', qrData);
            @this.call('searchAndAddBatik');
            
            showToast('QR Code berhasil dipindai: ' + qrData, 'success');
        }
    }

    function showToast(message, type) {
        // Simple toast notification
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 px-4 py-2 rounded-lg text-white z-50 ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        }`;
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
});
</script>

{{-- Include jsQR library for QR code detection --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsqr/1.4.0/jsQR.min.js"></script>
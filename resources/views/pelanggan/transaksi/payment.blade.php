<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-4">Pembayaran</h2>
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Detail Transaksi</h3>
                        <p>Order ID: TRX-{{ $transaksi->id }}</p>
                        <p>Total: Rp {{ number_format($transaksi->total_price, 0, ',', '.') }}</p>
                    </div>

                    <div id="snap-container"></div>
                    
                    <button id="pay-button" 
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                        Bayar Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" 
            data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        const payButton = document.querySelector('#pay-button');
        const snapToken = "{{ $snapToken }}";

        // Langsung tampilkan popup Midtrans saat halaman dimuat
        window.onload = function() {
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    window.location.href = '{{ route("pelanggan.transaksi.show", $transaksi->id) }}';
                },
                onPending: function(result) {
                    window.location.href = '{{ route("pelanggan.transaksi.show", $transaksi->id) }}';
                },
                onError: function(result) {
                    alert('Pembayaran gagal!');
                    window.location.href = '{{ route("pelanggan.transaksi.show", $transaksi->id) }}';
                },
                onClose: function() {
                    window.location.href = '{{ route("pelanggan.transaksi.show", $transaksi->id) }}';
                }
            });
        };

        // Jika user menutup popup, bisa klik tombol untuk membuka lagi
        payButton.addEventListener('click', function(e) {
            e.preventDefault();
            snap.pay(snapToken);
        });
    </script>
    @endpush
</x-app-layout>
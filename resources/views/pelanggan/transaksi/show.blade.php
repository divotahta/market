<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6 flex justify-between items-center">
                        <h2 class="text-2xl font-bold">Detail Transaksi #{{ $transaksi->id }}</h2>
                        <a href="{{ route('pelanggan.transaksi.index') }}" class="text-blue-600 hover:text-blue-800">
                            &larr; Kembali
                        </a>
                    </div>

                    <!-- Status Transaksi -->
                    <div class="mb-8">
                        <div class="flex gap-4">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                {{ $transaksi->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                   ($transaksi->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   'bg-red-100 text-red-800') }}">
                                Status: {{ ucfirst($transaksi->status) }}
                            </span>
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                {{ $transaksi->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 
                                   ($transaksi->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   'bg-red-100 text-red-800') }}">
                                Pembayaran: {{ ucfirst($transaksi->payment_status) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Informasi Produk -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4">Informasi Produk</h3>
                            <div class="flex gap-4">
                                <img src="{{ Storage::url($transaksi->product->image) }}" 
                                     alt="{{ $transaksi->product->name }}"
                                     class="w-24 h-24 object-cover rounded-lg">
                                <div>
                                    <h4 class="font-medium">{{ $transaksi->product->name }}</h4>
                                    <p class="text-gray-600">{{ $transaksi->product->category->name }}</p>
                                    <p class="text-lg font-bold text-blue-600 mt-2">
                                        Rp {{ number_format($transaksi->total_price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Pengiriman -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4">Informasi Pengiriman</h3>
                            <div class="space-y-2">
                                <p><span class="font-medium">Nama:</span> {{ $transaksi->name }}</p>
                                <p><span class="font-medium">Telepon:</span> {{ $transaksi->phone }}</p>
                                <p><span class="font-medium">Alamat:</span> {{ $transaksi->shipping_address }}</p>
                            </div>
                        </div>
                    </div>

                    @if($transaksi->payment_status === 'pending')
                        <div class="mt-8">
                            <button id="pay-button" 
                                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                Bayar Sekarang
                            </button>
                        </div>

                        @push('scripts')
                        <script src="https://app.sandbox.midtrans.com/snap/snap.js" 
                                data-client-key="{{ config('midtrans.client_key') }}"></script>
                        <script>
                            const payButton = document.querySelector('#pay-button');
                            const snapToken = "{{ $transaksi->snap_token }}";

                            payButton.addEventListener('click', function(e) {
                                e.preventDefault();
                                snap.pay(snapToken);
                            });
                        </script>
                        @endpush
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
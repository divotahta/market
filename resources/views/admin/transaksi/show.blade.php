<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6 flex justify-between items-center">
                        <h2 class="text-2xl font-bold">Detail Transaksi #{{ $transaksi->id }}</h2>
                        <a href="{{ route('admin.transaksi.index') }}" class="text-blue-600 hover:text-blue-800">
                            &larr; Kembali
                        </a>
                    </div>

                    <!-- Status dan Form Update Status -->
                    <div class="mb-8 bg-gray-50 p-6 rounded-lg">
                        <div class="flex justify-between items-center">
                            <div class="flex gap-4">
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $transaksi->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                       ($transaksi->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($transaksi->status === 'processing' ? 'bg-blue-100 text-blue-800' :
                                       'bg-red-100 text-red-800')) }}">
                                    Status: {{ ucfirst($transaksi->status) }}
                                </span>
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $transaksi->payment_status === 'completed' ? 'bg-green-100 text-green-800' : 
                                       ($transaksi->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       'bg-red-100 text-red-800') }}">
                                    Pembayaran: {{ ucfirst($transaksi->payment_status) }}
                                </span>
                            </div>

                            @if($transaksi->payment_status === 'completed')
                            <form action="{{ route('admin.transaksi.update-status', $transaksi) }}" method="POST" class="flex gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="processing" {{ $transaksi->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="completed" {{ $transaksi->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $transaksi->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    Update Status
                                </button>
                            </form>
                            @endif
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

                        <!-- Informasi Pembeli -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4">Informasi Pembeli</h3>
                            <div class="space-y-2">
                                <p><span class="font-medium">Nama:</span> {{ $transaksi->name }}</p>
                                <p><span class="font-medium">Telepon:</span> {{ $transaksi->phone }}</p>
                                <p><span class="font-medium">Alamat:</span> {{ $transaksi->shipping_address }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 
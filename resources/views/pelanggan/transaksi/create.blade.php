<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6">Form Pembelian</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Product Info -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <img src="{{ Storage::url($product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-48 object-cover rounded-lg mb-4">
                            <h3 class="text-xl font-semibold">{{ $product->name }}</h3>
                            <p class="text-gray-600 mb-2">{{ $product->description }}</p>
                            <p class="text-xl font-bold text-blue-600">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                        </div>

                        <!-- Order Form -->
                        <div>
                            <form action="{{ route('pelanggan.transaksi.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nama Penerima</label>
                                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                                        <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        @error('phone')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Alamat Pengiriman</label>
                                        <textarea name="shipping_address" rows="3"
                                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                                        @error('shipping_address')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <button type="submit" 
                                            class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                        Lanjut ke Pembayaran
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
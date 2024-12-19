<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Gambar Produk -->
                        <div class="relative">
                            @if($product->isSold())
                            <div class="absolute top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg z-10 shadow-lg">
                                <span class="font-semibold">Sudah Terjual</span>
                            </div>
                            @endif
                            <img src="{{ Storage::url($product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full rounded-lg shadow-lg {{ $product->isSold() ? 'opacity-75' : '' }}">
                        </div>

                        <!-- Detail Produk -->
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                            
                            <div class="flex gap-2 mb-6">
                                <span class="px-3 py-1 bg-gray-100 rounded-full text-sm font-medium text-gray-800">
                                    {{ $product->category->name }}
                                </span>
                                <span class="px-3 py-1 bg-gray-100 rounded-full text-sm font-medium text-gray-800">
                                    {{ $product->condition }}
                                </span>
                            </div>

                            <div class="mb-6">
                                <p class="text-3xl font-bold text-blue-600">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="prose max-w-none mb-8">
                                <h3 class="text-lg font-semibold mb-2">Deskripsi Produk</h3>
                                <p class="text-gray-600">{{ $product->description }}</p>
                            </div>

                            @if(!$product->isSold())
                                @auth
                                    <a href="{{ route('pelanggan.transaksi.create', $product) }}" 
                                       class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition duration-200">
                                        <i class="fas fa-shopping-cart mr-2"></i>Beli Sekarang
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" 
                                       class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition duration-200">
                                        Login untuk Membeli
                                    </a>
                                @endauth
                            @else
                                <button disabled 
                                        class="inline-block bg-gray-400 text-white px-8 py-3 rounded-lg cursor-not-allowed">
                                    Produk Sudah Terjual
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

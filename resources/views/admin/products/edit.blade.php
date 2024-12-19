<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Edit Produk</h2>
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                    </div>

                    <form method="POST" action="{{ route('admin.products.update', $product) }}"
                        enctype="multipart/form-data" class="space-y-6" x-data="imageUpload()" x-cloak>
                        @csrf
                        @method('PUT')

                        <!-- Nama Produk -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', $product->name) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gambar Produk -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                                x-on:dragover.prevent="$refs.dnd.classList.add('border-blue-500')"
                                x-on:dragleave.prevent="$refs.dnd.classList.remove('border-blue-500')"
                                x-on:drop.prevent="handleDrop($event)" x-ref="dnd">

                                <div class="space-y-1 text-center">
                                    <!-- Error Message -->
                                    <div x-show="errorMessage" x-text="errorMessage" class="text-red-500 text-sm mb-2">
                                    </div>

                                    <!-- Preview Image -->
                                    <div class="mb-4" x-show="imageUrl">
                                        <img :src="imageUrl" class="mx-auto h-48 w-auto object-cover"
                                            alt="Preview">
                                    </div>

                                    <!-- Default Image -->
                                    <div class="mb-4" x-show="!imageUrl">
                                        <img src="{{ Storage::url($product->image) }}"
                                            class="mx-auto h-48 w-auto object-cover" alt="{{ $product->name }}">
                                    </div>

                                    <div class="flex text-sm text-gray-600">
                                        <label
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload a file</span>
                                            <input type="file" name="image" class="sr-only" accept="image/*"
                                                x-ref="fileInput" x-on:change="handleFileChange">
                                        </label>
                                        <p class="pl-1">atau drop file disini</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        PNG, JPG, GIF
                                    </p>
                                </div>
                            </div>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="description" id="description" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Harga -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" name="price" id="price"
                                    value="{{ old('price', $product->price) }}"
                                    class="pl-12 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kondisi -->
                        <div>
                            <label for="condition" class="block text-sm font-medium text-gray-700">Kondisi</label>
                            <select name="condition" id="condition"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="Bekas - Seperti Baru"
                                    {{ old('condition', $product->condition) == 'Bekas - Seperti Baru' ? 'selected' : '' }}>
                                    Bekas - Seperti Baru
                                </option>
                                <option value="Bekas - Mulus"
                                    {{ old('condition', $product->condition) == 'Bekas - Mulus' ? 'selected' : '' }}>
                                    Bekas - Mulus
                                </option>
                            </select>
                            @error('condition')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-4">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function imageUpload() {
                return {
                    imageUrl: null,
                    errorMessage: null,
                    maxFileSize: 1024 * 1024, // 1MB dalam bytes

                    validateFile(file) {
                        // Reset error message
                        this.errorMessage = null;

                        // Validasi ukuran file
                        if (file.size > this.maxFileSize) {
                            this.errorMessage = 'Ukuran file terlalu besar. Maksimal 1MB';
                            return false;
                        }

                        // Validasi tipe file
                        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
                        if (!allowedTypes.includes(file.type)) {
                            this.errorMessage = 'Tipe file tidak didukung. Gunakan JPG, PNG, atau GIF';
                            return false;
                        }

                        return true;
                    },

                    handleFileChange(event) {
                        const file = event.target.files[0];
                        if (file && this.validateFile(file)) {
                            this.previewImage(file);
                        } else {
                            event.target.value = ''; // Reset input file
                            this.imageUrl = null;
                        }
                    },

                    handleDrop(event) {
                        const file = event.dataTransfer.files[0];
                        if (file && this.validateFile(file)) {
                            this.$refs.fileInput.files = event.dataTransfer.files;
                            this.previewImage(file);
                        }
                        this.$refs.dnd.classList.remove('border-blue-500');
                    },

                    previewImage(file) {
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                this.imageUrl = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                    }
                }
            }
        </script>
    @endpush
</x-admin-layout>

<x-layout>
    <div class="flex justify-center">
        <form action="{{ route('addProduct') }}" method="POST" enctype="multipart/form-data" method="post">
            @csrf
            <div class="flex items-center flex-col">

                <label for="fileinput">
                    <img id="imagePreview" src="https://placehold.co/600x400/png" alt="" class="w-32">
                    <div>
                        <input type="file" name="thumbnail" id="fileInput" class="hidden" accept="image/*">
                                <label for="fileInput" class="border px-2 py-1">
                                    Pilih File
                                </label>
                    </div>
                </label>

                <label for="">Judul :</label>
                <input type="text" name="judul" id="" placeholder="username">

                <label for="">Description :</label>
                <input type="text" name="description" id="" placeholder="description">

                <label for="">Price :</label>
                <input type="number" name="price" id="" step="0.01" placeholder="price">

                <label for="">stock :</label>
                <input type="number" name="stock" id=""  placeholder="stock">

                <select name="categories" class="border p-1 rounded-md outline-none">
                    <option value="null" disabled selected>Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                <button type="submit">Simpan</button>    
            </div>
        </form>
    </div>

    <script>
        // Ambil elemen input file dan img preview
        const fileInput = document.getElementById('fileInput');
        const imagePreview = document.getElementById('imagePreview');
    
        // Tambahkan event listener untuk perubahan pada file input
        fileInput.addEventListener('change', function(event) {
            // Pastikan ada file yang dipilih
            const file = event.target.files[0];
            if (file) {
                // Buat URL objek lokal untuk file yang dipilih
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result; // Setel src gambar pratinjau
                };
                reader.readAsDataURL(file); // Baca file sebagai Data URL
            }
        });
    </script>

</x-layout>
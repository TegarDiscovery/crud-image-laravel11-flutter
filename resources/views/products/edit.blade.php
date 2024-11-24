@extends('layouts.app')

@section('title', 'Edit Products')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">IMAGE</label>
                            
                            <!-- Menampilkan gambar yang sudah ada jika ada -->
                            <div class="mb-2">
                                @if(isset($product) && $product->image)
                                    <img id="imagePreview" src="{{ asset('storage/products/' . $product->image) }}" class="img-fluid" style="max-width: 200px;">
                                @else
                                    <img id="imagePreview" src="{{ asset('storage/products/default-image.jpg') }}" class="img-fluid" style="max-width: 200px;">
                                @endif
                            </div>
                        
                            <!-- Input file untuk memilih gambar -->
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="imageInput">
                            
                            <!-- error message untuk image -->
                            @error('image')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">TITLE</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $product->title) }}" placeholder="Masukkan Judul Product">
                        
                            <!-- error message untuk title -->
                            @error('title')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">DESCRIPTION</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5" placeholder="Masukkan Description Product">{{ old('description', $product->description) }}</textarea>
                        
                            <!-- error message untuk description -->
                            @error('description')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">PRICE</label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $product->price) }}" placeholder="Masukkan Harga Product">
                                
                                    <!-- error message untuk price -->
                                    @error('price')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">STOCK</label>
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ old('stock', $product->stock) }}" placeholder="Masukkan Stock Product">
                                
                                    <!-- error message untuk stock -->
                                    @error('stock')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-md btn-primary me-3">UPDATE</button>
                        <button type="reset" class="btn btn-md btn-warning">RESET</button>

                    </form> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Menambahkan event listener untuk input file
    document.getElementById('imageInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const imagePreview = document.getElementById('imagePreview');
            imagePreview.src = e.target.result; // Mengganti src dengan gambar yang dipilih
        }

        if (file) {
            reader.readAsDataURL(file); // Membaca file sebagai URL data
        }
    });
</script>
@endpush
@extends('layouts.app')

@section('title', 'Products')

@push('css')
<style>
    .page-item.active .page-link {
        background-color: #1CC88A;
        border-color: #1CC88A;
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <a href="{{ route('products.create') }}" class="btn btn-md btn-success mb-3">ADD PRODUCT</a>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th scope="col">IMAGE</th>
                                <th scope="col">TITLE</th>
                                <th scope="col">PRICE</th>
                                <th scope="col">STOCK</th>
                                <th scope="col">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td class="text-center">
                                        <img src="{{ asset('storage/products/' . ($product->image && file_exists(public_path('storage/products/'.$product->image)) ? $product->image : 'default-image.jpg')) }}" class="rounded" style="width: 150px">
                                    </td>                                                                                                       
                                    <td>{{ $product->title }}</td>
                                    <td>{{ "Rp " . number_format($product->price,2,',','.') }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td class="text-center">
                                        <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="#" method="POST" class="d-flex justify-content-center">
                                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-dark mr-2"><i class="fas fa-eye"></i></a>
                                            <a href="#" class="btn btn-sm btn-primary mr-2"><i class="fas fa-edit"></i></a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>                                  
                                </tr>
                            @empty
                                <div class="alert alert-danger">
                                    Data Products belum Tersedia.
                                </div>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $products->links() }} <!-- Menampilkan pagination -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Sweetalert untuk pesan success dan error
    @if(session('success'))
        Swal.fire({
            icon: "success",
            title: "BERHASIL",
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @elseif(session('error'))
        Swal.fire({
            icon: "error",
            title: "GAGAL!",
            text: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @endif
</script>
@endpush

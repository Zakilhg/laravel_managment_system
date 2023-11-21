@extends('user.navbar')
@section('contents')
    <div class="row my-5 m-2">
        <div class="search ">
{{--            <a class="btn btn-sm" style="background-color: #110E2D; color: white;width: 200px;margin-right: 10px" href="{{route('vent.create')}}">Ajouter Vent+</a>--}}
            <input type="text" class="searchTerm" placeholder="Search..." id="searchInput" >
            <button type="submit" class="searchButton">
                <i class="fa fa-search"></i>
            </button>

        </div>


        <h3 class="fs-4 mb-3 text-white">Products List</h3>


        <div class="col">
            <table class="table bg-white rounded shadow-sm  table-hover" id="productsTable">
                <thead>
                <tr>
                    <th scope="col" >Product</th>
                    <th scope="col">Categorie</th>
                    <th scope="col">Brand</th>
                    <th scope="col">Prix</th>
                    <th scope="col">Quantite</th>

                </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                    <tr>
                        <td scope="row"><a href="{{route('product.show',$product->id)}}">{{$product->name}}</a></td>
                        <td>{{$product->categorie->name}}</td>
                        <td>{{$product->brand->name}}</td>
                        <td>{{ $product->prix_vente }} DH</td>
                        <td>{{$product->quantite}}</td>

{{--                        <td>--}}
{{--                            <form action="{{route('vent.destroy',$product->id)}}" method="POST">--}}
{{--                                @csrf--}}
{{--                                @method('DELETE')--}}
{{--                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')">Delete</button>--}}
{{--                            </form>--}}

{{--                        </td>--}}
                    </tr>

                @empty
                    <tr>
                        <td colspan="10">No Product found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
                {{$products->links()}}

        </div>
    </div>
    <script>
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', filterProducts);

        function filterProducts() {
            const filterValue = searchInput.value.toLowerCase();
            const rows = document.querySelectorAll('#productsTable tbody tr');
            rows.forEach(row => {
                const productName = row.cells[0].textContent.toLowerCase();
                if (productName.includes(filterValue)) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        }


    </script>
@endsection

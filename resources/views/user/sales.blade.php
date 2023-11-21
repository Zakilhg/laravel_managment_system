@extends('user.navbar')
@section('contents')
<div class="row my-5 m-2">
    <div class="search ">
        <a class="btn btn-sm" style="background-color: #110E2D; color: white;width: 200px;margin-right: 10px" href="{{route('vent.create')}}">Ajouter Vent+</a>
        <input type="text" class="searchTerm" placeholder="Search..." id="searchInput" >
        <button type="submit" class="searchButton">
            <i class="fa fa-search"></i>
        </button>

    </div>


    <h3 class="fs-4 mb-3 text-white">Recent Orders</h3>

    <div class="col">
        <table class="table bg-white rounded shadow-sm  table-hover">
            <thead>
            <tr>
                <th scope="col" >Product</th>
                <th scope="col">Prix Vent</th>
                <th scope="col">Prix Achat</th>
                <th scope="col">Profit</th>
                <th scope="col">Quantite</th>
                <th scope="col">Date Vent</th>
                <th scope="col">Paiement</th>
                <th scope="col">Local</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($vents as $vent)
                <tr>
                    <td scope="row"><a href="{{route('product.show',$vent->product_id)}}">{{$vent->product->name}}</a></td>
                    <td>{{$vent->prix_vent}}</td>
                    <td>{{$vent->prix_achat}}</td>
                    <td>{{$vent->prix_vent - $vent->prix_achat}}</td>
                    <td>{{$vent->quantite}}</td>
                    <td>{{$vent->date_vent}}</td>
                    <td>{{$vent->paiement}}</td>
                    <td>{{$vent->local}}</td>
                    <td>
                        <form action="{{route('vent.destroy',$vent->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')">Delete</button>
                        </form>

                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="10">No history found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

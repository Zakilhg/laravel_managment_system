@extends('user.navbar')
@section('contents')

        <div class="container-fluid px-4">
            <div class="row g-3 my-2">
                <div class="col-md-3">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2">{{$products}}</h3>
                            <p class="fs-5">Products</p>
                        </div>
                        <i class="fas fa-gift fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2">{{count($vents)}}</h3>
                            <p class="fs-5">Sales</p>
                        </div>
                        <i
                            class="fas fa-hand-holding-usd fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2">{{$total_prix_vent}} DH</h3>
                            <p class="fs-5">Revenues</p>
                        </div>
                        <i class="fa-solid fa-money-bill fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2">%{{$percentage}}</h3>
                            <p class="fs-5">Profits</p>
                        </div>
                        <i class="fas fa-chart-line fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                    </div>
                </div>
            </div>


            <div class="row my-5">
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

        </div>
<!-- /#page-content-wrapper -->

@endsection






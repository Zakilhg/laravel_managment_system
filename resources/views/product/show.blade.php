@include('Components.nav')
<div class="container">
    <div class="row">
        <div class="col-md-12 px-5 py-5">
            <div class="user-profile">
                <div class="d-flex">
                    <div>
                        <img  src="{{ asset('storage/' . $product->image) }}" alt=""
                             style="width:200px; height:200px; object-fit:cover">
                    </div>
                    <div style="width:100%;margin-left:20px">
                        <table class="table table-bordered text-white">

                            <tr>
                                <td class="text-capitalize" style="background:#bfbbbb;color:#403a3a">Name</td>
                                <td>{{ $product->name }}</td>
                            </tr>

                            <tr>
                                <td class="text-capitalize" style="background:#bfbbbb;color:#403a3a">Categorie</td>
                                <td>{{$product->categorie->name}}</td>
                            </tr>

                            <tr>
                                <td class="text-capitalize" style="background:#bfbbbb;color:#403a3a">Brand</td>
                                <td>{{$product->brand->name}}</td>
                            </tr>

                            <!--tr 2 -->
                            <tr>
                                <td class="text-capitalize" style="background:#bfbbbb;color:#403a3a">Prix</td>
                                <td>{{ $product->prix_vente }} DH</td>
                            </tr>


                            <!--tr 4 -->
                            <tr>
                                <td class="text-capitalize" style="background:#bfbbbb;color:#403a3a">Quantity</td>
                                <td>{{ $product->quantite }}</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

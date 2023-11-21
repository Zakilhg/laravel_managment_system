@extends('layouts.app')
@include('Components.nav')
<main class="signup-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-sm-8 col-md-6 col-lg-4">
                <div class="card">
                    <h3 class="card-header text-center">Ajouter Vent</h3>
                    <div class="card-body">
                        <form action="{{route('vent.store')}}" method="POST" >
                            @csrf
                            <div class="form-group mb-3">
                                <select name="product" id="product" class="form-control">
                                    <option disabled selected> Select Product </option>
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('product'))F
                                    <span class="text-danger">{{ $errors->first('product') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <input type="text" placeholder="Brand" id="brands" class="form-control"
                                       name="brands" readonly>
                                @if ($errors->has('brands'))
                                    <span class="text-danger">{{ $errors->first('brands') }}</span>
                                @endif
                            </div>


                            <div class="form-group mb-3">
                                <input type="text" placeholder="Categorie" id="categorie" class="form-control"
                                       name="categorie" readonly>
                                @if ($errors->has('categorie'))
                                    <span class="text-danger">{{ $errors->first('categorie') }}</span>
                                @endif
                            </div>


                            <div class="form-group mb-3">
                                <input type="text" placeholder="Prix Achat" id="prix_achat" class="form-control"
                                       name="prix_achat" readonly>
                                @if ($errors->has('prix_achat'))
                                    <span class="text-danger">{{ $errors->first('prix_achat') }}</span>
                                @endif
                            </div>


                            <div class="form-group mb-3">
                                <input type="number" placeholder="Prix Vent" id="prix_vent" class="form-control"
                                       name="prix_vent" oninput="this.value=this.value.replace(/[^0-9]/g,'');" >
                                @if ($errors->has('prix_vent'))
                                    <span class="text-danger">{{ $errors->first('prix_vent') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <input type="number" placeholder="Quantity" id="quantite" class="form-control"
                                       name="quantite" oninput="this.value=this.value.replace(/[^0-9]/g,'');" >
                                @if ($errors->has('quantite'))
                                    <span class="text-danger">{{ $errors->first('quantite') }}</span>
                                @endif
                            </div>



                            <div class="form-group mb-3">
                                <input type="text" placeholder="Local" id="local" class="form-control"
                                       name="local"  >
                                @if ($errors->has('local'))
                                    <span class="text-danger">{{ $errors->first('local') }}</span>
                                @endif
                            </div>


                            <div class="form-group mb-3">
                                <input type="text" placeholder="Nome du Client" id="clientname" class="form-control"
                                       name="clientname"  >
                                @if ($errors->has('clientname'))
                                    <span class="text-danger">{{ $errors->first('clientname') }}</span>
                                @endif
                            </div>


                            <div class="form-group mb-3">
                                <input type="tel" placeholder="Numero du Client" id="clientphone" class="form-control"
                                       name="clientphone" oninput="this.value=this.value.replace(/[^0-9]/g,'');"  >
                                @if ($errors->has('clientphone'))
                                    <span class="text-danger">{{ $errors->first('clientphone') }}</span>
                                @endif
                            </div>


                            <div class="form-group mb-3">
                                <input type="email" placeholder="Email" id="clientemail" class="form-control"
                                       name="clientemail"   >
                                @if ($errors->has('clientemail'))
                                    <span class="text-danger">{{ $errors->first('clientemail') }}</span>
                                @endif
                            </div>


                            <div class="form-group mb-3">
                                <input type="text" placeholder="Address du Client" id="clientadresse" class="form-control"
                                       name="clientadresse"  >
                                @if ($errors->has('clientadresse'))
                                    <span class="text-danger">{{ $errors->first('clientadresse') }}</span>
                                @endif
                            </div>




                            <div class="form-group mb-3">
                                <select name="paiement" id="paiement" class="form-control">
                                    <option disabled selected> Select Payment </option>
                                    @foreach($paiements as $paiement)
                                        <option value="{{$paiement->name}}">{{$paiement->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('paiement'))
                                <span class="text-danger">{{ $errors->first('paiement') }}</span>
                                @endif
                            </div>


                            <div class="form-group mb-3">
                                <select name="societes" id="societes" class="form-control">
                                    <option disabled selected> Select Societe </option>
                                    @foreach($societes as $societe)
                                        <option value="{{$societe->name}}">{{$societe->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('societes'))
                                    <span class="text-danger">{{ $errors->first('societes') }}</span>
                                @endif
                            </div>



                            <div class="d-grid ">
                                <button type="submit" class="btn text-white btn-block"
                                        style="background-color: #83299B">Ajouter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    $(document).ready(function () {
        $('select').selectize({
            sortField: 'text'
        });
    });
    $(document).ready(function() {
        $('#product').on('change', function() {
            var productId = $(this).val();
            if(productId) {
                $.ajax({
                    url: '/getProductInfo/' + productId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#prix_promo').val(data.prix_promo);
                        $('#prix_revendeur').val(data.prix_revendeur);
                        $('#quantite_marrakech').val(data.quantite_marrakech);
                        $('#quantite_rabat').val(data.quantite_rabat);
                        $('#brands').val(data.brand_id);
                        $('#categorie').val(data.category_id);
                        $('#prix_achat').val(data.prix_achat);
                    }
                });
            }
        });
    });

</script>

@include('Components.footer')

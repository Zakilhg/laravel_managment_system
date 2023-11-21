
<div class="slide">
    <div class="row">
        <div class="col-12">
            <div id="carousel1" class="carousel slide" data-bs-ride="carousel">
                <ol class="carousel-indicators">
                    <li
                        data-bs-target="#carousel1"
                        data-bs-slide-to="0"
                        class="active"
                    ></li>
                    <li data-bs-target="#carousel1" data-bs-slide-to="1"></li>
                    <li data-bs-target="#carousel1" data-bs-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item">
                        <img
                            src="{{ asset('image/hero.png') }}"
                            class="d-block w-100"
                            alt="thumb"
                        />
                    </div>
                    <div class="carousel-item active">
                        <img
                            src="{{ asset('image/hero3.png') }}"
                            class="d-block w-100"
                            alt="thumb"
                        />
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item">
                            <img
                                src="{{ asset('image/hero.png') }}"
                                class="d-block w-100"
                                alt="thumb"
                            />
                        </div>

                </div>
                <button
                    class="carousel-control-prev"
                    type="button"
                    data-bs-target="#carousel1"
                    data-bs-slide="prev"
                >
              <span
                  class="carousel-control-prev-icon"
                  aria-hidden="true"
              ></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button
                    class="carousel-control-next"
                    type="button"
                    data-bs-target="#carousel1"
                    data-bs-slide="next"
                >
              <span
                  class="carousel-control-next-icon"
                  aria-hidden="true"
              ></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
</div>
<hr/>
    <style>
        .icon-white {
            filter: brightness(0) invert(1);
        }
    </style>

    <div class="container text-white" align="center" >
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                <div class="row">
                    <div class="col-lg-2 col-md-3 col-sm-3 col-2">
                        <img class="icon icon-white" alt="Free Shipping" src="{{asset('image/icons/free-delivery.svg')}}" />
                    </div>
                    <div class="col-lg-6 col-md-9 col-sm-9 col-9">
                        <h4>Free Shipping</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                <div class="row">
                    <div class="col-lg-2 col-md-3 col-sm-3 col-2">
                        <img class="icon icon-white" alt="Free Returns" src="{{asset('image/icons/exchange.svg')}}" />
                    </div>
                    <div class="col-lg-6 col-md-9 col-sm-9 col-9">
                        <h4>Free Returns</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                <div class="row">
                    <div class="col-lg-2 col-md-3 col-sm-3 col-2">
                        <img class="icon icon-white" alt="Low Prices" src="{{asset('image/icons/low-price.svg')}}" />
                    </div>
                    <div class="col-lg-6 col-md-9 col-sm-9 col-9">
                        <h4>Low Prices</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr/>
<h2 class="text-center text-white">RECOMMENDED PRODUCTS</h2>
<hr />
<div class="container d-flex justify-content-center mt-50 mb-50 ">
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mt-2">
                <div class="card">
                    <div class="card-img-actions">
                        <img src="{{$product->image}}"
                             class="card-img img-fluid"
                             width="96"
                             height="350"
                             alt=""
                        >
                    </div>
                    <div class="card-body bg-light text-center">
                        <div class="mb-2">
                            <h6 class="font-weight-semibold mb-2">
                                <a href='{{route('product.show',$product->id)}}' class="text-default mb-2" data-abc="true">{{ $product->name }}</a>
                            </h6>
                            <a href="#" class="text-muted" data-abc="true">{{ $product->categorie->name }}</a>
                        </div>
                        <h3 class="mb-0 font-weight-semibold">{{ $product->prix_vente }} DH</h3>
                        <button type="button" class="btn bg-cart">
                            <i class="fa fa-cart-plus mr-2"></i> Add to cart
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

</div>

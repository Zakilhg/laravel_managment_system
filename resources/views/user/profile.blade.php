@extends('user.navbar')
@section('contents')
{{--        <div class="row my-5 m-2">--}}

{{--            <div class="row">--}}
{{--                <div class="col-md-12 px-5 py-5">--}}
{{--                    <div class="user-profile">--}}
{{--                        <div class="d-flex">--}}
{{--                            <div>--}}
{{--                                <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="User profile"--}}
{{--                                     style="width:200px; height:200px; object-fit:cover">--}}
{{--                            </div>--}}
{{--                            <div style="width:100%;margin-left:20px">--}}
{{--                                <table class="table table-bordered text-white">--}}
{{--                                    <!--tr 1 -->--}}
{{--                                    <tr>--}}
{{--                                        <td class="text-capitalize" style="background:#bfbbbb;color:#403a3a">Name</td>--}}
{{--                                        <td>{{ Auth::user()->name }}</td>--}}
{{--                                    </tr>--}}

{{--                                    <!--tr 2 -->--}}
{{--                                    <tr>--}}
{{--                                        <td class="text-capitalize" style="background:#bfbbbb;color:#403a3a">Email</td>--}}
{{--                                        <td>{{ Auth::user()->email }}</td>--}}
{{--                                    </tr>--}}


{{--                                    <!--tr 4 -->--}}
{{--                                    <tr>--}}
{{--                                        <td class="text-capitalize" style="background:#bfbbbb;color:#403a3a">Local</td>--}}
{{--                                        <td>{{ Auth::user()->local }}</td>--}}
{{--                                    </tr>--}}

{{--                                </table>--}}
{{--                                <div style="width:100%">--}}
{{--                                    <div class="d-flex justify-content-center mb-3">--}}
{{--                                        <a class="btn btn-info" href="{{ route('edit') }}">Edit</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}


<div class="wrap">
    <div class="top-part">
        <div class="left-part">
            <div class="profile-image">
                <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="">
            </div>
        </div>
        <div class="right-part">
            <div class="profile-info">
                <div class="title">
                    <p><b>{{ Auth::user()->name }}</b></p>
                </div>
                <div class="sub-title">
                    <p>Employer at NEXT LEVEL ARENA</p>
                </div>
            </div>
            <div class="profile-list">
                <ul>
                    <li><strong class="list-title">E-MAIL</strong><span class="list-cont">{{ Auth::user()->email }}</span></li>
                    <li><strong class="list-title">AGE</strong><span class="list-cont">23</span></li>
                    <li><strong class="list-title">Local</strong><span class="list-cont">{{ Auth::user()->local }}</span></li>
                    <li><strong class="list-title">E-MAIL
                        </strong><span class="list-cont">habiburg3@gmail.com</span></li>
                    <li><strong class="list-title">PHONE</strong><span class="list-cont">+880 1875-660516</span></li>
                </ul>
                <a class="botona" href="{{ route('edit') }}" >Edit</a>
            </div>
        </div>
    </div>
</div>
        @endsection

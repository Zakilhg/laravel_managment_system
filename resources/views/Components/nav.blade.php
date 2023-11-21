@extends('layouts.app')

<nav class="navbar navbar-light navbar-expand-lg main-nav">
    <div class="container">
        <a class="navbar-brand" href="/">
            <h1 data-value="NEXTLEVEL" style="font-size: 30px;color: #E5E3E7">EXAM</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register-user') }}">Register</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href={{ route('dashboard') }}>Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('signout') }}">Logout</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

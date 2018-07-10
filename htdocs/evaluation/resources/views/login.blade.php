@extends('layouts.app')
@section('content')
<div class="login">
    <div class="col-md-12">
        <div class="col-md-6 mx-auto">
            <!-- form card login -->
            <div class="card rounded-0" id="login-form">
                <div class="card-header">
                    <h3 class="mb-0">Login</h3>
                </div>
                <div class="card-body">
                    <form class="form" role="form" autocomplete="off" id="formLogin" method="POST" action="authenticate">
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                        <div class="form-group">
                            <label for="uname1">Benutzername</label>
                            <input type="text" class="form-control form-control-lg rounded-0" name="name" id="uname1" required="">
                        </div>
                        <div class="form-group">
                            <label>Passwort</label>
                            <input type="password" class="form-control form-control-lg rounded-0" name="password" id="pwd1" required="">
                        </div>
                        <button type="submit" class="btn btn-success btn-lg float-right" id="btnLogin">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('auth.contenido')

@section('login')
<div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-group mb-0">
          <div class="card p-4">
          <form class="form-horizontal was-validated" method="POST" action="{{ route('login')}}">
          {{ csrf_field() }}
              <div class="card-body">
              <h1>Acceder</h1>
              <p class="text-muted">Control de acceso al sistema</p>
              <div class="form-group mb-3{{$errors->has('usuario' ? 'is-invalid' : '')}}">
                <span class="input-group-addon"><i class="icon-user"></i></span>
                <input type="text" value="{{old('usuario')}}" name="usuario" id="usuario" class="form-control" placeholder="Usuario">
                {!!$errors->first('usuario','<span class="invalid-feedback">:message</span>')!!}
              </div>
              <div class="form-group mb-4{{$errors->has('password' ? 'is-invalid' : '')}}">
                <span class="input-group-addon"><i class="icon-lock"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                {!!$errors->first('password','<span class="invalid-feedback">:message</span>')!!}
              </div>
              <div class="row">
                <div class="col-6">
                  <button type="submit" class="btn btn-info px-4">Acceder</button>
                </div>
              </div>
            </div>
          </form>
          </div>
          <div class="card" style="width: 18rem;">
  <img class="card-img-top" src="https://cdn.shopify.com/s/files/1/2964/0212/files/PW_-_Ale_Way_Bar_1600x.jpg?v=1548766467" alt="Card image cap">
  <div class="card-body p-3 mb-2 bg-info text-white">
      <h4>Sistema de pedidos Wildfoods</h4>
    <p class="card-text">Canal de comunicación para clientes</p>
  </div>
</div>
        </div>
      </div>
    </div>
@endsection

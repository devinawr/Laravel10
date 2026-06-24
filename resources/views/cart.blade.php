@extends('layouts.adminlte4')
@section('content')
  @if (session('status'))
    <div class="box success-box">
      {{ session('status') }}
    </div>
  @endif
  @if (count($cart) > 0)
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th>Nama Service</th>
            <th>Quantity</th>
            <th>Control</th>
          </tr>
        </thead>
        
        @foreach ($cart as $r)
           <tr>
                <td><p>{{$r['service']->service_name}}</p></td>
                <td>{{$r['quantity']}}</td>
                <td>
                  <a class="btn btn-warning" href="{{ url('/detail/' . $r['id']) }}">
                  Lihat
                </a>
                 <form action="{{ route('deleteCart', $r['id']) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Batalkan</button>
                  </form>
              </td>
           </tr>
        @endforeach
          </table>
  @else
  <div class="box info-box">
    Belum ada data yang dibuat
  </div>
  @endif
<form method="POST" action="{{ route('checkout') }}">
  @csrf
  <input type="submit" value="Checkout" class="btn btn-success">
</form>

@endsection
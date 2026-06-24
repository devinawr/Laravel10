@extends('layouts.adminlte4')
@section('content')
<div class="details col-md-6">
<form method="POST" action="{{ route('putCart',$data->id) }}">
@csrf
@method('PUT')
<h3 class="product-title">{{$data->service_name}} </h3>
<p><i>{{$data->category->name}}</i></p>
<p class="product-description">{{$data->description}}</p>
<h4 class="price">current price: <span>{{$data->price}}</span></h4>
<p><b>Quantity: </b><input type="number" min=1 value="1" name="quantity"></p>
<div class="action">
<input class="add-to-cart btn btn-default" type="submit" value="add to cart">
</div>
</form>
</div>
@endsection
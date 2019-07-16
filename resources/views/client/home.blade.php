@extends('layouts.app')

@section('content')
    <h2>Clients</h2>    
    <hr />
    @include('client.partials.newclient')
    
    @include('client.partials.clienttable')
    
@endsection

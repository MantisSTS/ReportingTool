@extends('layouts.app')

@section('content')
    <h2>Dashboard</h2>    
    <hr />
    <div class="card">
        <div class="card-header">System Overview</div>
        <div class="card-body">
            <p>Current Number of Registered Users:  {{ $numUsers }}</p>
            <p>Current Number of Active Users: {{ $activeUsers }}</p>
            <p>Current Number of Active Clients: {{ $numActiveClients }}</p>
        </div>
    </div>
    <div class="card">
        <div class="card-header">User Stats</div>
        <div class="card-body">
            <table class="" id="user-stats">

            </table>
        </div>
    </div>
@endsection

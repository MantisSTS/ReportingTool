@extends('layouts.app')
@section('assets')
<script src="{{ asset('js/bootstrap-multiselect.js') }}" defer></script>
<link rel="stylesheet" href="{{ asset('css/bootstrap-multiselect.css') }}">
@endsection
@section('content')
    <h2>Reporting - Client Report List</h2>
    <hr />
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Reports List</div>
                <div class="card-body">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Report ID</th>
                                <th scope="col">Client Name</th>
                                <th scope="col">Job name</th>
                                <th scope="col">Last Updated</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $d)
                                <tr>
                                    <td>{{ $d->id }}</td>
                                    <td>{{ $d->name }}</td>
                                    <td>{{ $d->job_name }}</td>
                                    <td>{{ $d->updated_at }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('report.generate', $d->id) }}"><i class="fas fa-arrow-down">&nbsp;</i></a>
                                        <a class="btn btn-success" href="{{ route('report.show', $d->id) }}"><i class="far fa-edit">&nbsp;</i></a>
                                        <a class="btn btn-danger" href="#"><i class="fas fa-times">&nbsp;</i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

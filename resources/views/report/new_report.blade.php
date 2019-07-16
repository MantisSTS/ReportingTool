@extends('layouts.app')

@section('content')
    <h2>Reporting</h2>
    <hr />
    <div class="card">
        <div class="card-header">Client</div>
        <div class="card-body">
            <select class="custom-select" size="6" id="client-select">
                @foreach($clients as $client)
                <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="card">
        <div class="card-header">Assessment Name</div>
        <div class="card-body">
            <div class="d-flex justify-content-center">
                <form action="{{ route('report.add_job_to_client') }}" method="post" class="form-inline" id="add-job-to-client">
                    @csrf
                    <div class="form-check form-check-inline">
                        <label class="sr-only" for="job_name">Assessment Name</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Name</div>
                            </div>
                            <input type="text" class="form-control" id="job_name" name="job_name" placeholder="Assessment Name">
                            <input type="hidden" name="client_id" class="client-id" value="">
                        </div>
                        <input type="submit" id="s-add-job-to-client" class="btn btn-success" value="Add">
                    </div>
                </form>
            </div>
            <select class="custom-select" id="job-select" size="6">

            </select>
        </div>
    </div>
    <div class="card">
        <div class="card-header">Phases</div>
        <div class="card-body">
            <div class="d-flex justify-content-center">
                <form action="{{ route('report.add_phase_to_job') }}" method="post" class="form-inline" id="add-phase-to-job">
                    @csrf
                    <div class="form-check form-check-inline">
                        <label class="sr-only" for="phase_name">Phase Name</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Phase</div>
                            </div>
                            <input type="hidden" id="job_id" name="job_id" value="">
                            <input type="text" class="form-control" id="phase_name" name="phase_name" placeholder="Phase Name">
                        </div>
                        <input type="submit" id="s-add-phase-to-job" class="btn btn-success" value="Add">
                    </div>
                </form>
            </div>
            <select class="custom-select" size="6" id="phase-select">

            </select>
        </div>
    </div>
    <form action="{{ route('report.init') }}" name="init_report" method="post">
        @csrf
        <div class="form-group d-flex justify-content-center">
            <input type="submit" class="btn btn-success navbar-btn" name="submit" value="Submit" id="init-report">
        </div>
    </form>
@endsection

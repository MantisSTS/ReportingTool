@extends('layouts.app')
@section('assets')
<script src="{{ asset('js/bootstrap-multiselect.js') }}" defer></script>
<link rel="stylesheet" href="{{ asset('css/bootstrap-multiselect.css') }}">
<meta name="report_id" value="{{ $report_id }}">
@endsection
@section('content')
    <h2>Reporting - Configure Phase</h2>
    <hr />
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Issue List</div>
                <div class="card-body">
                    <select class="form-control" name="vulnerability-select" id="vulnerability-select" multiple data-live-search="true" size="30">
                        @foreach($vulns as $vuln)
                        <option value="{{ $vuln->id }}">{{ $vuln->title }}</option>
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="offset-md-6">
                            <button id="add-to-report" class="btn btn-success">Add to Report</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Issue List</div>
                <div class="card-body">
                    <select class="form-control" name="report-vulnerabilities" id="report-vulnerabilities" multiple data-live-search="true" size=30>
                    @foreach($issues as $issue)
                        <option value="{{ $issue->id }}">{{ $issue->title }}</option>
                    @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('report.generate', $report_id) }}" >
                    <span class="">Generate Report!</span>
                </a>
            </div>
        </div>
    </div>
@endsection

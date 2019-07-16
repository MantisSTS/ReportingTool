@extends('layouts.app')

@section('content')
    <h2>Reporting</h2>
    <hr />
    <div class="card">
        <div class="card-header">System Overview
            <div class="pull-right">
                <a href="{{ route('report.create') }}" class="btn btn-success">New Report</a>
            </div>
        </div>
        <div class="card-body">
            <p>Current Number of Open (Ungenerated) Reports:  {{ count($reports) }}</p>
        </div>
    </div>
    <div class="card">
        <div class="card-header">User Stats</div>
        <div class="card-body">
            <table class="table" id="user-stats">
                <thead class="thead-dark">
                    <tr>
                        <th>Client</th>
                        <th>Author</th>
                        <th>Assessment Name</th>
                        <th># of Phases</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                    <tr>
                        <td><a href="{{ route('client.show', $report->client_id) }}">{{ $report->name }}</a></td>
                        <td>{{ $report->first_name . ' ' . $report->last_name }}</td>
                        <td><a href="{{ route('report.edit', $report->assessment_id) }}">{{ $report->assessment_name }}</a></td>
                        <td>{{ $report->phase_count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

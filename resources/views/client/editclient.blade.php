@extends('layouts.app')

@section('content')
    <h2>Edit Client - {{ $currentClient->name }}</h2>
    <hr />
    <div class="card">
    <div class="card-header">
        {{ $currentClient->name }}
    </div>
    <div class="card-body">
        <form action="{{ route('client.update', $currentClient->id) }}" method="POST">
            @method('PUT')
            @csrf
            <h3>Client Details</h3>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="client_name">Client Name</label>
                    <input type="text" class="form-control" id="client_name" name="client_name" value="{{ $currentClient->name }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="parent_client">Parent Client</label>
                    <select id="parent_client" name="parent_client" class="form-control">
                        <option selected="selected" value="0">N/A</option>
                        @foreach($clientList as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Do this properly --}}
            <hr />
            <h3>Contact Details</h3>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label class="form-check-label" for="first_name">First Name:</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $clientContact->first_name }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label class="form-check-label" for="last_name">Last Name:</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $clientContact->last_name }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label class="form-check-label" for="primary_email">Primary Email:</label>
                    <input type="text" class="form-control" id="primary_email" name="primary_email" value="{{ $clientContact->primary_email }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label class="form-check-label" for="phone_number">Phone Number:</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $clientContact->phone_number }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label class="form-check-label" for="fax">Company Fax Number:</label>
                    <input type="text" class="form-control" id="fax" name="fax" value="{{ $clientContact->fax }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <p class="well">Created At: {{ $currentClient->created_at }}</p>
                </div>
                <div class="form-group col-md-6">
                    <p class="well">Last Updated: {{ $currentClient->updated_at }}</p>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <input class="btn btn-success" type="submit" id="submit" value="Submit">
                </div>
            </div>
       </form>
    </div>
</div>

@endsection


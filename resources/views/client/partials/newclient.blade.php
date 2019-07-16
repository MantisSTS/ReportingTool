<div class="card">
    <div class="card-header">
        New Client
    </div>
    <div class="card-body">
        <form action="{{ route('client.store') }}" method="post">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="client_name">Client Name</label>
                    <input type="text" class="form-control" id="client_name" name="client_name" placeholder="Example Client">
                </div>
                <div class="form-group col-md-6">
                    <label for="parent_client">Parent Client</label>
                    <select id="parent_client" name="parent_client" class="form-control">
                        <option selected="selected" value="0">N/A</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="pull-right">
                    <input class="form-check-input" type="checkbox" id="active" name="active">
                    <label class="form-check-label" for="active">Active?</label>
                </div>
            </div>
            <div class="form-group">
                    @csrf
                    {{-- <div class="pull-right"> --}}
                        <input class="btn btn-success" type="submit" id="submit" value="Submit">
                    {{-- </div> --}}
            </div>
       </form>
    </div>
</div>
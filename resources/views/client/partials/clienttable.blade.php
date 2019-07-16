<div class="card">
    <div class="card-header">
        Clients
    </div>
    <div class="card-body">
        <table class="table" id="client-table">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    {{-- <th>Parent</th> --}}
                    <th>Active</th>
                    <th>Number of Reports</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                <tr>
                    <td>{{ $client->id }}</td>
                    <td><a href="{{ route('client.edit', $client->id) }}">{{ $client->name }}</a></td>
                    {{-- <td><a href="{{ route('client.show', ($client->parent_id != 0 ? $client->parent_id : '')) }}">{{ ($client->parent_id == 0 ? '' : $client->name) }}</a></td> --}}
                    <td>{{ ($client->active == 1 ? 'Yes' : 'No') }}</td>
                    <td>NOT AVAILABLE</td>
                    <td>{{ $client->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
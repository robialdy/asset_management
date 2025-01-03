<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Code Asset</th>
            <th>Name</th>
            <th>Category</th>
            <th>Description</th>
            <th>Added Date</th>
            <th>Sent Date</th>
            <th>Return Date</th>
            <th>Destroy Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($assets as $asset)
        <tr>
            <td>{{ $asset->id }}</td>
            <td>{{ $asset->code_asset }}</td>
            <td>{{ $asset->name }}</td>
            <td>{{ $asset->category }}</td>
            <td>{{ $asset->description }}</td>
            <td>{{ $asset->added_date }}</td>
            <td>{{ $asset->sent_date }}</td>
            <td>{{ $asset->return_date }}</td>
            <td>{{ $asset->destroy_date }}</td>
            <td>{{ $asset->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

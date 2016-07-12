<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>Code</th>
        <th>Description</th>
    </tr>
    @foreach($set as $language)
        <tr data-id="{{$language->id}}">
            <td>{{$language->id}}</td>
            <td>{{$language->code}}</td>
            <td>{{$language->description}}</td>
            <td>
                <a href="{{ route('admin.languages.edit', $language) }}" class="btn-edit">Edit</a>
                <a href="#!" class="btn-delete">Delete</a>
            </td>
        </tr>
    @endforeach

</table>

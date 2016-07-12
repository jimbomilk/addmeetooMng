<table class="table table-striped">
    <tr>
        <th>Code</th>
        <th>Description</th>
        <th>Gender</th>
        <th>Min Age</th>
        <th>Max Age</th>
        <th></th>
    </tr>
    @foreach($set as $category)
        <tr data-id="{{$category->id}}">
            <td>{{$category->code}}</td>
            <td>{{$category->description}}</td>
            <td>{{$category->gender}}</td>
            <td>{{$category->minAge}}</td>
            <td>{{$category->maxAge}}</td>
            <td>
                <a href="{{ route('admin.categories.edit', $category) }}" class="btn-edit">Edit</a>
                <a href="#!" class="btn-delete">Delete</a>
            </td>
        </tr>
    @endforeach

</table>
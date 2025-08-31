@php($index = $data instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator ? $data->firstItem() : 1)
@forelse($data as $nu)
    <tr>
        <th scope="row">{{ $index++ }}</th>
        <td>{{ $nu->name }}</td>
        <td>{{ $nu->designation?->name }}</td>
        <td>{{ $nu->created_at->toDateString() }}</td>
        <td><img class="img-thumbnail img-fluid rounded mx-auto d-block w-25" alt="image" src="{!! asset('uploads/images/' . $nu->image)  !!}"></td>
        <td class="text-center">
            <div class="btn-group btn-group-sm" role="group" aria-label="Row actions">
                <a href="{{ route('single-pdf', $nu->id) }}" class="btn btn-red" target="_blank" title="PDF"><i class="bx bxs-file-pdf"></i></a>
                <a href="{{ route('nu-smart-card.card', $nu->id) }}" class="btn btn-info" target="_blank" title="Card"><i class="bx bx-id-card"></i></a>
                <a href="{{ route('nu-smart-card.show', $nu->id) }}" class="btn btn-primary" title="View"><i class="bx bx-show"></i></a>
                <a href="{{ route('nu-smart-card.edit', $nu->id) }}" class="btn btn-green" title="Edit"><i class="bx bx-edit"></i></a>
                <button data-url="{{ route('nu-smart-card.destroy', $nu->id) }}" class="btn btn-danger delete-btn" title="Delete"><i class="bx bx-trash"></i></button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center">No Data Found</td>
    </tr>
@endforelse

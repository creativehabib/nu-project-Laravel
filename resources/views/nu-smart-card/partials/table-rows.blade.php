@php($index = $data instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator ? $data->firstItem() : 1)
@forelse($data as $nu)
    <tr>
        <th scope="row">{{ $index++ }}</th>
        <td>{{ $nu->name }}</td>
        <td>{{ $nu->designation?->name }}</td>
        <td>{{ $nu->created_at->toDateString() }}</td>
        <td><img class="img-thumbnail img-fluid rounded mx-auto d-block w-25" alt="image" src="{!! asset('uploads/images/' . $nu->image)  !!}"></td>
        <td class="text-center">
            <a href="{{ route('single-pdf', $nu->id) }}" class="btn btn-red btn-sm" target="_blank"><i class="bx bxs-file-pdf fs-4"></i></a>
            <a href="{{ route('nu-smart-card.show', $nu->id) }}" class="btn btn-primary btn-sm"><i class="bx bx-show fs-4"></i></a>
            <a href="{{ route('nu-smart-card.edit', $nu->id) }}" class="btn btn-sm btn-green"><i class="bx bx-edit fs-4"></i></a>
            <button data-url="{{ route('nu-smart-card.destroy', $nu->id) }}" class="btn btn-danger delete-btn btn-sm"><i class="bx bx-trash fs-4"></i></button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center">No Data Found</td>
    </tr>
@endforelse

@forelse ($orders as $item)
<tr>
    <td data-label="@langg('ID')">
        <div>
            {{ $item->id }}
        </div>
    </td>
    <td data-label="@langg('DATE')">
        <div>
            {{ dateFormat($item->created_at,'d M Y') }}
        </div>
    </td>
    <td data-label="@langg('SERVICE')" data-bs-toggle="tooltip" title="{{$item->service->title}}">
        <div>
            {{ Str::limit($item->service->title,20) }}
        </div>
    </td>
    <td data-label="@langg('LINK')" data-bs-toggle="tooltip" title="{{$item->link}}">
        <div >
            {{ Str::limit($item->link) }}
        </div>
    </td>
    <td data-label="@langg('PRICE')">
        <div class="text--success">
            {{ number_format($item->price,4) }} {{$gs->curr_code}}
        </div>
    </td>
    <td data-label="@langg('QTY')">
        <div>
            {{ $item->qty }}
        </div>
    </td>
    
    <td data-label="@langg('START COUNT')">
        <div>
            {{ $item->start_count ?? 0 }}
        </div>
    </td>
    <td data-label="@langg('REMAIN')">
        <div>
            {{ $item->remains ?? 'N/A' }}
        </div>
    </td>
    <td data-label="@langg('STAUS')">
        <div>
            @if($item->status == 'pending')
                <span class="badge bg-warning">@langg('Pending')</span>
            @elseif($item->status == 'progress')
                <span class="badge bg-info">@langg('In Progress')</span>
            @elseif($item->status == 'completed')
                <span class="badge bg-success">@langg('Completed')</span>
            @elseif($item->status == 'partial')
                <span class="badge bg-dark">@langg('Partial')</span>
            @elseif($item->status == 'processing')
                <span class="badge bg-primary">@langg('Processing')</span>
            @elseif($item->status == 'canceled')
                <span class="badge bg-danger">@langg('Cancelled')</span>
            @elseif($item->status == 'refunded')
                <span class="badge bg-info">@langg('Refunded')</span>
            @endif
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="12">
        <div class="text-center">
            @langg('No result found')
        </div>
    </td>
</tr>
@endforelse
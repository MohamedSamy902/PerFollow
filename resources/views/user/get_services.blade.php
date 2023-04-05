@forelse ($services as $item)
<tr>

<td data-label="@langg('SERVICE ID')">
    <div>
        {{ $item->id }}
    </div>
</td>

<td data-label="@langg('SERVICE')" data-bs-toggle="tooltip" title="{{$item->title}}">
    <div>
        {{ Str::limit($item->title) }}
    </div>
</td>

<td data-label="@langg('RATE/1K')">
    <div class="text--success">
        {{ number_format($item->price,4) }} {{$gs->curr_code}}
    </div>
</td>
<td data-label="@langg('MIN')">
    <div>
        {{ $item->min_amount }}
    </div>
</td>
<td data-label="@langg('MAX')">
    <div>
        {{ $item->max_amount }}
    </div>
</td>


<td data-label="@langg('DETAILS')">
    <button class="btn btn-primary btn-sm">@langg('Details')</button>
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
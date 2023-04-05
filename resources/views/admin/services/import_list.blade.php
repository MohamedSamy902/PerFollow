@foreach ($res as $k => $item)
<tr class="elements">
    <td data-label="@lang('#')">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input shadow-none" id="customCheck{{$k}}" name="service[{{$k}}]" value="{{json_encode($item)}}">
            <label class="custom-control-label" for="customCheck{{$k}}"></label>
        </div>
    </td>
    <td data-label="@lang('name')">{{$item['name']}}</td>
    <td data-label="@lang('Category')">{{$item['category']}}</td>
    <td data-label="@lang('Limit')">{{'min : '.$item['min'].' - max : '.$item['max']}}</td>
    <td data-label="@lang('Rate/1k')"><strong>{{$item['rate']}} {{$gs->curr_code}}</strong></td>
</tr>    
@endforeach
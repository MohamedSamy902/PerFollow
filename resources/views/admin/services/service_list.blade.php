<option value="" selected>@langg('Select Service')</option>
@foreach ($res as $item)
    <option value="{{$item['service']}}" data-service="{{json_encode($item)}}" 
    @if (session('service_id') && session('service_id') == $item['service'])
        selected
    @endif
    >{{$item['name']}}</option>
@endforeach
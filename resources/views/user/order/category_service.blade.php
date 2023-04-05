<option value="">@langg('Select Service')</option>
@foreach ($services as $item)
  <option value="{{$item->id}}">{{$item->title}}</option>
@endforeach
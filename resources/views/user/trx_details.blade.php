
<li class="list-group-item d-flex justify-content-between">@langg('Transaction ID')<span>{{$transaction->trnx}}</span></li>
<li class="list-group-item d-flex justify-content-between">@langg('Remark')<span class="badge bg-dark">{{ucwords(str_replace('_',' ',$transaction->remark))}}</span></li>

<li class="list-group-item d-flex justify-content-between">@langg('Amount')<span class="badge {{$transaction->type == '+' ? 'bg-success':'bg-danger'}}">{{$transaction->type}}{{round($transaction->amount,3)}} {{$gs->curr_code}}</span></li>
<li class="list-group-item d-flex justify-content-between">@langg('Charge')<span>{{round($transaction->charge,3)}} {{$gs->curr_code}}</span></li>

<li class="list-group-item d-flex justify-content-between">@langg('Date')<span>{{dateFormat($transaction->created_at,'d M y')}}</span></li>
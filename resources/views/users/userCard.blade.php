<a class="card" href="/users/{{$user->cwruID}}">
  <div class="medium image">
  	<img src="{{$user->pictureURL()}}"> 
  </div>
  <div class="content">
    <div class="inverted header">{{$user->firstName." ".$user->lastName}}</div>
    <div class="meta">
      <span class="date">Joined in {{Html::semToText($user->pledgeSem)}}</span>
    </div>
    <div class="description">
      {{$user->bio}}
    </div>
  </div>
</a>
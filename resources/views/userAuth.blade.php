<li class="dropdown">
    <!-- This works well for static text, like a username -->
    <a class="dropdown-toggle" data-toggle="dropdown" role="button"
       aria-expanded="false">{{$currentUser->first_name}} {{$currentUser->last_name}}
        <span class="caret"></span></a>
    <ul class="dropdown-menu scrollable-menu" role="menu">
        <li class="item"><a href=""></a></li>
        @if($currentUser->menu_items != null)
            @foreach($currentUser->menu_items as $index=>$item)
                @if(isset($item->isHeader) && $item->isHeader)
                    <li class="dropdown-header">{{$item->text}}</li>
                @else
                    <li class="item">
                        @if(isset($item->method) && $item->method != 'get')
                            {!! Form::open(['url'=>$item->url, 'method'=>$item->method,
                            'id'=>str_replace('/\s+/','',$item->text).'-form'])  !!}
                            {!! Form::close() !!}
                            <a href="{!! $item->url !!}"
                               onclick="event.preventDefault();
                                       document.getElementById('{!! str_replace('/\s+/','',$item->text).'-form' !!}').submit()"
                            >{{$item->text}}</a>
                        @else
                            <a href="{!! $item->url !!}"
                               @if(isset($item->external) && $item->external)
                               target="_blank"
                                    @endif
                            >
                                {{$item->text}}
                            </a>
                        @endif
                    </li>
                @endif
            @endforeach
        @endif
    </ul>

</li>
<!-- Add any additional bootstrap header items.  This is a drop-down from an icon -->
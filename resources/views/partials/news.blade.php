@foreach($last as $item)
    <div class="pb-5">
        <div>
            <a href="{{route('link',$item)}}" target="_blank" rel="noopener noreferrer"
               class="text-dark">{{$item->title}}</a>
        </div>
        <div class="float-sm-right v-center">
            <time class="mr-1">{{$item->created_at->format('H:i')}}</time>
            <span>
                            <img async src="/storage/{{$item->source->logo}}">
                {{$item->source->host}}
            </span>
        </div>
    </div>
@endforeach
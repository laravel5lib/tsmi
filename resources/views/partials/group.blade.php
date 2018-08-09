@foreach($items = $groups->slice(0,1) as $item)
    <div class="row pb-4">
        <div class="col-sm-12">
            <div class="item">
                <a href="{{route('show',$item)}}">
                    <div class="bg-black-opacity">
                        <div class="bottom">
                            <div class="text-right" style="max-width:600px">
                                <span class="bg-white p-1">
                                        <time class="mr-1">{{$item->article->created_at->format('H:i')}}</time>
                                        <span>
                                            <img src="/storage/{{optional($item->article->source)->logo}}">
                                            {{optional($item->article->source)->host}}
                                        </span>
                                </span>
                                <p class="h1 text-white pt-2 pr-5 pb-4">
                                  {{$item->article->title}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <img src="/storage/{{$item->article->local_image}}" alt="{{$item->article->title}}" class="img-full img-fluid">
                </a>
            </div>
        </div>
    </div>
@endforeach


<div class="row border-bottom pb-5">
    @foreach($items = $groups->slice(1,3) as $item)
        <div class="col-sm-4">
        <div class="item">
            <a href="{{route('show',$item)}}">
                    <div class="bg-black-opacity">
                    <div class="bottom pb-3">
                        <div class="text-right">
                            <span class="bg-white p-1">
                                <time class="mr-1">{{$item->article->created_at->format('H:i')}}</time>
                                <span>
                                    <img src="/storage/{{optional($item->article->source)->logo}}">
                                    {{optional($item->article->source)->host}}
                                </span>
                            </span>
                        </div>
                    </div>
                    </div>
                <img src="/storage/{{$item->article->local_image}}" alt="{{$item->article->title}}" class="img-full img-fluid">
            </a>
        </div>
        <div class="mt-2">
            <a href="{{route('show',$item)}}" class="text-dark">{{$item->article->title}}</a>
        </div>
    </div>
    @endforeach
</div>

<div class="row mt-4 border-bottom pb-5">
    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-12">
                @foreach($items = $groups->slice(4,1) as $item)
                    <div class="item">
                        <a href="{{route('show',$item)}}">
                            <div class="bg-black-opacity">
                                <div class="bottom">
                                    <div class="text-right" style="max-width:600px">
                                        <span class="bg-white p-1">
                                            <time class="mr-1">{{$item->article->created_at->format('H:i')}}</time>
                                            <span>
                                                <img src="/storage/{{optional($item->article->source)->logo}}">
                                                {{optional($item->article->source)->host}}
                                            </span>
                                        </span>
                                        <p class="h1 text-white pt-2 pr-5 pb-4">
                                          {{$item->article->title}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <img src="/storage/{{$item->article->local_image}}" alt="{{$item->article->title}}" class="img-full img-fluid">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row mt-4">
            @foreach($items = $groups->slice(5,2) as $item)
                <div class="col-sm-6">
                    <div class="item">
                        <a href="{{route('show',$item)}}">
                            <div class="bg-black-opacity">
                                <div class="bottom pb-3">
                                    <div class="text-right">
                                        <span class="bg-white p-1">
                                            <time class="mr-1">{{$item->article->created_at->format('H:i')}}</time>
                                            <span>
                                                <img src="/storage/{{optional($item->article->source)->logo}}">
                                                {{optional($item->article->source)->host}}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <img src="/storage/{{$item->article->local_image}}" alt="{{$item->article->title}}" class="img-full img-fluid">
                        </a>
                    </div>
                    <div class="mt-2">
                        <a href="{{route('show',$item)}}" class="text-dark">{{$item->article->title}}</a>
                    </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="col-sm-4">
        <div class="row">
            @foreach($items = $groups->slice(7,5) as $item)
                <div class="pb-5">
                    <div>
                        <a href="{{route('show',$item)}}" class="text-dark">{{$item->article->title}}</a>
                    </div>
                    <div class="float-sm-right v-center">
                        <time class="mr-1">{{$item->article->created_at->format('H:i')}}</time>
                        <span>
                            <img src="/storage/{{$item->article->source->logo}}">
                            {{$item->article->source->host}}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
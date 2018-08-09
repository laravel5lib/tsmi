@extends('layouts.app')

@section('content')
    <div class="row justify-content-md-center"
         data-controller="news"
         data-news-type="group"
         data-news-paginate="2"
         data-news-created="{{$records['groups']}}"
         data-news-load="0">
        <div class="group-news col col-lg-9">

            @include('partials.group')

        </div>
        <div class="last-news col col-lg-3"
             data-controller="news"
             data-news-type="last"
             data-news-paginate="2"
             data-news-created="{{$records['article']}}"
             data-news-load="0">

            <div class="pb-2">
                <h1 class="h3">Последние новости</h1>
            </div>

            @include('partials.news')

        </div>
    </div>
@endsection
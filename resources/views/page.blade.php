@extends('layouts.app')

@section('title',$main->title)
@section('description',$main->description)
@section('keywords','')

@section('content')
    <div class="row justify-content-md-center">
        <div class="group-news col col-lg-9">


            <main class="pb-3">
                <div class="row">
                    <div class="col-sm-12">

                             <span>
                                  <img async src="/storage/{{optional($main->source)->logo}}">
                                 {{optional($main->source)->host}}
                             </span>


                        <h1 class="text-black mt-1 mb-4 font-weight-normal"> {{$main->title}}</h1>

                        <div class="item">
                            <a href="{{route('link',$main)}}" target="_blank">
                                <img async src="/storage/{{$main->local_image}}"
                                     alt="{{$main->title}}" class="img-full img-fluid img-md">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-sm-12">
                        <p>{{$main->description}}</p>
                    </div>
                </div>

            </main>


            <div class="row mt-4 v-center">

                <div class="col-md-6">
                    <h2>Популярное по этой теме</h2>
                    @foreach($groups as $item)
                        <div class="pb-5">
                            <div>
                                <a href="{{route('show',$item)}}" class="text-dark">{{$item->title}}</a>
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
                </div>

                <div class="col-md-6">

                    <div class="bg-dark v-center" style="min-height: 500px">
                        <h3 class="text-warning font-weight-light">Реклама</h3>
                    </div>

                </div>

            </div>


        </div>
        <div class="last-news col col-lg-3">
            <div class="pb-2">
                <h1 class="h3">Последние новости</h1>
            </div>

            @include('partials.news')

        </div>
    </div>
@endsection
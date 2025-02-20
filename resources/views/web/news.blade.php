@extends('web.layouts')
@section('content')
@include('web.components.breadcrumb')

<div class="tp-blog-area pt-110 pb-120 grey-bg3">
    <div class="container-fluid">
       <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row">
                    @foreach($data['news'] as $news)
                        <div class="col-xl-3 col-lg-3 col-md-6 wow tpfadeUp mb-30" data-wow-duration=".9s" data-wow-delay=".3s">
                            <div class="tp-blog-item">
                                <div class="tp-blog-thumb fix p-relative mb-35">
                                    <a href="{{LaravelLocalization::localizeUrl('/blogs/'.$news->slug)}}">
                                        <img src="{{$news->getFirstMediaUrl('list_image')}}" alt="{{$news->title}}">
                                    </a>
                                    @if($news->author)
                                        <div class="tp-blog-tag">
                                            <span>{{_t('By')}}: {{$news->author}}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="tp-blog-content">
                                    <h4 class="tp-blog-title mb-10">
                                        <a class="text-anim" href="{{LaravelLocalization::localizeUrl('/blogs/'.$news->slug)}}">{{$news->title}}</a>
                                    </h4>
                                    <div class="tp-blog-meta d-flex align-items-center">
                                        <span>{{\Carbon\Carbon::parse($news->date)->translatedFormat('d M Y')}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if(count($data['news']) > 0)
                    <div class="row">
                        <div class="col-md-12">
                        <div class="basic-pagination mt-40">
                                <nav class="text-center">
                                    <ul>
                                        <li>
                                        <a href="{{ LaravelLocalization::localizeUrl('/blogs')}}">
                                            <span><i class="fa-solid fa-chevron-left"></i></span>
                                        </a>
                                        </li>
                                        @for($i=1; $i<=$data['news']->lastPage(); $i++)
                                            <li class="@if($data['news']->currentPage() == $i) current @endif"><a class="page-link" href="{{ LaravelLocalization::localizeUrl('/blogs?page='.$i)}}">{{$i}}</a></li>
                                        @endfor
                                        <li>
                                        <a href="{{ LaravelLocalization::localizeUrl('/blogs?page='.$data['news']->lastPage())}}">
                                            <span class="current"><i class="fa-solid fa-chevron-right"></i></span>
                                        </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
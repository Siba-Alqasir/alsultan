@extends('web.layouts')
@section('content')
<!-- breadcrumb area start -->
<div class="breadcrumb__area breadcrumb__height grey-bg p-relative"
        style="background: url('{{$data['page']->getFirstMediaUrl('cover')}}'); background-repeat: no-repeat; background-size: cover;">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12">
                <div class="breadcrumb__content text-center z-index">

                    <div class="breadcrumb__section-title-box mb-20">
                    <h3 class="breadcrumb__title text-uppercase">{{$data['blogs_page']['title']}}</h3>
                    </div>
                    <div class="breadcrumb__list mb-10">
                    <span><a href="{{LaravelLocalization::localizeUrl('/')}}">{{_t('Home')}}</a></span>
                    <span class="dvdr">&nbsp;&bullet;&nbsp;</span>
                    <span>{{$data['blogs_page']['title']}}</span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb area end -->

<div class="postbox__area pt-120 pb-70">
    <div class="container">
       <div class="row justify-content-center">
          <div class="col-xxl-8 col-xl-8 col-lg-8 mb-50">
             <div class="postbox__wrapper">
                <article class="postbox__item format-image transition-3">
                   <h3 class="postbox__title">{{$data['page']['title']}}</h3>

                      <div class="postbox__meta-box pb-5 d-flex justify-content-between align-items-center">
                         <div class="postbox__meta mb-20">
                            <span><i class="fas fa-calendar-alt"></i>{{\Carbon\Carbon::parse($data['page']->date)->translatedFormat('d M Y')}}</span>
                            {{-- <span><i class="fal fa-clock"></i> {{\Carbon\Carbon::parse($data['page']->last_read)->locale(app()->getLocale())->diffForHumans()}}</span> --}}
                         </div>
                      </div>

                   <div class="postbox__content mb-55">
                      <p>{!! $data['page']['description'] !!}</p>
                   </div>
                   
                </article>
             </div>
          </div>
          
       </div>
    </div>
</div>
@endsection
{{-- @push('page-scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const blogId = "{{ $data['page']->id }}";

    fetch("{{ route('update.blogs.last_read') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}", 
        },
        body: JSON.stringify({ blog_id: blogId }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log("Last read updated successfully.");
        } else {
            console.error("Failed to update last read:", data.message);
        }
    })
    .catch(error => {
        console.error("Error updating last read:", error);
    });
});
</script>
@endpush --}}
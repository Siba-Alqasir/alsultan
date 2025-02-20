@foreach($gallery as $image)
    <div class="col-md-3">
        <a href="{{$image->getUrl()}}" class="image-link">
            <img src="{{$image->getUrl()}}" class="w-100">
        </a>
    </div>
@endforeach

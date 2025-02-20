@if($products->hasPages())
    <div class="row">
        <div class="col-xl-12">
            <div class="basic-pagination mt-20">
                <nav>
                    <ul class="d-flex justify-content-center">
                        <li>
                            <a href="#" data-page="1">
                            <i class="fa-solid fa-angles-left"></i>
                            </a>
                        </li>
                        @foreach ($products->links()->elements[0] as $page => $url)
                            <li class="{{$products->currentPage() == $page ? 'current' : ''  }}">
                                <a href="#" data-page="{{ $page }}">{{ $page }}</a>
                            </li>
                        @endforeach
                        <li>
                            <a href="#" data-page="{{$products->lastPage()}}">
                            <i class="fa-solid fa-angles-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endif
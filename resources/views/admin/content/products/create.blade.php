@extends('admin.layouts.contentLayoutMaster')
@section('title', 'Create Product')

@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-justified" id="myTab2" role="tablist">
                    @foreach($active_lang as $key=>$locale)
                        <li class="nav-item">
                            <a class="nav-link @if($key === 'en') active @endif" id="{{$key}}-tab-justified"
                               data-bs-toggle="tab" href="#add-{{$key}}"
                               role="tab" aria-controls="add-{{$key}}" aria-selected="false"
                               @if($key === 'en') aria-selected="true" @endif>{{$locale['name']}}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content pt-1">
                    @foreach($active_lang as $key=>$locale)
                        <div class="tab-pane @if($key === 'en') active @endif" id="add-{{$key}}" role="tabpanel"
                             aria-labelledby="{{$key}}-tab-justified">
                            <form method="POST" action="{{route('products.store')}}" enctype="multipart/form-data"
                                  id="form_{{$key}}">
                                <input type="hidden" name="lang" value="{{$key}}">
                                <input type="hidden" name="category_id" value="{{$category->id}}">
                                @csrf
                                {{-- Interlocking Tiles --}}
                                @if($category->id == \App\Enums\CategoryEnum::InterlockingTiles->value)
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-1">
                                                <label class="form-label">Title <b>({{$locale['name']}})</b> @if($key === 'en')*@endif</label>
                                                <input type="text" name="title" class="form-control" @if($key === 'en') required @endif>
                                            </div>
                                        </div>                                    
                                        <div class="col-lg-12">
                                            <div class="mb-1">
                                                <label class="form-label">Description <b>({{$locale['name']}})</b> @if($key === 'en')*@endif</label>
                                                <textarea class="form-control" name="description" id="summernote"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <label class="form-label">Finishes</label>
                                                <select class="select2 form-control" name="finishes[]" multiple>
                                                    @foreach(\App\Models\Finish::where('category_id', \App\Enums\CategoryEnum::InterlockingTiles->value)->get() as $finish)
                                                        <option value="{{$finish->id}}">{{$finish->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <label class="form-label">Sizes</label>
                                                <select class="select2 form-control" name="sizes[]" multiple>
                                                    @foreach(\App\Models\Size::all() as $size)
                                                        <option value="{{$size->id}}">{{$size->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <label class="form-label">Colors</label>
                                                <select class="select2 form-control" name="colors[]" multiple>
                                                    @foreach(\App\Models\Color::all() as $color)
                                                        <option value="{{$color->id}}">{{$color->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <label class="form-label">Patterns</label>
                                                <select class="select2 form-control" name="patterns[]" multiple>
                                                    @foreach(\App\Models\Pattern::all() as $pattern)
                                                        <option value="{{$pattern->id}}">{{$pattern->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="col-lg-12"><h3 class="text-center mb-2 mt-2">Downloads</h3></div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-1">
                                                <label class="form-label">Technical Data sheet</label>
                                                <input type="file" name="data_sheet" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-1">
                                                <label class="form-label">Product Catalogue</label>
                                                <input type="file" name="catalogue" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-1">
                                                <label class="form-label">Guide</label>
                                                <input type="file" name="guide" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="col-lg-12"><h3 class="text-center mb-2 mt-2">Gallery</h3></div>
                                    <div class="repeater">
                                        <div class="entry">
                                            <div class="row mt-1">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Upload Image</label>
                                                        <input type="file" name="gallery[]"
                                                            class="form-control" id="gallery_url" accept="image/*" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <button class="btn btn-danger btn-remove mt-2" type="button">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-add mt-1" type="button">Add More</button>

                                    <hr>
                                    <div class="col-lg-12"><h3 class="text-center mb-2 mt-2">SEO Information</h3></div>
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label"> Meta Title <b>({{$locale['name']}})</b></label>
                                            <input type="text" name="meta_title" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Meta Description <b>({{$locale['name']}})</b></label>
                                            <input type="text" name="meta_description" class="form-control">
                                        </div>
                                    </div>
                                {{-- End Interlocking Tiles --}}
                                {{-- Kerbstone --}}
                                @elseif($category->id == \App\Enums\CategoryEnum::Kerbstone->value)
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <label class="form-label">Size *</label>
                                                <input type="text" name="size" class="form-control"required>
                                            </div>
                                        </div>                                    
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <label class="form-label">Weight *</label>
                                                <input type="text" name="weight" class="form-control"required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <label class="form-label">Finish *</label>
                                                <select class="form-control" name="finish">
                                                    @foreach(\App\Models\Finish::where('category_id', \App\Enums\CategoryEnum::Kerbstone->value)->get() as $finish)
                                                        <option value="{{$finish->id}}">{{$finish->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>                                    
                                        <div class="col-lg-6">
                                            <div class="mb-1">
                                                <label class="form-label">Type *</label>
                                                <select class="form-control" name="type">
                                                    @foreach(\App\Models\Type::all() as $type)
                                                        <option value="{{$type->id}}">{{$type->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                {{-- End Kerbstone --}}
                                {{-- Cablle Cover --}}
                                @elseif($category->id == \App\Enums\CategoryEnum::CableCover->value)
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-1">
                                                <label class="form-label">Serial Number *</label>
                                                <input type="text" name="serial_number" class="form-control"required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-1">
                                                <label class="form-label">Size *</label>
                                                <input type="text" name="size" class="form-control"required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-1">
                                                <label class="form-label">Description *</label>
                                                <textarea name="description" class="form-control" required></textarea>
                                            </div>
                                        </div>                                        
                                    </div>
                                @else
                                    <div class="col-lg-12">
                                        <div class="mb-1">
                                            <label class="form-label">Description <b>({{$locale['name']}})</b> @if($key === 'en')*@endif</label>
                                            <textarea class="form-control" name="description" id="summernote"></textarea>
                                        </div>
                                    </div>
                                @endif
                                {{-- End Cablle Cover --}}
                                {{-- Data Sheet --}}
                                @if($category->id == \App\Enums\CategoryEnum::Kerbstone->value || $category->id == \App\Enums\CategoryEnum::CableCover->value)
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-1">
                                                <label class="form-label">Data sheet</label>
                                                <input type="file" name="data_sheet" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                {{-- End Data Sheet --}}
                                @if($category->id != \App\Enums\CategoryEnum::InterlockingTiles->value)
                                    @if($key === 'en')
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-1">
                                                    <label class="form-label">Upload Image *</label>
                                                    <input type="file" name="image" class="form-control" id="image_url"
                                                        accept="image/*" required/>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="mb-1">
                                                    <img class="img-fluid rounded"  id="image_view">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                <button type="submit" data-id="{{$key}}" class="btn btn-primary mt-2" style="float: right">Save</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        $(document).ready(function() {
            if ($('[id^=summernote]').length > 0) {
                $('[id^=summernote]').summernote({
                    height: 80,
                });
            }
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var entryTemplate = $('.entry:first').clone();
    
            $('.btn-add').click(function() {
                var newEntry = entryTemplate.clone();
                newEntry.find('input').val('');
                newEntry.appendTo('.repeater');
            });
    
            $(document).on('click', '.btn-remove', function() {
                $(this).closest('.entry').remove();
            });
        });
    </script>
    <script>
        $("#image_url").change(function () {
            readURL(this);
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#image_view').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @if(session('errors'))
        @if(session('errors')->first('catalogue') )
            <script>
                toastr['error'](
                    "{{ session('errors')->first('catalogue') }}",
                    "Error",
                    {
                        closeButton: true,
                        tapToDismiss: false,
                        progressBar: true,
                    });
            </script>
        @elseif(session('errors')->first('data_sheet'))
            <script>
                toastr['error'](
                    "{{ session('errors')->first('data_sheet') }}",
                    "Error",
                    {
                        closeButton: true,
                        tapToDismiss: false,
                        progressBar: true,
                    });
            </script>
        @elseif(session('errors')->first('guide'))
            <script>
                toastr['error'](
                    "{{ session('errors')->first('guide') }}",
                    "Error",
                    {
                        closeButton: true,
                        tapToDismiss: false,
                        progressBar: true,
                    });
            </script>
        @endif
    @endif
@endsection

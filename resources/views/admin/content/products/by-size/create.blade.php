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
                            <form method="POST" action="{{route('products-by-size.store')}}" enctype="multipart/form-data"
                                  id="form_{{$key}}">
                                <input type="hidden" name="lang" value="{{$key}}">
                                @csrf
                                    <div class="row">                                  
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
                                                <label class="form-label">Colors</label>
                                                <select class="select2 form-control" name="colors[]" multiple>
                                                    @foreach(\App\Models\Color::all() as $color)
                                                        <option value="{{$color->id}}">{{$color->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
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
@endsection

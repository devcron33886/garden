@extends('layouts.master')

@section('title','Slides')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>
                                Home slides
                            </h3>
                        </div>
                        <div class="panel-body">
                            <button data-toggle="modal" data-target="#addModal" type="button"
                                    class="btn btn-primary py-1">
                                Add New
                            </button>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Header</th>
                                    <th>Description</th>
                                    <th>Active</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($slides as $item)
                                    <tr>
                                        <td>
                                            <a href="{{$item->image_url}}" target="_blank">
                                                <img src="{{$item->image_url}}"
                                                     class="img-responsive img-thumbnail img-circle"
                                                     style="height: 50px;"
                                                     alt="{{$item->header}}">
                                            </a>
                                        </td>
                                        <td>{{$item->header}}</td>
                                        <td>{{ str_limit($item->description,50)}}</td>
                                        <td>
                                            @if($item->is_active)
                                                <span class="label label-success">
                                                  <i class="fe fe-check"></i>
                                                    Yes
                                                </span>
                                            @else
                                                <span class="label label-danger">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button data-url="{{ route('slides.show',$item->id) }}"
                                                        class="btn btn-light js-edit">
                                                    <span class="fa fa-edit"></span>
                                                </button>
                                                <a href="{{ route('slides.destroy',$item->id) }}"
                                                   onclick="return confirm('Are you sure you want to delete?');"
                                                   class="btn btn-danger">
                                                    <span class="fa fa-trash"></span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade submitModal" tabindex="-1 " id="addModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable  modal-xl" role="document">
            <div class="modal-content modal-xl">
                <div class="modal-header">
                    <h5 class="modal-title">Slide</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('slides.store')}}" enctype="multipart/form-data" method="post" class="submitForm">
                    <input type="hidden" name="id" value="0" id="id">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="header">Header</label>
                            <input type="text" class="form-control" id="header" placeholder="Slide Name"
                                   name="header" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="image">Image </label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image" name="image">
                                    <label class="custom-file-label" for="image">Choose Image</label>
                                </div>
                            </div>
                            <span id="image-error" class="invalid-feedback" style="display: inline;"></span>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea rows="5" type="text" class="form-control" id="description"
                                      placeholder="Description"
                                      name="description" autocomplete="off"></textarea>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="show_text" class="custom-control-input" id="show_text">
                                <label class="custom-control-label" for="show_text"> Show text</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="is_active" class="custom-control-input" id="is_active">
                                <label class="custom-control-label" for="is_active"> Mark as active</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary" id="createBtn">
                                <i class="fe fe-check-circle"></i> Save Changes
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                        class="fe fe-x"></i> Close
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest(\App\Http\Requests\ValidateHomeSlide::class) !!}
    <script>
        $('.js-edit').on("click", "", function (e) {
            var btn = $(this);
            var findUrl = btn.data("url");
            btn.addClass('btn-loading');
            $.ajax({
                url: findUrl,
                method: "get",
                dataType: "json",
                success: function (response) {
                    $("#addModal").modal();
                    $("#header").val(response.header);
                    $("#id").val(response.id);
                    $("#description").val(response.description);
                    $("#is_active").prop('checked', response.is_active === 1);
                    $("#show_text").prop('checked', response.show_text === 1);
                }, error: function () {
                    alert("Error getting data");
                }, complete: function () {
                    btn.removeClass('btn-loading');
                }
            });
            return false;
        });
    </script>
@endsection

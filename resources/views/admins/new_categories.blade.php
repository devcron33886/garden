@extends('layouts.master')
@section('title','Categories')

@section('content')
    <div class="section-heading">
        <h1 class="page-title">Product categories</h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel flat">
                <div class="panel-heading flat">
                    <h4 class="panel-title">
                        <i class="fa fa-square"></i> Categories

                        <button data-toggle="modal" data-target="#addModal" type="button"
                                class="btn btn-default pull-right btn-sm flat">
                            <i class="fa fa-plus icon-collapsed"></i>
                            Add New
                        </button>
                        <span class="clearfix"></span>
                    </h4>
                    <hr>
                </div>
                <div class="panel-body panel-content">
                    <table class="table table-condensed table-bordered table-striped table-responsive table-hover"
                           id="manageTable">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Created At</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $cat)
                            <tr>
                                <td>{{$cat->name}}</td>
                                <td>{{$cat->created_at}}</td>
                                <td>
                                    <button class="btn btn-primary js-edit"
                                            data-url="{{ route('category.show',[$cat->id]) }}"
                                    >Edit
                                    </button>
                                    <button class="btn btn-primary js-delete"
                                            data-url="{{ route('category.destroy',[$cat->id]) }}"
                                    >Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>


    <!-- add categories -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form novalidate class="form-horizontal" id="submitForm" action="{{ route('save') }}"
                      method="POST">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Category</h4>
                    </div>
                    <div class="modal-body">

                        <div id="add-messages"></div>
                        <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="categoriesName" class="col-sm-4 control-label">Category Name</label>
                            <label class="col-sm-1 control-label">: </label>
                            <div class="col-sm-7">
                                <input type="text" required class="form-control" id="categoriesName"
                                       placeholder="Category Name" name="name" autocomplete="off">
                            </div>
                        </div> <!-- /form-group-->
                    </div> <!-- /modal-body -->
                    <div class="modal-footer">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                        class="glyphicon glyphicon-remove-sign"></i> Close
                            </button>
                            <button type="submit" class="btn btn-primary" id="createBtn" data-loading-text="Loading...">
                                <i class="glyphicon glyphicon-ok-sign"></i> Save Changes
                            </button>
                        </div>
                    </div> <!-- /modal-footer -->
                </form> <!-- /.form -->
            </div> <!-- /modal-content -->
        </div> <!-- /modal-dailog -->
    </div>
    <!-- /add categories -->

    <!-- /categories  -->




    <script>
        $(function () {
            $('.js-edit').on('click', function () {
                var url = $(this).attr('data-url');
                $('#addModal').modal();
                $.getJSON(url)
                    .done(function (data) {
                        $('#id').val(data.id);
                        $('#categoriesName').val(data.name);
                    }).fail(function () {

                });
            });

            $('#submitForm').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function (data) {
                        location.reload();
                    }
                })
            })
        });
    </script>
@endsection
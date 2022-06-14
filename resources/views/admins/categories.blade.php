@extends('layouts.master')
@section('title','Categories')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default rounded-sm shadow-sm">
                <div class="panel-heading bg-white">
                    <h4 class="panel-title">
                        <i class="fa fa-square"></i> Categories
                        <button data-toggle="modal" data-target="#addModal" type="button"
                                class="btn btn-primary pull-right btn-sm">
                            <i class="fa fa-plus icon-collapsed"></i>
                            Add New
                        </button>
                        <span class="clearfix"></span>
                    </h4>
                </div>
                <div class="panel-body">
                    <table class="table table-condensed table-responsive table-hover table-border rounded-sm"
                           id="manageTable">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>


    <!-- add categories -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content rounded-sm">
                <form novalidate class="form-horizontal" id="submitForm" action="{{ route('category.store') }}"
                      method="POST">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Category</h4>
                    </div>
                    <div class="modal-body">

                        <div id="add-messages"></div>
                        @csrf
                        <div class="form-group">
                            <label for="categoriesName" class="col-sm-4 control-label">Category Name</label>
                            <label class="col-sm-1 control-label">: </label>
                            <div class="col-sm-7">
                                <input type="text" required class="form-control" id="categoriesName"
                                       placeholder="Category Name" name="name" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="categoriesStatus" class="col-sm-4 control-label">Status</label>
                            <label class="col-sm-1 control-label">: </label>
                            <div class="col-sm-7">
                                <select required class="form-control" id="categoriesStatus" name="status">
                                    <option value=""></option>
                                    <option selected value="Active">Active</option>
                                    <option value="Not Active">Not Active</option>
                                </select>
                            </div>
                        </div> <!-- /form-group-->
                    </div> <!-- /modal-body -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary rounded-sm" id="createBtn" data-loading-text="Loading...">
                            <i class="glyphicon glyphicon-ok-sign"></i> Save Changes
                        </button>
                        <button type="button" class="btn btn-default rounded-sm" data-dismiss="modal"><i
                                    class="glyphicon glyphicon-remove-sign"></i> Close
                        </button>
                    </div> <!-- /modal-footer -->
                </form> <!-- /.form -->
            </div> <!-- /modal-content -->
        </div> <!-- /modal-dailog -->
    </div>
    <!-- /add categories -->

    <!-- edit categories  -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form novalidate class="form-horizontal" id="editForm" action="{{ route('category.update') }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-pencil"></i> Edit category</h4>
                    </div>
                    <div class="modal-body">
                        <div id="edit-messages"></div>

                        <div class="modal-loading div-hide"
                             style="width:50px; margin:auto;padding-top:50px; padding-bottom:50px;">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Loading...</span>
                        </div>

                        <div class="edit-result">
                            <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
                            <div class="form-group">
                                <label for="editCategoriesName" class="col-sm-4 control-label">Category Name</label>
                                <label class="col-sm-1 control-label">: </label>
                                <div class="col-sm-7">
                                    <input required type="text" class="form-control" id="editCategoriesName"
                                           placeholder="Categories Name" name="name" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="editStatus" class="col-sm-4 control-label">Status</label>
                                <label class="col-sm-1 control-label">: </label>
                                <div class="col-sm-7">
                                    <select required class="form-control" id="editStatus" name="status">
                                        <option value=""></option>
                                        <option value="Active">Active</option>
                                        <option value="Not Active">Not Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /edit brand result -->

                    </div> <!-- /modal-body -->

                    <div class="modal-footer editFooter">
                        <button type="submit" class="btn btn-primary rounded-sm" id="editBtn" data-loading-text="Loading..."><i
                                    class="glyphicon glyphicon-ok-sign"></i> Save Changes
                        </button>
                        <button type="button" class="btn btn-default rounded-sm" data-dismiss="modal"><i
                                    class="glyphicon glyphicon-remove-sign"></i> Close
                        </button>
                    </div>
                    <!-- /modal-footer -->
                </form>
                <!-- /.form -->
            </div>
            <!-- /modal-content -->
        </div>
        <!-- /modal-dailog -->
    </div>
    <!-- /categories  -->





@endsection

@section('scripts')
    <script>

        var defaultUrl = "{{ route('category.all')  }}";
        var table;
        var manageTable = $("#manageTable");

        function myFunc() {
            window.table = manageTable.DataTable({
                "bProcessing": true,
                "serverSide": true,
                ajax: {
                    url: defaultUrl,
                    method: 'POST',
                    dataSrc: 'data',
                    data: {_token: "{{csrf_token()}}"}
                },
                columns: [
                    {data: 'name', 'sortable': true},
                    {
                        data: 'status', 'sortable': true, render(data, type, row) {
                            if (data === 'Active') {
                                return "<span class='label label-success'>" + data + "</span>"
                            }
                            return "<span class='label label-danger'>" + data + "</span>"
                        }
                    },
                    {data: 'created_at', 'sortable': true},
                    {
                        data: 'id',
                        'sortable': false,
                        render: function (data, type, row) {
                            return "<div class='btn-group btn-group-sm'>" +
                                "<button class='btn btn-default btn-sm js-edit' " +
                                "data-url='/admin/categories/show/" + row.id + "' data-id='" + row.id + "'> " +
                                "<i class='glyphicon glyphicon-edit'></i></button>" +
                                "<button class='btn btn-warning  btn-sm js-delete' data-id='" + data +
                                "' data-url='/admin/categories/destroy/" + row.id + "'> " +
                                "<i class='glyphicon glyphicon-trash'></i>" +
                                "</button>" +
                                "</div>";
                        }
                    }
                ]
            });
        }


        $(document).ready(function () {
            $('.nav-categories').addClass('active');
            myFunc();


            manageTable.on("click", ".js-edit", function () {
                var findUrl = $(this).attr("data-url");
                // remove hidden  id text
                $('#id').remove();
                // Launching edit modal
                $("#editModal").modal();
                // edit categories messages
                $("#edit-messages").html("");
                // modal spinner
                $('.modal-loading').removeClass('div-hide');
                // modal result
                $('.edit-result').addClass('div-hide');
                //modal footer
                var footer = $(".editFooter");
                footer.addClass('div-hide');
                $.ajax({
                    url: findUrl,
                    method: "get",
                    dataType: "json"
                }).done(function (response) {

                    // modal spinner
                    $('.modal-loading').addClass('div-hide');
                    // modal result
                    $('.edit-result').removeClass('div-hide');
                    //modal footer
                    footer.removeClass('div-hide');
                    // set the categories name
                    $("#editCategoriesName").val(response.name);
                    $("#editStatus").val(response.status);
                    // add the categories id
                    footer.after('<input type="hidden" name="id" id="id" value="' + response.id + '" />');
                }).fail(function (error) {
                    alert("Error getting data");
                });
                return false;
            });
        });
    </script>
@endsection

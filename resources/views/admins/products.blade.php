@extends('layouts.master')
@section('title','Products')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="panel rounded-sm shadow-sm panel-default">
                <div class="panel-heading bg-white">
                    <h4 class="panel-title">
                        <i class="fa fa-square"></i> Manage products
                        <button data-toggle="modal" data-target="#addModal" type="button"
                                class="btn btn-primary pull-right btn-sm">
                            <i class="fa fa-plus icon-collapsed"></i>
                            Add New
                        </button>
                        <span class="clearfix"></span>
                    </h4>
                </div>
                <div class="panel-body panel-content table-responsive">
                    <table class="table table-condensed  table-hover table-border rounded-sm table-hover"
                           id="manageTable">
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Measure</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Min stock</th>
                            <th>Status</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>


    <!-- add products -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form enctype="multipart/form-data" novalidate class="" id="submitProductForm"
                      action="{{ route('products.store') }}"
                      method="POST">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Product</h4>
                    </div>
                    <div class="modal-body">

                        <div id="add-messages"></div>
                        <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">

                        <div class="form-group">
                            <label for="productImage" class="control-label">Product Image </label>
                            <div class="">
                                <button type="button" class="btn btn-info btn-sm btn-block btn-upload-photo">
                                    <i class="fa fa-folder"></i>
                                    Choose Photo
                                </button>
                                <input type="file" name="image" class="sr-only filePhoto" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="addname" class="control-label">Product Name</label>

                            <div class="">
                                <input type="text" class="form-control" id="addname" placeholder="Product Name"
                                       name="name" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="addcategory" class="control-label">Category Name</label>

                            <div class="">
                                <select name="category" class="form-control" id="addcategory" required>
                                    <option value="">--select--</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> <!-- /form-group-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="addcatgory" class="control-label">Price</label>

                                    <div class="">
                                        <input type="text" class="form-control" id="addprice" placeholder="Price"
                                               name="price"
                                               autocomplete="off" required>
                                    </div>
                                </div> <!-- /form-group-->
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="adddiscount" class="control-label">Discount</label>

                                    <div class="">
                                        <input type="text" class="form-control"
                                               id="adddiscount" placeholder="Discount" value="0"
                                               name="discount" autocomplete="off" required>
                                    </div>
                                </div> <!-- /form-group-->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="addquantity" class="control-label">Quantity #</label>

                                    <div class="">
                                        <input type="number" min="1" max="100" class="form-control" id="addquantity"
                                               placeholder="Quantity" name="qty" autocomplete="off" required>
                                    </div>
                                </div> <!-- /form-group-->
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="addmeasure" class="control-label">Unit measure</label>

                                    <div class="">
                                        <input type="text" class="form-control" id="addmeasure"
                                               placeholder="Unit measure" name="measure" autocomplete="off" required>
                                    </div>
                                </div> <!-- /form-group-->
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="addminStock" class="control-label">Min stock</label>

                                    <div class="">
                                        <input type="number" min="1" max="100" class="form-control" id="addminStock"
                                               placeholder="Minimum stock alert" name="minStock" autocomplete="off"
                                               required>
                                    </div>
                                </div> <!-- /form-group-->
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="addstatus" class="control-label">Status</label>

                                    <div class="">
                                        <select name="status" class="form-control" id="addstatus" required>
                                            <option value="">--select--</option>
                                            <option value="Available">Available</option>
                                            <option value="Not Available">Not Available</option>
                                            <option value="Not Active">Not Active</option>
                                        </select>
                                    </div>
                                </div> <!-- /form-group-->
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="addescription" class="control-label">Description</label>

                            <div class="">
                                <textarea name="description" placeholder="Description" id="addescription"
                                          class="form-control"></textarea>
                            </div>
                        </div> <!-- /form-group-->
                    </div> <!-- /modal-body -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="createBtn"
                                data-loading-text="Loading...">
                            <i class="glyphicon glyphicon-ok-sign"></i> Save Changes
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                    class="glyphicon glyphicon-remove-sign"></i> Close
                        </button>
                    </div> <!-- /modal-footer -->
                </form> <!-- /.form -->
            </div> <!-- /modal-content -->
        </div> <!-- /modal-dailog -->
    </div>
    <!-- /add products -->

    <!-- edit product  -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="validate-form" method="post" id="editProductForm"
                      action="{{ route('products.update') }}" enctype="multipart/form-data" novalidate>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title"><i class="glyphicon glyphicon-pencil"></i> Edit product</h4>
                    </div>
                    <div class="modal-body">
                        <div class="modal-loading div-hide"
                             style="width: 50px;margin: auto;padding-top: 50px;padding-bottom: 50px;">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div class="edit-result">
                            <!-- TABS PILL STYLE -->
                            <ul class="nav nav-pills" role="tablist">
                                <li class="">
                                    <a href="#profile" role="tab" data-toggle="tab" aria-expanded="true">
                                        <i class="fa fa-folder"></i>
                                        Image
                                    </a>
                                </li>
                                <li class="active">
                                    <a href="#productInfo" role="tab" data-toggle="tab" aria-expanded="false">
                                        <i class="fa fa-info-circle"></i>
                                        Info
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="edit-messages" class="text-success text-center center-block"></div>
                                <div class="tab-pane fade " id="profile">
                                    <div class="form-group">
                                        <label for="productImage" class="control-label">Product Image</label>

                                        <div class="" style="max-height: 300px;">
                                            <img src="" alt="Image " class="img-thumbnail img-responsive product-image"
                                                 style="overflow: scroll">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="productImage" class="control-label">Select Image</label>

                                        <div class="">
                                            <button type="button"
                                                    class="btn btn-info btn-sm btn-block btn-upload-photo"><i
                                                        class="fa fa-folder"></i>
                                                Choose Photo
                                            </button>
                                            <input type="file" name="image" class="sr-only filePhoto">
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade active in" id="productInfo">
                                    @csrf
                                    <div class="form-group">
                                        <label for="editName" class="control-label">Product Name</label>

                                        <div class="">
                                            <input type="text" class="form-control" id="editName"
                                                   placeholder="Product Name"
                                                   name="name" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="editCategory" class="control-label">Category Name</label>

                                        <div class="">
                                            <select name="category" class="form-control" id="editCategory" required>
                                                <option value="">--select--</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> <!-- /form-group-->

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editPrice" class="control-label">Price</label>

                                                <div class="">
                                                    <input type="text" class="form-control" id="editPrice"
                                                           placeholder="Price"
                                                           name="price" autocomplete="off" required>
                                                </div>
                                            </div> <!-- /form-group-->
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editDiscount" class="control-label">Discount</label>

                                                <div class="">
                                                    <input type="text" class="form-control"
                                                           id="editDiscount" placeholder="Discount" value="0"
                                                           name="discount" autocomplete="off" required>
                                                </div>
                                            </div> <!-- /form-group-->
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editQty" class="control-label">Quantity #</label>

                                                <div class="">
                                                    <input type="number" min="1" max="100" class="form-control"
                                                           id="editQty"
                                                           placeholder="Quantity" name="qty" autocomplete="off"
                                                           required>
                                                </div>
                                            </div> <!-- /form-group-->
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editMeasure" class="control-label">Unit measure</label>

                                                <div class="">
                                                    <input type="text" class="form-control" id="editMeasure"
                                                           placeholder="Unit measure" name="measure" autocomplete="off"
                                                           required>
                                                </div>
                                            </div> <!-- /form-group-->
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editMinStock" class="control-label">Min stock</label>

                                                <div class="">
                                                    <input type="number" min="1" max="100" class="form-control"
                                                           id="editMinStock"
                                                           placeholder="Minimum stock alert" name="minStock"
                                                           autocomplete="off"
                                                           required>
                                                </div>
                                            </div> <!-- /form-group-->
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="editStatus" class="control-label">Status</label>

                                                <div class="">
                                                    <select name="status" class="form-control" id="editStatus" required>
                                                        <option value="">--select--</option>
                                                        <option value="Available">Available</option>
                                                        <option value="Not Available">Not Available</option>
                                                        <option value="Not Active">Not Active</option>
                                                    </select>
                                                </div>
                                            </div> <!-- /form-group-->
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="editDescription" class="control-label">Description</label>

                                        <div class="">
                                            <textarea name="description" placeholder="Description"
                                                      id="editDescription" class="form-control"></textarea>
                                        </div>
                                    </div> <!-- /form-group-->

                                </div>
                            </div>
                        </div>
                        <!-- END TABS PILL STYLE -->
                    </div> <!-- /modal-body -->

                    <div class="modal-footer  editFooter">
                        <button type="submit" class="btn btn-primary" id="editBtn" data-loading-text="Loading...">
                            <i class="glyphicon glyphicon-ok-sign"></i> Save Changes
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <i class="glyphicon glyphicon-remove-sign"></i>Close
                        </button>
                    </div> <!-- /modal-footer -->
                </form> <!-- /.form -->
            </div> <!-- /modal-content -->
        </div> <!-- /modal-dailog -->
    </div>
    <!-- /  -->

@endsection

@section('scripts')
    <script>

        var defaultUrl = "{{ route('products.all')  }}";
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
                    {
                        data: 'image', 'sortable': false,
                        render: function (data, type, row) {
                            return "<img src='" + data + "' class='img-responsive img-circle prod-img img-thumbnail' />"
                        }
                    },
                    {data: 'name', 'sortable': false},
                    {data: 'category', 'sortable': false},
                    {data: 'measure', 'sortable': false},
                    {data: 'price', 'sortable': false},
                    {data: 'qty', 'sortable': false},
                    {data: 'minStock', 'sortable': false},
                    {
                        data: 'status', 'sortable': false,
                        render: function (data, type, row) {
                            if (data === 'Available') {
                                return '<span class="label label-success">' + data + '</span>';
                            } else if (data === 'Not Active') {
                                return '<span class="label label-danger">' + data + '</span>';
                            }
                            return '<span class="label label-warning">' + data + '</span>';
                        }
                    },
                    {
                        data: 'id',
                        'sortable': false,
                        render: function (data, type, row) {
                            return "<div class='btn-group btn-group-sm'>" +
                                "<button class='btn btn-default js-edit' " +
                                "data-url='/admin/products/show/" + row.id + "' data-id='" + row.id + "'> " +
                                "<i class='glyphicon glyphicon-edit'></i></button>" +
                                "<button class='btn btn-danger  js-delete' data-id='" + data +
                                "' data-url='/admin/products/destroy/" + row.id + "'> " +
                                "<i class='glyphicon glyphicon-trash'></i>" +
                                "</button>" +
                                "</div>";
                        }
                    }
                ]
            });
        }


        $(document).ready(function () {
            $('.nav-products').addClass('active');
            myFunc();
            // photo upload
            $('.btn-upload-photo').on('click', function () {
                $(this).siblings('.filePhoto').trigger('click');
            });

            manageTable.on("click", ".js-edit", function () {
                var findUrl = $(this).attr("data-url");
                // remove hidden  id text
                $('#id').remove();
                // Launching edit modal
                $("#editModal").modal();
                // edit products messages
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
                    console.log(response);
                    // modal spinner
                    $('.modal-loading').addClass('div-hide');
                    // modal result
                    $('.edit-result').removeClass('div-hide');
                    //modal footer
                    footer.removeClass('div-hide');
                    // set the products name
                    $("#editName").val(response.name);
                    $("#editMeasure").val(response.measure);
                    $("#editCategory").val(response.category.id);
                    $("#editPrice").val(response.price);
                    $("#editQty").val(response.qty);
                    $("#editDescription").val(response.description);
                    $("#editMinStock").val(response.minStock);
                    $("#editStatus").val(response.status);
                    $("#editDiscount").val(response.discount);
                    // set the form value to be updated
                    var src = '/uploads/products/' + response.image;
                    $('.product-image').attr("src", src);
                    // add the products id
                    footer.after('<input type="hidden" name="id" id="id" value="' + response.id + '" />');
                }).fail(function (error) {
                    alert("Error getting data");
                });
                return false;
            });
            //submit add new  form
            $("#submitProductForm").submit(function (e) {
                e.preventDefault();
                var form = $(this);
                form.parsley().validate();
                if (!form.parsley().isValid()) {
                    return false;
                }


                var formData = new FormData(this);
                $("#createBtn").button('loading');
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                }).done(function (response) {
                    // button loading
                    $("#createBtn").button('reset');
                    //resetting form
                    form[0].reset();
                    // reload the manage member table
                    table.ajax.reload();
                    $('#add-messages').html('<div class="alert alert-success">' +
                        '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                        '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '
                        + " Product added successfully" + '</div>');
                    $(".alert-success").delay(500).show(10, function () {
                        $(this).delay(3000).hide(10, function () {
                            $(this).remove();
                            $("#addModal").modal('hide');
                        });
                    }); // /.alert
                }).fail(function () {
                    alert("Some errors");
                    $("#createBtn").button('reset');
                });
            });

            // submit of edit  form
            $("#editProductForm").submit(function (e) {
                e.preventDefault();
                var form = $(this);
                form.parsley().validate();
                if (!form.parsley().isValid()) {
                    return false;
                }

                var formData = new FormData(this);
                // button loading
                $("#editBtn").button('loading');
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                }).done(function (response) {
                    // button loading
                    $("#editBtn").button('reset');
                    form[0].reset();
                    // reload the manage member table
                    table.ajax.reload();

                    $('#edit-messages').html('<div class="alert alert-success">' +
                        '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                        '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' + "Product successfully updated" + '</div>');

                    $(".alert-success").delay(500).show(10, function () {
                        $(this).delay(3000).hide(10, function () {
                            $(this).remove();
                            $("#editModal").modal('hide');
                        });
                    }); // /.alert
                }).fail(function (error) {
                    alert("Some errors occurred");
                    $("#editBtn").button('reset');
                });
            });

            ///

            $('#btnDeleteSelected').click(function () {
                deleteData($(this).attr('data-url'));
            });

            function deleteData(deleteUrl) {
                var confirmButton = $('button.confirm');
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this data!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#007B00",
                    confirmButtonText: "Ok!",
                    closeOnConfirm: false
                }, function () {
                    confirmButton.button('loading');
                    var allVals = [];
                    $('input[name="products"]:checked').each(function () {
                        allVals.push($(this).val());
                    });
                    $.ajax({
                        url: deleteUrl,
                        data: {_token: token, ids: allVals},
                        method: 'DELETE'
                    }).done(function (response) {
                        confirmButton.button('reset');
                        swal({
                            title: "Deleted!",
                            text: "Records  have been deleted.",
                            type: "success",
                            confirmButtonColor: "#007B00",
                            confirmButtonText: "Close"
                        });
                        // reload the manage member table
                        table.ajax.reload();
                    }).fail(function (error) {
                        confirmButton.button('reset');
                        swal({
                            title: "Not Deleted!",
                            text: "Records are not deleted please try again later.",
                            type: "info",
                            confirmButtonColor: "#ff3f71",
                            confirmButtonText: "Ok ,Close"
                        });
                        confirmButton.button('reset');
                    });
                });
            }
        });
    </script>
@stop

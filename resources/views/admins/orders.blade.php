@extends('layouts.master')
@section('title','Orders')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="panel rounded-sm shadow-sm panel-default">
                <div class="panel-heading bg-white">
                    <h4 class="panel-title">
                        <i class="fa fa-square"></i> Manage Orders
                    </h4>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table table-condensed table-hover table-border rounded"
                           id="manageTable">
                        <thead>
                        <tr>
                            <th>Oder Date</th>
                            <th>Client Name</th>
                            <th>Client Phone</th>
                            <th>Payment Type</th>
                            <th>Amount</th>
                            <th>Order status</th>
                            <th>Payment status</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- edit product  -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal validate-form" method="post" id="editForm"
                      action="{{ route('orders.mark') }}" enctype="multipart/form-data" novalidate>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title"><i class="glyphicon glyphicon-pencil"></i>
                            Order details
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div id="edit-messages"></div>
                        <div class="modal-loading div-hide"
                             style="width: 50px;margin: auto;padding-top: 50px;padding-bottom: 50px;">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div class="edit-result">
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



    <!-- edit product  -->
    <div class="modal fade" id="verifyModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><i class="glyphicon glyphicon-pencil"></i>
                        Transaction details
                    </h4>
                </div>
                <div class="modal-body">

                    <div class="modal-loading div-hide"
                         style="width: 50px;margin: auto;padding-top: 50px;padding-bottom: 50px;">
                        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="verify-result"></div>
                    <!-- END TABS PILL STYLE -->
                </div> <!-- /modal-body -->

                <div class="modal-footer  editFooter">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="glyphicon glyphicon-remove-sign"></i>Close
                    </button>
                </div> <!-- /modal-footer -->

            </div> <!-- /modal-content -->
        </div> <!-- /modal-dailog -->
    </div>
    <!-- /  -->


@endsection

@section('scripts')
    <script>

        var defaultUrl = "{{ route('orders.index')  }}";
        var table;
        var manageTable = $("#manageTable");

        $(document).ready(function () {

            $('.nav-orders').addClass('active');

            window.dataTable = manageTable.DataTable({
                ajax: "{{ route('orders.index')  }}",
                serverSide: true,
                processing: true,
                "order": [[0, "desc"]],
                columns: [
                    {data: 'created_at', name: 'created_at'},
                    {data: 'clientName', name: 'clientName'},
                    {data: 'clientPhone', name: 'clientPhone'},
                    {data: 'payment_type', name: 'payment_type'},
                    {data: 'amount_to_pay', name: 'amount_to_pay', sortable: false, searchable: false},
                    {data: 'status', name: 'status'},
                    {data: 'payment_status', name: 'payment_status', sortable: false, searchable: false},
                    {data: 'action', name: 'action', sortable: false, searchable: false}
                ]
            });

            manageTable.on("click", ".js-verify", function () {

                $("#verifyModal").modal();
                $('.modal-loading').removeClass('div-hide');
                var editResultDiv = $('.verify-result');
                editResultDiv.addClass('div-hide');

                var footer = $(".editFooter");
                footer.addClass('div-hide');
                $.ajax({
                    url: $(this).data('url'),
                    method: 'GET',
                    success: function (response) {
                        $('.modal-loading').addClass('div-hide');
                        // modal result
                        editResultDiv.removeClass('div-hide');
                        //modal footer
                        footer.removeClass('div-hide');
                        editResultDiv.html(response);
                    }
                })
            });

            manageTable.on("click", ".js-details", function () {
                var findUrl = $(this).attr("data-url");
                // Launching edit modal
                $("#editModal").modal();
                // edit products messages
                $("#edit-messages").html("");
                // modal spinner
                $('.modal-loading').removeClass('div-hide');
                // modal result
                var editResultDiv = $('.edit-result');
                editResultDiv.addClass('div-hide');
                //modal footer
                var footer = $(".editFooter");
                footer.addClass('div-hide');
                $.ajax({
                    url: findUrl,
                    method: "get"
                }).done(function (response) {

                    // modal spinner
                    $('.modal-loading').addClass('div-hide');
                    // modal result
                    editResultDiv.removeClass('div-hide');
                    //modal footer
                    footer.removeClass('div-hide');
                    editResultDiv.html(response);
                }).fail(function (error) {
                    alert("Error getting data");
                });
                return false;
            });

        });
    </script>
@stop

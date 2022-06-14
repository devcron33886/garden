<?php

?>

@extends('layouts.app')

@section('title')
    My-orders
@endsection
@section('content')

    <link rel="stylesheet" type="text/css"
          href="{{ asset('vendor/datatables.net-bs/css/dataTables.bootstrap.min.css') }}"/>
    <br>
    <div class="section">
        <div class="container">
            <div class="row">
                <section class="cart-items col-md-12">
                    @if(Session::has('message'))
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="alert alert-success flat">
                                    <p>
                                        <i class="fa fa-check-circle"></i>
                                        {{ Session::get('message') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="panel panel-default flat">
                        <div class="panel-heading">
                            <h4>
                                <i class="fa fa-shopping-basket"></i>
                                My orders</h4>
                        </div>
                        <div class="panel-body">


                            <table class="table table-bordered" id="manageTable">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Shipping address</th>
                                    <th>Status</th>
                                    <th>Options</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>


                </section>

            </div>
        </div>
    </div>
    <br>
    <br>

    <!-- edit product  -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content flat">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title"><i class="fa fa-pencil"></i>
                            Order details
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div id="edit-messages"></div>
                        <div class="modal-loading div-hide" style="width: 50px;margin: auto;padding-top: 50px;padding-bottom: 50px;">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div class="edit-result">
                        </div>
                        <!-- END TABS PILL STYLE -->
                    </div> <!-- /modal-body -->

                    <div class="modal-footer  editFooter">
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="flat btn btn-default" data-dismiss="modal">
                                <i class="fa fa-remove"></i>Close
                            </button>
                        </div>
                    </div> <!-- /modal-footer -->
            </div> <!-- /modal-content -->
        </div> <!-- /modal-dailog -->
    </div>
    <!-- /  -->


    <script type="text/javascript" src="{{ asset('vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('vendor/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

<style>
    html,body{
        background-color: #f5f5f5 !important;
    }
</style>
    <script>

        var defaultUrl = "{{ route('myOrders')  }}";
        var table;
        var manageTable = $("#manageTable");

        function myFunc() {
            table = manageTable.DataTable({
                "bProcessing": true,
                "serverSide": true,
                ajax: {
                    url: defaultUrl,
                    method: 'POST',
                    dataSrc: 'data',
                    data: {_token: "{{csrf_token()}}"}
                },
                columns: [
                    {data: 'created_at', 'sortable': false},
                    {data: 'shipping_address', 'sortable': false},
                    {
                        data: 'status', 'sortable': false,
                        render: function (data, type, row) {
                            if (data === 'Pending') {
                                return '<span class="label label-primary">' + data + '</span>';
                            } else if (data === 'Delivered') {
                                return '<span class="label label-success">' + data + '</span>';
                            } else {
                                return '<span class="label label-info">' + data + '</span>';
                            }
                        }
                    },
                    {
                        data: 'id',
                        'sortable': false,
                        render: function (data, type, row) {
                            return "<div class='btn-group btn-group-sm'>" +
                                "<button class='btn btn-default flat btn-xs  js-details' " +
                                "data-url='/admin/orders/" + row.id + "' data-id='" + row.id + "'> " +
                                "<i class='fa fa-eye'></i> Details</button>" +
                                "</div>";
                        }
                    }
                ]
            });
        }


        $(document).ready(function () {
            $('.nav-categories').addClass('active');
            myFunc();

            manageTable.on("click", ".js-details", function () {
                var findUrl = $(this).attr("data-url");
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
                    method: "get"
                }).done(function (response) {

                    // modal spinner
                    $('.modal-loading').addClass('div-hide');
                    // modal result
                    $('.edit-result').removeClass('div-hide');
                    //modal footer
                    footer.removeClass('div-hide');
                    $('.edit-result').html(response);
                }).fail(function (error) {
                    alert("Error getting data");
                });
                return false;
            });


        });
    </script>

@endsection
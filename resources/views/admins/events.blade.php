@extends('layouts.master')
@section('title','Categories')
@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote.css') }}">
@endsection
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel flat">
                    <div class="panel-heading flat">
                        <h4 class="panel-title">
                            Event
                        </h4>
                    </div>
                    <form action="{{ route('events.update') }}" method="post">
                        @csrf
                        @method('put')
                        <input type="hidden" name="id" id="id" value="{{ $event->id }}">
                        <div class="panel-body panel-content">
                            <div class="form-group">
                                <label for="eventDescription" id="eventDescription">Description</label>
                                <textarea name="description" class="form-control summernote" id="eventDescription"
                                          cols="30"
                                          rows="10">{{$event->description}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="editEventActive" class="control-label"></label>
                                <label class="col-sm-1 control-label"> </label>
                                <div>
                                    <div class="fancy-checkbox">
                                        <label>
                                            <input {{ $event->active?'checked':'' }} type="checkbox" id="editEventActive" name="active">
                                            <span> Show event</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success">Save changes</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form novalidate class="" id="editForm" action="{{ route('events.update') }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-pencil"></i> Edit event</h4>
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
                                <label for="editEventName" class="control-label">Event Name</label>
                                <div>
                                    <input required type="text" class="form-control" id="editEventName"
                                           placeholder="Event Name" name="name" autocomplete="off">
                                </div>
                            </div> <!-- /form-group-->
                            {{-- <div class="form-group">
                                 <label for="editEventDate" class="control-label">Event Date</label>

                                 <div>
                                     <input required type="date" class="form-control" id="editEventDate" placeholder="Event Date" name="date" autocomplete="off">
                                 </div>
                             </div> <!-- /form-group-->--}}
                            <div class="form-group">
                                <label for="editEventDescription" class="control-label">Event Description</label>

                                <div>
                                    <textarea required class="form-control" id="editEventDescription"
                                              placeholder="Event Description" name="description"
                                              autocomplete="off"></textarea>
                                </div>
                            </div> <!-- /form-group-->
                            <div class="form-group">
                                <label for="editEventActive" class="control-label"></label>
                                <label class="col-sm-1 control-label"> </label>
                                <div>
                                    <div class="fancy-checkbox">
                                        <label>
                                            <input type="checkbox" id="editEventActive" name="active">
                                            <span> Show event</span>
                                        </label>
                                    </div>
                                </div>
                            </div> <!-- /form-group-->
                        </div>
                        <!-- /edit brand result -->

                    </div> <!-- /modal-body -->

                    <div class="modal-footer editFooter">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                        class="glyphicon glyphicon-remove-sign"></i> Close
                            </button>

                            <button type="submit" class="btn btn-primary" id="editBtn" data-loading-text="Loading..."><i
                                        class="glyphicon glyphicon-ok-sign"></i> Save Changes
                            </button>
                        </div>
                    </div>
                    <!-- /modal-footer -->
                </form>
                <!-- /.form -->
            </div>
            <!-- /modal-content -->
        </div>
        <!-- /modal-dailog -->
    </div>


@endsection

@section('scripts')
    <script src="{{ asset('vendor/summernote/summernote.min.js') }}"></script>
    <script>

        var defaultUrl = "{{ route('events.all')  }}";
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
                    {data: 'name', 'sortable': false},
                    // {data: 'date', 'sortable': false},
                    {data: 'description', 'sortable': false},
                    {
                        data: 'active', 'sortable': false,
                        render: function (data) {
                            if (data) {
                                return "<span class='label label-info'>Yes</span>";
                            }
                            return "<span class='label label-warning'>No</span>";
                        }
                    },
                    {
                        data: 'id',
                        'sortable': false,
                        render: function (data, type, row) {
                            return "<div class='btn-group btn-group-sm'>" +
                                "<button class='btn btn-default btn-sm flat js-edit' " +
                                "data-url='/admin/events/show/" + row.id + "' data-id='" + row.id + "'> " +
                                "<i class='glyphicon glyphicon-edit'></i></button>";
                        }
                    }
                ]
            });
        }


        $(document).ready(function () {
            $('.nav-events').addClass('active');
            myFunc();

            $('.summernote').summernote({
                height: 150,
                focus: true,
                onpaste: function () {
                    alert('You have pasted something to the editor');
                }
            });

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
//                    console.log(response);
                    // modal spinner
                    $('.modal-loading').addClass('div-hide');
                    // modal result
                    $('.edit-result').removeClass('div-hide');
                    //modal footer
                    footer.removeClass('div-hide');
                    // set the categories name
                    $("#editEventName").val(response.name);
                    $("#editEventDate").val(response.date);
                    $("#editEventDescription").val(response.description);
                    $("#editEventActive").prop('checked', response.active);
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
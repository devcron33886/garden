@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="panel panel-default rounded-sm shadow-sm">
            <div class="panel-heading bg-white"
                 style="display: flex;align-items: center;justify-content: space-between;border-bottom: 1px solid #F8F8F8">
                <h4>
                    <i class="fa fa-square"></i>
                    Emails
                </h4>
                <button type="button" class="btn btn-danger btn-sm">
                    <i class="fa fa-plus"></i>
                    Compose
                </button>
            </div>

            <div class="panel-body">
                <table class="table table-hover table-border rounded-sm" id="manageTable">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($newsletters as $item)
                        <tr>
                            <td>{{$item->created_at}}</td>
                            <td>
                                <a href="mailto:{{$item->email}}">
                                    {{$item->email}}
                                </a>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-danger btn-xs" disabled>
                                    Compose
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            $('.nav-newsletters').addClass('active');
            $('#manageTable').dataTable();
        });
    </script>
@endsection

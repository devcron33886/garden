@extends('layouts.master')
@section('title','Settings')

@section('styles')

@endsection

@section('content')

    <div class="panel">
        <div class="panel-heading">
            <h4 class="panel-title">
                <i class="fa fa-wrench"></i>
                Settings
            </h4>
        </div>
        <hr>
        <div class="panel-body">
            <div id="div-message">

            </div>

            <form method="post" novalidate action="{{ route('admin.settings.save') }}" id="saveSettingsForm"
                  class="form-horizontal" autocomplete="off">

                {{--company name--}}
                <div class="form-group">
                    <label class="control-label col-sm-2" for="company_name">
                        Company name
                    </label> <label class="control-label col-sm-1" for="company_name">:</label>
                    <div class="col-sm-9">
                        <input type="text" name="company_name" id="company_name" value="{{ $setting->company_name }}"
                               class="form-control" placeholder="Company name" required>
                    </div>
                </div>
                {{--company email--}}
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email1">
                        Email 1
                    </label> <label class="control-label col-sm-1" for="email1">:</label>
                    <div class="col-sm-9">
                        <input type="email" name="email1" id="email1" value="{{ $setting->email1 }}"
                               class="form-control" placeholder="Email address" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email2">
                        Email 2
                    </label> <label class="control-label col-sm-1" for="email2">:</label>
                    <div class="col-sm-9">
                        <input type="email" name="email2" id="email2" value="{{ $setting->email2 }}"
                               class="form-control" placeholder="Email address" required>
                    </div>
                </div>
                {{--company phone--}}
                <div class="form-group">
                    <label class="control-label col-sm-2" for="phoneNumber1">
                        Phone number 1
                    </label>
                    <label class="control-label col-sm-1" for="phoneNumber1">:</label>
                    <div class="col-sm-9">
                        <input type="text" minlength="10" maxlength="13" name="phoneNumber1" id="phoneNumber1"
                               value="{{ $setting->phoneNumber1 }}" class="form-control" placeholder="Phone number"
                               required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="phoneNumber2">
                        Phone number 2
                    </label> <label class="control-label col-sm-1" for="phoneNumber2">:</label>
                    <div class="col-sm-9">
                        <input type="text" minlength="10" maxlength="13" name="phoneNumber2" id="phoneNumber2"
                               value="{{ $setting->phoneNumber2 }}" class="form-control" placeholder="Phone number"
                               required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="whatsapp">
                        Whatsapp
                    </label> <label class="control-label col-sm-1" for="whatsapp">:</label>
                    <div class="col-sm-9">
                        <input type="text" minlength="10" maxlength="13" name="whatsapp" id="whatsapp"
                               value="{{ $setting->whatsapp }}" class="form-control" placeholder="Phone number"
                               required>
                    </div>
                </div>
                {{--company name--}}
                <div class="form-group">
                    <label class="control-label col-sm-2" for="address">
                        Address
                    </label> <label class="control-label col-sm-1" for="address">:</label>
                    <div class="col-sm-9">
                        <input type="text" name="address" id="address" value="{{ $setting->address }}"
                               class="form-control" placeholder="address" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="shipping_amount">
                        Shipping amount
                    </label>
                    <label class="control-label col-sm-1" for="shipping_amount">:</label>
                    <div class="col-sm-9">
                        <input type="number" name="shipping_amount" id="shipping_amount"
                               value="{{ $setting->shipping_amount }}" class="form-control"
                               placeholder="Shipping amount" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="about">
                        About us
                    </label> <label class="control-label col-sm-1" for="about">:</label>
                    <div class="col-sm-9">
                        <textarea rows="7" name="about" id="about" class="form-control" placeholder="About us"
                                  required>{{ $setting->about }}</textarea>
                    </div>
                </div>

                {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-sm btn-danger" id="btnSave">
                            <i class="fa fa-check-circle"></i>
                            Save changes
                        </button>
                    </div>
                </div>


            </form>


        </div>

    </div>

@endsection
@section('scripts')
    <script>
        $('.nav-settings').addClass('active');

        $(function () {
            $('#saveSettingsForm').on('submit', function (e) {
                e.preventDefault();

                var form = $(this);
                form.parsley().validate();
                if (!form.parsley().isValid()) {
                    return false;
                }

                var btn = $('#btnSave');

                var method = form.attr('method');
                var url = form.attr('action');


                btn.button('loading');

                $.ajax({
                    url: url,
                    data: form.serialize(),
                    method: method
                }).done(function () {
                    $('#div-message').html(' <div class="alert alert-success alert-dismissible" role="alert"> ' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span></button> ' +
                        '<strong>Success!</strong> Data successfully saved </div>');
                    btn.button('reset');
                }).fail(function () {
                    $('#div-message').html(' <div class="alert alert-danger alert-dismissible" role="alert"> ' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span></button> ' +
                        '<strong>Fail! </strong> Data not successfully saved </div>');
                    btn.button('reset');
                });

            });
        });
    </script>
@endsection


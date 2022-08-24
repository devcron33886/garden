try {
    let $ = require('jquery');
    window.$ = $;
    window.jQuery = $;
    require('bootstrap');
    require('../../public/vendor/datatables.net/js/jquery.dataTables.min.js');
    require('../../public/vendor/datatables.net-bs/js/dataTables.bootstrap.min.js');

    require('../../public/vendor/metisMenu/metisMenu.js');
    require('../../public/vendor/parsleyjs/js/parsley.min.js');
    require('../../public/vendor/jquery-slimscroll/jquery.slimscroll.min.js');
    require('../../public/vendor/sweetalert/sweetalert.min.js');
    require('../../public/js/common.js');
} catch (e) {
    console.log(e);
}


function printDoc() {
    window.print();
}

var token;
$(function () {
    token = $('#token').val();


    $(document).find('[data-toggle="tooltip"]').tooltip();

    $('.printBtn').click(function () {
        printDoc();
    });


    //submit  form
    $("#submitForm").submit(function (e) {
        e.preventDefault();
        var form = $(this);
        form.parsley().validate();
        if (!form.parsley().isValid()) {
            return false;
        }

        var button = $("#createBtn");
        button.button('loading');
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize()
        }).done(function (response) {
            // button loading
            button.button('reset');
            // reload the manage member table
            form[0].reset();

            if (dataTable)
                dataTable.ajax.reload(null);
            else
                table.ajax.reload(null);

            $('#add-messages').html('<div class="alert alert-success">' +
                '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '
                + " Record added successfully" + '</div>');
            $(".alert-success").delay(500).show(10, function () {
                $(this).delay(3000).hide(10, function () {
                    $(this).remove();
                });
            }); // /.alert
        }).fail(function (error) {
            button.button('reset');
            $('#add-messages').html('<div class="alert alert-danger">' +
                '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' + "Unable to save record" + '</div>');

            $(".alert-danger").delay(500).show(10, function () {
                $(this).delay(3000).hide(10, function () {
                    $(this).remove();
                });
            }); // /.alert
        });
    });

    // submit of edit categories form
    $("#editForm").submit(function (e) {
        e.preventDefault();
        var form = $(this);

        form.parsley().validate();
        if (!form.parsley().isValid()) {
            return false;
        }

        // button loading
        var btn = $("#editBtn");
        btn.button('loading');
        $.ajax({
            url: form.attr('action'),
            type: 'PUT',
            data: form.serialize()
        }).done(function (response) {
            // button loading
            btn.button('reset');
            // reload the manage member table
            if (dataTable) {
                dataTable.ajax.reload(null);
            } else {
                table.destroy();
                myFunc();
            }

            $('#edit-messages').html('<div class="alert alert-success">' +
                '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' + "Record successfully updated" + '</div>');

            $(".alert-success").delay(500).show(10, function () {
                $(this).delay(3000).hide(10, function () {
                    $(this).remove();
                });
            }); // /.alert
        }).fail(function (error) {
            btn.button('reset');
            $('#edit-messages').html('<div class="alert alert-danger">' +
                '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' + "Unable to update record" + '</div>');

            $(".alert-danger").delay(500).show(10, function () {
                $(this).delay(3000).hide(10, function () {
                    $(this).remove();
                });
            }); // /.alert
        });
    });


});


// delete button click
$(document).on("click", ".js-delete", function () {
    var deleteUrl = $(this).attr("data-url");
    var button = $(this);
    deleteWithUrl(deleteUrl, button, table);
});

function deleteWithUrl(deleteUrl, button, table) {
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
        $.ajax({
            url: deleteUrl,
            data: {_token: token},
            method: 'DELETE'
        })
            .done(function (response) {
                confirmButton.button('reset');
                swal({
                    title: "Deleted!",
                    text: "Record  has been deleted.",
                    type: "success",
                    confirmButtonColor: "#007B00",
                    confirmButtonText: "Close"
                });
                // reload the manage member table
                var tr = button.parents("tr");
                table.rows(tr).remove().draw(false);
            })
            .fail(function (error) {
                confirmButton.button('reset');
                swal({
                    title: "Not Deleted!",
                    text: "Record is not deleted please try again later.",
                    type: "info",
                    confirmButtonColor: "#ff3f71",
                    confirmButtonText: "Ok ,Close"
                });
            });

    });
}

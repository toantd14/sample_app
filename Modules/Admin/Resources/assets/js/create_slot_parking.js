$(document).ready(function () {
    let linkPrev = $("#slot-paginate .page-item:first-child a").attr("href");
    let linkNext = $("#slot-paginate .page-item:last-child a").attr("href");

    $("#prev-page").attr("href", linkPrev);
    $("#next-page").attr("href", linkNext);

    $(document).on('click', ".cancel", function cancel() {
        if (confirm(messConfirmExit)) {
            location.href = $(this).attr("link");
        }
    });

    function validateCarType() {
        let conditions = !$("input[name='car_type[kbn_3no]']").is(':checked') &&
            !$("input[name='car_type[kbn_lightcar]']").is(':checked') &&
            !$("input[name='car_type[kbn_standard]']").is(':checked');
        if (conditions) {
            $("#car_type_error_edit").show();
            $("#car_type_error_edit").text(messageSelected);
        }

        return conditions;
    }
    $("#modalParkingExist").modal("hide");
    $(".edit-slot-parking").click(function () {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
        let url = $(this).attr("link");
        let type = "GET";
        let data = null;
        let btnEdit = $(this);
        $("option:selected").prop("selected", false);
        callAjax(url, type, data)
            .done(function (dataResponse) {
                $(".box-add").addClass("d-none");
                $(".box-edit")
                    .children("form")
                    .remove();
                $(".box-edit").append(dataResponse);
                $("#form-edit").validate({
                    rules: {
                        "parking_form": {
                            required: true,
                        },
                        "car_width": {
                            required: true,
                        },
                        "car_type[kbn_standard]": {
                            required: function (element) {
                                return validateCarType();
                            },
                        },
                        "car_type[kbn_3no]": {
                            required: function (element) {
                                return validateCarType();
                            },
                        },
                        "car_type[kbn_lightcar]": {
                            required: function (element) {
                                return validateCarType();
                            },
                        },
                        "car_length": {
                            required: true,
                        },
                        "car_height": {
                            required: true,
                        },
                        "car_weight": {
                            required: true,
                        },
                        "space_symbol": {
                            required: true,
                        },
                        "space_no_from": {
                            required: true,
                        },
                        "space_no_to": {
                            required: true,
                        },
                    },
                    messages: {
                        parking_form: messageSelected,
                    },
                    submitHandler: function (form) {
                        if ($("#form-edit").valid()) {
                            $('#modalConfirmEdit').modal('show')
                            $("#submit-edit").on("click", function submitEdit() {
                                //Remove all error from [form-edit.blade]
                                $(".error").text("");

                                let dataEdit = $("#form-edit").serialize();
                                let urlEdit = $("#form-edit").attr("action");
                                let typeEdit = "PUT";
                                callAjax(urlEdit, typeEdit, dataEdit)
                                    .done(function (response) {
                                        let newData = transformDataToObject(
                                            "form-edit"
                                        );
                                        let serialNo = btnEdit.attr("data-serial-no");
                                        $('#content-notification').text(response.success)
                                        $('#notification-update-completed').modal();
                                    })
                                    .fail(function (response) {
                                        let errors = response.responseJSON.errors;
                                        $.each(errors, function (index, value) {
                                            $("." + index + "_error").text(value);
                                        });

                                        if (response.status === 400) {
                                            $('#modal_space_no').text($('#space_no_from').val());
                                            $('#modal_space_symbol').text($('#space_symbol').val());
                                            $('#exampleModalLabel').text(response.responseJSON.error);
                                            $("#modalParkingExist").modal("show");
                                        }
                                    });
                            });
                            $(".cancel").click(function cancel() {
                                if (confirm(messConfirmExit)) {
                                    location.href = $(this).attr("link");
                                }
                            });
                        }
                    }
                });
            })
            .fail(function (dataResponse) {
                let errors = dataResponse.responseJSON.errors;
            });
    });



    function transformDataToObject(formId) {
        let object = {};
        let data = $("#" + formId).serializeArray();
        $.each(data, function () {
            if (object[this.name]) {
                if (!object[this.name].push) {
                    object[this.name] = [object[this.name]];
                }
                object[this.name].push(this.value || "");
            } else {
                object[this.name] = this.value || "";
            }
        });
        return object;
    }

    $('#close-notification').on('click', function () {
        location.reload();
    })

    $('#notification-update-completed').on('hide.bs.modal', function () {
        location.reload();
    })
});

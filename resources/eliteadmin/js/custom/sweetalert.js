$(document).ready(function () {
    const Swal = require('sweetalert2');

    let optionsAlert = {
        title: 'Sistema',
        html:'Información para el usuario.',
        customClass: {
            confirmButton: 'btn btn-info mx-1',
            cancelButton: 'btn btn-danger mx-1'
        },
        buttonsStyling: false
    };

    window.swalAlertConfirm = function (message, title) {
        let selectOptions = {
                title: title,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'confirmar',
                cancelButtonText: 'cancelar',
                html: message,
            },
            currentOptions = $.extend(true, optionsAlert, selectOptions);

        return Swal.fire(currentOptions);
    }

    window.swalAlertInfo = function (message, title) {
        let selectOptions = {
                title: title,
                icon: 'info',
                showCancelButton: false,
                confirmButtonText: 'Ok',
                html: message,
            },
            currentOptions = $.extend(true, optionsAlert, selectOptions);

        return Swal.fire(currentOptions);
    }
});

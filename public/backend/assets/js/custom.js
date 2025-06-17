"use strict";
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Select all checkboxes
$('#selectAll').on('change', function () {
    $('.record-checkbox').prop('checked', this.checked);
});

function preloadershow(targetElementId) {
    const loadingSpinnerHTML = `
        <div class="text-center">
            <div id="loadingSpinner" class="spinner-border m-5 text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
    $(`#${targetElementId}`).html(loadingSpinnerHTML);
}

function spinnershow(targetElementId) {
    const loadingSpinnerHTML = `
        <div class="text-center" style="min-height: 350px; transform: translate(0%, 33%);">
            <div id="loadingSpinner" class="spinner-border m-5 text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
    $(`#${targetElementId}`).html(loadingSpinnerHTML); // Show the spinner
}

// Open modal programmatically with options
const modal = new bootstrap.Modal(document.getElementById('viewModalData'), {
    backdrop: 'static', // Prevent closing on outside click
    keyboard: false     // Prevent closing on Escape key
});

// Open modal programmatically with options
const modalSm = new bootstrap.Modal(document.getElementById('viewSmModalData'), {
    backdrop: 'static', // Prevent closing on outside click
    keyboard: false     // Prevent closing on Escape key
});

function modalcontentshow(){
    $('#viewModalData').modal("show");
}

function modalcontenthide(){
    $('#viewModalData').modal("hide");
}

function toastr_default(){
    let option = {
        "closeButton": true,
    }
    return option;
}

function toastr_option(){
    let option = {
        "timeOut": 10000,
        "positionClass": "toast-bottom-right",
        "closeButton": true,
    }
    return option;
}

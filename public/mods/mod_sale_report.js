$(function () {
    $('.flatpickr-range').flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
        mode: 'range'
    });
})

$('.print-pdf').on('click', function () {
    let date = $('input[name="daterange"]').val().split(' - ');
    if (date == null) {
        showToast('danger', 'Harap isi tanggal terlebih dahulu');
    } else {
        let fromDate = date[0].split('/').reverse().join('-');
        let toDate = date[1].split('/').reverse().join('-');
        window.open(
            `${$('meta[name=base-url]').attr(
                'content'
            )}/administrator/report/jurnal-report/export/pdf?from=${fromDate}&to=${toDate}`
        );
    }
});

$('#formSubmit').unbind().on('submit', function (e) {
    e.preventDefault();
    var el = $(this);
    var oldHtml = $(this).find('button[type="submit"').html();
    $(this).find('button[type="submit"').attr("disabled", "disabled");
    $(this).find('button[type="submit"').html("Loading...");

    $.ajax({
        url: $(this).attr("action"),
        method: $(this).attr("method"),
        data: new FormData(this),
        dataType: "html",
        contentType: false,
        processData: false,
        success: function (data) {
            $(el).find('button[type="submit"').removeAttr("disabled");
            $(el).find('button[type="submit"').html(oldHtml);
            $('.no-data').addClass('d-none')
            if (data == '') {
                $('.no-data').removeClass('d-none')
                $('#content-report').html('');
            } else {
                $('#content-report').html(data);
            }
        },
        error: function (xhr) {
            $(el).find('button[type="submit"').removeAttr("disabled");
            $(el).find('button[type="submit"').html(oldHtml);
            showToast('danger', 'Error tidak diketahui');
        },
    });
});

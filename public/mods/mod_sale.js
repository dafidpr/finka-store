$(function () {
    var form = $('#firstColumn').clone();

    scanAutonumeric();
    scanSubtotalNumeric()

    $('#addForm')
        .unbind()
        .on('click', function () {
            const form2 = $(form).clone();
            $(addRenderColumn).append(form2);
            $(form2)
                .children('.button-form')
                .children('button')
                .removeAttr('data-transaction-child-id');

            eventSumPrice();
            eventSumQty();
            deleteColumn();
            $(form2).children('.input-name').children('input').val('');
            $(form2).children('.input-price').children('input').val('');
            $(form2).children('.input-qty').children('input').val('');
            $(form2).children('.input-subtotal').children('input').val('');
            scanAutonumeric();

        });

    $.each($('.datepicker-here'), function (i, e) {
        $(e)
            .datepicker({
                language: 'en',
                dateFormat: 'dd-mm-yyyy',
            })
            .data('datepicker')
            .selectDate(
                $(e).val() != '' ? new Date($(e).val()) : new Date(Date.now())
            );
    });

    eventSumPrice();
    eventSumQty();
    deleteColumn();
    // calcDiscount();
    calcPayment();

});

function scanAutonumeric() {
    $.each($('.autonumeric'), function (i, e) {
        if (!AutoNumeric.isManagedByAutoNumeric(e)) {
            new AutoNumeric(e, {
                currencySymbol: 'Rp. ',
                decimalPlaces: '0',
            });
        }
    });
}

function scanSubtotalNumeric() {
    var value = 0;
    $.each($('.subtotal'), function (i, e) {
        value = $(e).val();
        $(e).val(formatNum(value));
    });
}

function eventSumPrice() {
    $('.price')
        .unbind()
        .on('keyup click', function () {
            sumSale();
        });
}

function eventSumQty() {
    $('.qty')
        .unbind()
        .on('keyup click', function () {
            sumSale();
        });
}

function sumSale(isTotal = false) {
    var total = 0;
    var subtotal = 0
    $.each($('.price'), (key, val) => {
        subtotal = $('.qty').eq(key).val() * stripCharacter($(val).val() == '' ? '0' : $(val).val());
        $('.subtotal').eq(key).val(formatNum(subtotal));
        total += subtotal;
    });
    if (isTotal == false) {

        $('#total').html(`Rp. ${formatNum(total)}`);
    } else {
        return total;
    }
}

function deleteColumn() {
    $('.removeColumn')
        .unbind()
        .on('click', function () {
            if ($('tr').length > 2) {
                $(this).parent().parent().remove();
                sumSale();

                let transactionChildId = $(this).data('transaction-child-id');
                if (
                    transactionChildId != null ||
                    transactionChildId != undefined
                ) {
                    $(`#transaction-child-id-${transactionChildId}`).remove()
                    $.ajax({
                        method: 'delete',
                        url: `${$('meta[name="base-url"]').attr(
                            'content'
                        )}/administrator/sales/${transactionChildId}/delete`,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content'
                            ),
                        },
                        dataType: 'json',
                        success: function (response) {},
                    });
                }
            } else {
                showToast('warning', 'Jumlah baris tidak boleh kurang dari 1');
            }
        });
}

function formatNum(number) {
    return Intl.NumberFormat().format(number);
}

function stripCharacter(number) {
    return parseInt(number.replace(/\D/g, '') || 0);
}

$('#payment-confirm-form').on('submit', async function (e) {
    try {
        $('.invalid-message').remove();
        e.preventDefault();

        $('.payment-bt')
            .html('Loading...')
            .attr('disabled', 'disabled');

        const data = await sendData($(this).attr('action'));

        if (data.status == 'success') {
            $('.modal').modal('hide');
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');

            showToast('success', 'Transaksi penjualan berhasil disimpan');
            var url = $('meta[name="base-url"]').attr('content') + '/administrator/sales/print?code=' + data.data.hashid;
            window.open(url, '_blank');

            if ($(this).data('success-callback')) {
                pushState($(this).data('success-callback'));
            }
        } else {
            if (data.errors) {
                for (const errKey in data.errors) {
                    if (errKey == 'pay_total') {
                        $(
                            `<span class="text-danger mt-1 d-inline-block invalid-message">${data.errors[errKey][0]}</span>`
                        ).insertAfter($(`#pay-total`));
                    }
                    showToast('danger', data.errors[errKey][0]);
                }
            } else {
                showToast('danger', data.message);
            }
            return;
        }
    } catch (err) {
        console.log(err);
        showToast('danger', 'Gagal menyimpan transaksi');
    } finally {
        $('.payment-bt')
            .html(`<i class="fa fa-paper-plane"></i> Payment`)
            .removeAttr('disabled');
    }
});

async function sendData(url) {
    generateFormBody();
    const resp = await fetch(url, {
        method: 'post',
        headers: {
            Accept: 'application/json',
            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content'),
        },
        body: generateFormBody(),
    });
    return await resp.json();
}

function generateFormBody() {
    const dataToSend = {
        grand_total: $('#grand-total-sale').val(),
        // discount: $('#discount-sale').val(),
        total_sale: $('#total-sale').val(),
        customer: $('#customer').val(),
        payment_method: $('#payment-method').val(),
        pay_total: $('#pay-total').val(),
        pay_return: $('#pay-return').val(),
        description: $('#description').val(),
    };

    const fd = new FormData($('#payment-form')[0]);

    for (const dataKey in dataToSend) {
        fd.append(dataKey, dataToSend[dataKey]);
    }

    return fd;
}

$('.payment').on('click', function () {
    var total = sumSale(true);
    $('#grand-total-sale').val(formatNum(total))
    $('#total-sale').val(formatNum(total))
    sumTotal();
    sumPayReturn();
});

// function calcDiscount() {

//     $('#discount-sale')
//         .unbind()
//         .on('keyup click', function () {
//             sumTotal();
//             sumPayReturn();
//         });
// }

function sumTotal() {
    var total = sumSale(true)
    // var calc = 0;
    // calc = total - stripCharacter($('#discount-sale').val());
    $('#total-sale').val(formatNum(total))
}

function sumPayReturn() {
    var total = $('#total-sale').val()
    var calc = 0;
    calc = stripCharacter($('#pay-total').val()) - stripCharacter(total);
    $('#pay-return').val(formatNum(calc))

}

function calcPayment() {
    $('#pay-total')
        .unbind()
        .on('keyup click', function () {
            sumPayReturn();
            sumTotal()
        });

}

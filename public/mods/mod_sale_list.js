if (typeof table == "undefined") {
    let table = null
}

table = initDataTable('#dataTable', [{
        name: 'id',
        data: 'hashid',
        sortable: false,
        searchable: false,
        mRender: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        },
    },
    {
        name: 'code',
        data: 'code',
    },
    {
        name: 'cashier',
        data: 'cashier',
    },
    {
        name: 'customer',
        data: 'customer',
    },
    {
        name: 'quantity',
        data: 'quantity',
        mRender: function (data, type, row) {
            return data + ' item';
        }
    },

    {
        name: 'subtotal',
        data: 'subtotal',
        mRender: function (data, type, row) {
            var total = data - row.discount;
            return ` Rp. ${total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}<br>
                    <span class="badge rounded-pill badge-soft-primary p-2"> 
                        <i class="bx bx-${row.payment_method == 'cash' ? 'money' : 'credit-card'}"> </i>
                        ${row.payment_method == 'cash' ? 'Cash' : 'Transfer'}
                    </span>
                     <span class="badge rounded-pill badge-soft-danger p-2"> 
                        Diskon Rp. ${row.discount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}
                    </span>`;
        }
    },
    {
        name: 'date',
        data: 'date',
    },
    {
        name: 'description',
        data: 'description',
        mRender: function (data, type, row) {
            return data == null ? '-' : data;
        }
    },
    {
        name: 'id',
        data: 'hashid',
        width: '150',
        sClass: 'text-center',
        sortable: false,
        mRender: function (data, type, row) {
            return `<button data-id="${data}" type="button" class="btn btn-sm btn-primary detail-bt" ><i class="bx bxs-file"></i></button>
                    <button class="btn btn-sm btn-warning" data-toggle="edit" data-id="${data}"><i class="bx bx-edit"></i></button>
                    <button class="btn btn-sm btn-danger" data-toggle="delete" data-id="${data}"><i class="bx bx-trash"></i></button>
                    <a href="${$('meta[name="base-url"]').attr('content') + '/administrator/sales/print?code=' + data}" class="btn btn-sm btn-info" target="_blank"><i class="bx bx-printer"></i></a>`
        }
    }
], function () {
    $('.detail-bt').on('click', function () {
        var id = $(this).data('id');
        $('#saleDetailModal').modal('show');
        fetch(`${window.location.href}/${id}/detail`)
            .then(fetchRes => fetchRes.json().then(data => ({
                data: data,
                status: fetchRes.status
            })))
            .then(res => {
                if (res.status == 200) {
                    var html = ``;
                    var i = 1;
                    res.data.data.forEach(element => {
                        html += `<tr>
                                    <td>${i++}</td>
                                    <td>${element.product}</td>
                                    <td>Rp. ${element.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                                    <td>${element.quantity}</td>
                                    <td>Rp. ${element.subtotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                                </tr>`;
                    })
                    $('table #sale-body').html(html);
                } else {
                    showToast('success', res.response.message)
                }
            }).catch(function (error) {
                console.log(error)
            })
    })
})

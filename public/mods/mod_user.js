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
        name: 'name',
        data: 'name',
        mRender: function (data, type, row) {
            var render = `
                <strong>${data}</strong><br>
                <i class="text-muted small">${row.position}</i>
            `

            return render
        }
    },
    {
        name: 'username',
        data: 'username',
    },
    {
        name: 'email',
        data: 'email',
    },
    {
        name: 'address',
        data: 'address',
    },
    {
        name: 'id',
        data: 'hashid',
        width: '150',
        sClass: 'text-center',
        sortable: false,
        mRender: function (data, type, row) {

            var render = ``
            if (row.customer_id == null) {
                // render += `<button class="btn btn-sm btn-danger" data-toggle="delete" data-id="${data}"><i class="bx bx-trash-alt"></i></button>`
                render = ` <button class="btn btn-sm btn-primary" data-toggle="edit" data-id="${data}"><i class="bx bx-edit-alt"></i></button>`
            }

            return render
        }
    }
])

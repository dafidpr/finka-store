// if ('serviceWorker' in navigator) {
//     navigator.serviceWorker.register('/sw.js')
//         .then(reg => console.log('service worker registered', reg))
//         .catch(err => console.error('service worker not registered', err))
// }

$(function () {
    handleView()

    window.onpopstate = function () {
        handleView()
    }
})


const handleView = async () => {
    $('v-loader').removeClass('hide')
    const res = await fetch(window.location.href, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })

    if (await res.status == 200) {
        $('v-render').html(await res.text())
    } else {
        if (res.status == 401) {
            window.location.reload()
        } else {
            var json = await res.json()
            showToast('warning', json.message)
        }
    }

    $('v-loader').addClass('hide')
    actions()
}

const actions = () => {
    $('a[data-toggle="ajax"]').unbind().on('click', function (e) {
        e.preventDefault()
        var url = $(this).attr('href') == '' ? $(this).data('target') : $(this).attr('href')
        pushState(url)
    })

    $('button[data-toggle="ajax"]').unbind().on('click', function (e) {
        e.preventDefault()
        pushState($(this).data('target'))
    })

    $('form[data-request="ajax"]').unbind().on('submit', async function (e) {
        e.preventDefault()
        resetInvalid()

        var btnHtmlOld = $('button[type="submit"]').html()
        $('button[type="submit"]').attr('disabled', 'disabled')
        $('button[type="submit"]').html('Loading...')

        if ($(this).attr('method') == 'get') {
            var res = await fetchGetRequest($(this).attr('action'))
        } else {
            var res = await fetchPostRequest(this)
        }

        $('button[type="submit"]').html(btnHtmlOld)
        $('button[type="submit"]').removeAttr('disabled')
        if (res.status == 200) {
            showToast('success', res.response.message)
            if ($(this).data('redirect')) {
                window.location.assign($(this).data('success-callback'))
            } else {
                if (typeof table == "undefined") {
                    if (typeof $(this).data('success-callback') == "undefined") {
                        handleView()
                    } else {
                        pushState($(this).data('success-callback'))
                    }
                } else {
                    if (typeof $(this).data('success-callback') != "undefined") {
                        pushState($(this).data('success-callback'))
                    }

                    table.ajax.reload()
                }
            }
        } else {
            if (res.status == 422) {
                showInvalid(res.response.errors)
            } else if (res.status == 401) {
                localStorage('oldUrl', window.location.href)
                window.location.reload()
            } else {
                showToast('warning', res.response.message)
            }
        }
    })

    $('a[data-toggle="delete"]').unbind().on('click', function (e) {
        e.preventDefault()
        var url = $(this).attr('href')
        deleteItem(url)
    })

    $('button[data-toggle="delete"]').unbind().on('click', function (e) {
        e.preventDefault()
        var url = `${window.location.href}/${$(this).data('id')}/delete`
        deleteItem(url)
    })

    $('button[data-toggle="edit"]').unbind().on('click', function (e) {
        e.preventDefault()
        pushState(`${window.location.href}/${$(this).data('id')}/edit`)
    })

    $('#checkAll').unbind().on('click', function () {
        $('.check-item:checkbox').prop('checked', this.checked)
    })

    $('button[data-toggle="bulk-delete"]').unbind().on('click', function (e) {
        e.preventDefault()
        var formData = new FormData(),
            url = $(this).data('target')

        $.each($('.check-item:checkbox:checked'), (key, val) => {
            formData.append('hashid[]', $(val).val())
        })

        swal.fire({
            title: 'Hapus ?',
            icon: 'question',
            text: 'Data yang dihapus tidak dapat dikembalikan',
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal'
        }).then(async (res) => {
            if (res.isConfirmed) {
                $('v-loader').removeClass('hide')
                var res = await fetch(url, {
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })

                var dataJSON = await res.json()
                $('v-loader').addClass('hide')
                if (await res.status == 200) {
                    $('#checkAll').prop('checked', false)
                    showToast('success', dataJSON.message)

                    if (typeof table == "undefined") handleView()
                    else table.ajax.reload()
                } else {
                    if (await res.status == 401) {
                        window.location.reload()
                    } else {
                        showToast('warning', dataJSON.message)
                    }
                }
            }
        })
    })

    $('button[data-toggle="bulk-delete"]').hide()
    $('.check-item:checkbox').unbind().on('click', function () {
        if ($('.check-item:checkbox:checked').length == $('.check-item:checkbox').length) {
            $('button[data-toggle="bulk-delete"]').show()
            $('#checkAll').prop('checked', true)
        } else {
            if ($('.check-item:checkbox:checked').length > 0) {
                $('button[data-toggle="bulk-delete"]').show()
                $('#checkAll').prop('checked', false)
            } else {
                $('button[data-toggle="bulk-delete"]').hide()
                $('#checkAll').prop('checked', false)
            }
        }
    })
}

const deleteItem = (url) => {
    swal.fire({
        title: 'Hapus ?',
        icon: 'question',
        text: 'Data yang dihapus tidak dapat dikembalikan',
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya, Lanjutkan',
        cancelButtonText: 'Batal'
    }).then(async (res) => {
        if (res.isConfirmed) {
            $('v-loader').removeClass('hide')
            var res = await fetch(url, {
                method: 'delete',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })

            var dataJSON = await res.json()
            $('v-loader').addClass('hide')
            if (await res.status == 200) {
                showToast('success', dataJSON.message)

                if (typeof table == "undefined") handleView()
                else table.ajax.reload()
            } else {
                if (await res.status == 401) {
                    window.location.reload()
                } else {
                    showToast('warning', dataJSON.message)
                }
            }
        }
    })
}

const pushState = (url) => {
    if (window.location.href != url) history.pushState([], null, url)
    handleView()
}

const fetchPostRequest = async (el) => {
    const formData = new FormData(el)
    const res = await fetch($(el).attr('action'), {
        method: $(el).attr('method'),
        headers: {
            "X-Requested-With": "XMLHttpRequest",
        },
        body: generateForm(formData)
    })

    return {
        status: (await res).status,
        response: await res.json()
    }
}

const fetchGetRequest = async (url) => {
    const res = await fetch(url)
    return {
        status: (await res).status,
        response: await res.json()
    }
}

const generateForm = (formData) => {
    const fd = new FormData()
    formData.forEach((val, key) => {
        fd.append(key, val)
    })

    return fd
}


const showToast = (type, msg) => {
    var el = (type == 'primary' ? '#toast-primary' : (type == 'success' ? '#toast-success' : (type == 'warning' ? '#toast-warning' : (type == 'danger' ? '#toast-danger' : null))))

    $('.toast-body').html(msg)

    if (el != null) {
        new bootstrap.Toast(el).show()
    } else {
        console.error('toast type is not null')
    }
}

const showInvalid = (errorMessages) => {
    for (errorField in errorMessages) {
        if ($(`.js-choices[name="${errorField}`).length) {
            $(`.form-control[name="${errorField}"]`)
                .parent()
                .parent()
                .append(
                    `<div class="invalid-feedback d-block">${errorMessages[errorField]}</div>`
                );
            $(`.form-control[name="${errorField}"]`).addClass("is-invalid");
        } else {
            $(`<div class="invalid-feedback">${errorMessages[errorField][0]}</div>`)
                .insertAfter(`.form-control[name="${errorField}"]`)
            $(`.form-control[name="${errorField}"]`).addClass('is-invalid')
        }
    }
}

const resetInvalid = () => {
    for (const el of $(".form-control")) {
        $(el).removeClass("is-invalid")
        $(el).siblings(".invalid-feedback").remove()
        $(".invalid-feedback").remove()
    }
}

const initDataTable = (el, columns = [], drawCallback = null) => {
    var table = $(el).DataTable({
        serverSide: true,
        processing: true,
        ajax: $(el).data('url'),
        columns: columns,
        responsive: true,
        search: {
            "return": true
        },
        drawCallback,
    })

    table.on('draw.dt', function () {
        actions()
        drawCallback
    })

    table.on('responsive-display', function () {
        actions()
        drawCallback
    })

    return table
}

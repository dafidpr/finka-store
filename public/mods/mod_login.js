$(function(){
    $('.admin').hide()
    $('.admin').removeClass('d-none')

    $('#btnCustomer').unbind().on('click', function(){
        $('.admin').hide('fade')
        $('.customer').show('fade')
        $('#responsiveCustomer').show()
        $('#responsiveAdmin').hide()
    })

    $('#btnAdmin').unbind().on('click', function(){
        $('.customer').hide('fade')
        $('.admin').show('fade')
        $('#responsiveCustomer').show()
        $('#responsiveAdmin').hide()
    })

    $('#responsiveAfter').hide()
    $('#responsiveAfter').removeClass('d-none')

    $('#btnResponsiveAdmin').unbind().on('click', function(){
        $('#responsiveAdmin').show()
        $('#responsiveCustomer').hide()
        $('.admin').hide('fade')
        $('.customer').show('fade')
        $('#responsiveBefore').hide('fade')
        $('#responsiveAfter').show('fade')
    })

    $('#btnResponsiveCustomer').unbind().on('click', function(){
        $('#responsiveCustomer').show()
        $('#responsiveAdmin').hide()
        $('.customer').hide('fade')
        $('.admin').show('fade')
        $('#responsiveBefore').hide('fade')
        $('#responsiveAfter').show('fade')
    })
    
    $('#responsiveBack').unbind().on('click', function(){
        $('#responsiveAfter').hide()
        $('#responsiveBefore').show('fade')
    })
})
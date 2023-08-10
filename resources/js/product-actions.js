
$(document).ready(() => {
    $(document).on('click', '.add-to-cart', function(e) {
        e.preventDefault()

        const btn = $(this)
        const counter = $('#cart_counter')

        axios.post( btn.data('route')).then(function (response)
        {
            $('#cart_counter').text(
                parseInt( counter.text() ) + 1
            )

            iziToast.success({
                title: 'Successfully added to cart',
                position: 'topRight',
            })
        })
            .catch(function (error) {
                // обработка ошибки
                console.log('error status', error.status)
                console.log('error message', error.data.message)
                swal("Error!", "Something went wrong!", "error");
            })

    })
})

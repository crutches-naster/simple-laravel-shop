
$(document).ready(() => {
    $(document).on('click', '.add-to-cart', function(e) {
        e.preventDefault()

        const btn = $(this)
        const counter = $('#cart_counter')

        console.log(btn)

        axios.post( btn.data('route')).then(function (response)
        {
            $('#cart_counter').text(
                parseInt( counter.text() ) + 1
            )

            // ToDo add toast about product successfully was added to cart
        })
            .catch(function (error) {
                // обработка ошибки
                console.log('error status', error.status)
                console.log('error message', error.data.message)
                swal("Error!", "Something went wrong!", "error");
            })

    })
})

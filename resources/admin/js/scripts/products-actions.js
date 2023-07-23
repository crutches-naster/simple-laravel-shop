$(document).ready(() => {
    $(document).on('click', '.new-sku', function(e) {
        e.preventDefault()

        const $btn = $(this)

        axios.get($btn.data('route'), {
            responseType: 'json'
        })
            .then(function (response) {
                $('#sku').val(response.data.sku)
            })
            .catch(function (error) {
                // обработка ошибки
                console.log('error status', error.status)
                console.log('error message', error.data.message)
                swal("Error!", "Something went wrong!", "error");
            })


    })
})

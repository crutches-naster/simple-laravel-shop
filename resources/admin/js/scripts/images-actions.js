import './bootstrap';

$(document).ready(() => {
    $(document).on('click', '.remove-image', function(e) {
        e.preventDefault()

        const $btn = $(this)

        axios.delete($btn.data('route'), {
            responseType: 'json'
        })
            .then(function (response) {
                $btn.parent().remove();
                // swal("OK!", "Image successfully deleted!", "success");
            })
            .catch(function (error) {
                // обработка ошибки
                console.log('error status', error.status)
                console.log('error message', error.data.message)
                swal("Error!", "Something went wrong!", "error");
            })
    })
})

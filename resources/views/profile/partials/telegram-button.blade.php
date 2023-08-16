<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Bind Telegram account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Get info about your orders and our discounts in telegram!') }}
        </p>
    </header>
    <h4>Get info about your orders and our discounts in telegram!</h4>
    <script async src="https://telegram.org/js/telegram-widget.js?22"
            data-telegram-login="{{env('TELEGRAM_BOT_NAME', '')}}"
            data-size="large"
            data-auth-url="{{ route('callbacks.telegram' )}}"
            data-request-access="write"
    ></script>
</section>

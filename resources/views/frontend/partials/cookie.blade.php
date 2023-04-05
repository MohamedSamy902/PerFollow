<div class="cookies-card bg--default text-center cookies--dark radius--10px js-cookie-consent cookie-consent">
    <div class="cookies-card__icon">
        <i class="fas fa-cookie-bite"></i>
    </div>
    <p class="mt-4 cookies-card__content cookie-consent__message">
        @lang(@$gs->cookie->cookie_text)
    </p>
    <div class="cookies-card__btn mt-4">
        <button class="js-cookie-consent-agree cookie-consent__agree cmn--btn m-2">
            @lang(@$gs->cookie->button_text)
        </button>
    </div>
</div>
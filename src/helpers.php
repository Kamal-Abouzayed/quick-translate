<?php

use Kamal\QuickTranslate\QuickTranslate;

if (!function_exists('translate')) {
    /**
     * Translate a given word to the specified locale.
     *
     * @param string $word
     * @param string|null $locale
     * @return string
     */
    function translate($word, $locale = null)
    {
        return app(QuickTranslate::class)->translate($word, $locale);
    }
}

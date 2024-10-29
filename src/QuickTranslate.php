<?php

namespace KamalAbouzayed\QuickTranslate;

use Stichoza\GoogleTranslate\GoogleTranslate;

class QuickTranslate
{
    protected $translationsFile;

    public function __construct()
    {
        $this->translationsFile = config('quick-translate.translationsFile');

        if (!file_exists($this->translationsFile)) {
            file_put_contents($this->translationsFile, json_encode([], JSON_PRETTY_PRINT));
        }
    }

    public function transWord($word)
    {
        // Load supported locales from config
        $supportedLocales = config('quick-translate.locales', []);

        // If no locales are defined, add the default locale
        if (empty($supportedLocales)) {
            $defaultLocale = app()->getLocale();
            $supportedLocales[] = $defaultLocale;
        }

        // Load existing translations from the file
        $translations = json_decode(file_get_contents($this->translationsFile), true);

        $translatedWords = []; // Store translations for each locale

        // Check and translate for each locale
        foreach ($supportedLocales as $locale) {
            // If translation exists, use it; otherwise, translate and save
            if (isset($translations[$locale][$word])) {
                $translatedWords[$locale] = $translations[$locale][$word];
            } else {
                // Translate the word
                $translateClient = new GoogleTranslate();
                $translatedWord = $translateClient->setSource(null)->setTarget($locale)->translate($word);

                // Save the new translation
                $translations[$locale][$word] = $translatedWord;
                $translatedWords[$locale] = $translatedWord;
            }
        }

        // Write all updated translations to file once
        file_put_contents($this->translationsFile, json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // Return the translations for each locale
        return $translatedWords[app()->getLocale()];
    }
}

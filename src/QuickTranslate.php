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

        // Check and translate for each locale
        foreach ($supportedLocales as $locale) {
            // Return translation if it exists
            if (isset($translations[$locale][$word])) {
                return $translations[$locale][$word];
            }

            // Translate the word if no existing translation
            $translateClient = new GoogleTranslate();
            $translatedWord = $translateClient->setSource(null)->setTarget($locale)->translate($word);

            // Save the new translation to the translations array
            $translations[$locale][$word] = $translatedWord;

            // Write updated translations back to file
            file_put_contents($this->translationsFile, json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            return $translatedWord;
        }

        // Return null if no translation was performed (optional)
        return null;
    }
}

<?php

namespace Kamal\QuickTranslate;

class QuickTranslate
{
    protected $translationsFile;

    public function __construct()
    {
        $this->translationsFile = storage_path('app/translations.json');

        if (!file_exists($this->translationsFile)) {
            file_put_contents($this->translationsFile, json_encode([], JSON_PRETTY_PRINT));
        }
    }

    public function transWord($word, $locale = null)
    {
        if (!$locale) {
            $locale = app()->getLocale();
        }

        $translations = json_decode(file_get_contents($this->translationsFile), true);

        if (isset($translations[$locale][$word])) {
            return $translations[$locale][$word];
        }

        $translateClient = new GoogleTranslate();
        $translatedWord = $translateClient->setSource(null)->setTarget($locale)->translate($word);

        $translations[$locale][$word] = $translatedWord;
        file_put_contents($this->translationsFile, json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return $translatedWord;
    }
}

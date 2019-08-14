<?php

namespace IvanMuir\SimpleTransliteration;

/*
 * Simple text transliteration to selected language.
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/mit-license.php
 */
class SimpleTransliteration
{
    /**
     * Path to directory with default dictionaries
     */
    const DEFAULT_DICTIONARIES_PATH = __DIR__ . "/DefaultDictionaries";

    /**
     * The current version number.
     */
    const VERSION = "1.0";

    /**
     * A text that will be transliterated.
     *
     * @var null|string
     */
    protected $text = null;

    /**
     * Custom path to dictionaries folder.
     *
     * @var null|string
     */
    protected $pathToDictionaries = null;

    /**
     * SimpleTransliteration constructor.
     * @param string|null $text
     * @param string|null $path
     */
    public function __construct(string $text = null, string $path = null)
    {
        $this->text = $text;

        $this->setDictionariesLocation($path);
    }

    /**
     * Allow to set custom path of dictionaries.
     *
     * @param string $path
     * @return bool
     */
    public function setDictionariesLocation(string $path = null)
    {
        if ($path === null) {
            $this->pathToDictionaries = self::DEFAULT_DICTIONARIES_PATH;
            return $this->pathToDictionaries;
        }
        $this->pathToDictionaries = $path;
        return $this->pathToDictionaries;
    }

    /**
     * Method to transliterate source text based on source language and selected transliteration language.
     *
     * @param string|null $text
     * @param string $fromLang
     * @param string $toLang
     * @param string $path
     * @return string
     */
    public function transliterate(string $fromLang = null, string $toLang = null, string $text = null, string $path = null)
    {
        if ($this->text !== null && $text === null) {
            $text = $this->text;
        }

        /*
         * Spitting source text by every char.
         */
        $splitedText = preg_split('//u', $text, null, PREG_SPLIT_NO_EMPTY);

        if (count($splitedText) == 0) {
            $this->throwError("Source string can't be parsed. Is it empty?");
        }

        if ($path !== null) {
            $this->pathToDictionaries = $path;
        }

        $path = "{$this->pathToDictionaries}/{$fromLang}_{$toLang}.json";
        $dictionary = json_decode($this->getDictionary($fromLang, $toLang, $path), true);

        if (empty($dictionary)) {
            $this->throwError("Specified dictionary ($path)");
        }

        /*
         * Comparison of two arrays where first - an exploded string and second - a dictionary.
         * Here the source characters are replaced by the characters from the dictionary.
         */
        for ($i = 0; $i < count($splitedText); $i++) {
            if ($splitedText[$i] == " " || $splitedText[$i] == null) {
                $splitedText[$i] = " ";
            } elseif (array_key_exists($splitedText[$i], $dictionary)) {
                $splitedText[$i] = $dictionary[$splitedText[$i]];
            }
        }

        return implode($splitedText);
    }

    /**
     * Method to get specified dictionary.
     *
     * @param string $fromLang
     * @param string $toLang
     * @param string $path
     * @return bool|string
     */
    private function getDictionary(string $fromLang, string $toLang, string $path)
    {
        if ($fromLang === null || $toLang === null) {
            return false;
        }
        return file_get_contents($path);
    }

    /**
     * Used to handle errors.
     *
     * @param string $message
     */
    static function throwError(string $message)
    {
        exit("An error occur: {$message}");
    }
}
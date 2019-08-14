<?php

use IvanMuir\SimpleTransliteration\SimpleTransliteration;
use PHPUnit\Framework\TestCase;


class SimpleTransliterationTests extends TestCase
{
    /**
     * Creates a new instance of the main class and returns it.
     *
     * @return SimpleTransliteration
     */
    protected function getInstance()
    {
        return new SimpleTransliteration();
    }

    /**
     * Transliterates source text based on source language and selected transliteration language
     *
     * @param string $fromLang
     * @param string $toLang
     * @param string $text
     * @return string
     */
    protected function transliterate(string $fromLang, string $toLang, string $text)
    {
        $st = $this->getInstance();
        return $st->transliterate($fromLang, $toLang, $text);
    }

    public function testRuEn()
    {
        $st = $this->transliterate("ru", "en", "Съешь еще этих мягких французских булок, да выпей чаю.");
        $this->assertSame("Sesh eshche etih myagkih francuzskih bulok, da vypey chau.", $st);
    }

    public function testRuEnNotExistsChars()
    {
        $st = $this->transliterate("ru", "en", "Съешь еще этих мягких французских buns, да выпей tea.");
        $this->assertSame("Sesh eshche etih myagkih francuzskih buns, da vypey tea.", $st);
    }

    public function testRuEnMultiByte()
    {
        $st = $this->transliterate("ru", "en", "Съешь еще этих мягких французских булок 🥐, да выпей чаю ☕.");
        $this->assertSame("Sesh eshche etih myagkih francuzskih bulok 🥐, da vypey chau ☕.", $st);
    }

    public function testAnotherLang()
    {
        $st = $this->transliterate("ru", "en", "ööööööööööö");
        $this->assertSame("ööööööööööö", $st);
    }

    public function testDictionariesLocation()
    {
        $st = $this->getInstance();
        $status = $st->setDictionariesLocation("../CustomDictionaries");
        $this->assertSame("../CustomDictionaries", $status);
    }
}
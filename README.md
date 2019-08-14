# SimpleTransliteration

**SimpleTransliteration** it's a library that helps with transliteration from one language to another.

## Requirements
> **PHP >= 7.1**


## Installtaion

Composer:
`
composer require sensitivesouris/simpletransliteration
`

You can use this library without composer, but then you need to register an [autoloader function](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md#example-implementation).
 
## Basic usage

```php
$st = new IvanMuir\SimpleTransliteration\SimpleTransliteration();

$transliterized = $st->transliterate("ru", "en", "Съешь еще этих мягких французских булок, да выпей чаю.");

echo $transliterized; //Sesh eshche etih myagkih francuzskih bulok, da vypey chau.
```

## Custom dictionaries
By default, there is only one dictionary that contains Cyrillic chars with their aliases in English.
To add custom folder with more dictionaries use:
```php
$st = new IvanMuir\SimpleTransliteration\SimpleTransliteration();

$st->setDictionariesLocation("path/to/dictionaries");
```
All dictionaries must me in `json` format, have name that contains *SourceLang*_*OutputLang*, ex. `ru_en.json`  and this structure:
```
{  
  "А": "A",  
  "Б": "B",  
  "В": "V",
...
}
```
where first chat - input char and second char - output char.
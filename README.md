# FPDF2 Make Font UI

This plugin uses the
[FPDF2 Make Font](https://github.com/laurentmuller/fpdf2-make-font) library to
generate fonts.

## User interface

Light and dark themes are available.

![User Interface](public/images/theme-light.png)
![User Interface](public/images/theme-dark.png)

## Fields

- `Font File`: The path to the `.ttf`, `.otf` or `.pfb` file.
- `AFM File`: The file that contains font metric information for a Type 1
  PostScript font (`.pfb`).
- `encoding`: The name of the encoding to use.
- `Embed`: Whether to embed the font or not.
- `Subset`: Whether to subset the font or not.

The `Font File` parameter is the name of the font file. The extension must be
either `.ttf`, `.otf` or `.pfb` and determines the font type. If your Type1 font
is in ASCII format (`.pfa`), you can convert it to binary (`.pfb`) with the help
of [Type 1 utilities](http://www.lcdf.org/~eddietwo/type/#t1utils). For Type1
fonts, the corresponding `.afm` file must be selected.

The `Encoding` defines the association between a code (from 0 to 255) and a
character. The first 128 are always the same and correspond to ASCII; the
following are variable. The available encoding ones are:

- cp1250 (Central Europe)
- cp1251 (Cyrillic)
- cp1252 (Western Europe)
- cp1253 (Greek)
- cp1254 (Turkish)
- cp1255 (Hebrew)
- cp1257 (Baltic)
- cp1258 (Vietnamese)
- cp874 (Thai)
- ISO-8859-1 (Western Europe)
- ISO-8859-2 (Central Europe)
- ISO-8859-4 (Baltic)
- ISO-8859-5 (Cyrillic)
- ISO-8859-7 (Greek)
- ISO-8859-9 (Turkish)
- ISO-8859-11 (Thai)
- ISO-8859-15 (Western Europe)
- ISO-8859-16 (Central Europe)
- KOI8-R (Russian)
- KOI8-U (Ukrainian)

Of course, the font must contain the characters corresponding to the selected
encoding.

The `Embed` parameter indicates whether the font should be embedded in the PDF
or not. When a font is not embedded, it is searched in the system. The advantage
is that the PDF file is smaller; but if it is not available, then a
substitution font is used. So you should ensure that the required font is
installed on the client systems. Embedding is the recommended option to
guarantee a correct rendering.

The `Subset` parameter indicates whether sub-setting should be used, that is to
say, whether only the characters from the selected encoding should be kept in
the embedded font. As a result, the size of the PDF file can be greatly reduced,
especially if the original font was big.

On the top right user can select the language (English or French), the
[site color mode](https://getbootstrap.com/docs/5.3/customize/color-modes/) and
have access to the source code on GitHub.

## Versions

[![Application](https://img.shields.io/badge/Application-1.0.0-blue)](https://github.com/laurentmuller/calculation)
[![Symfony](https://img.shields.io/badge/Symfony-7.4.5-informational?logo=symfony)](https://symfony.com)
[![PHP](https://img.shields.io/badge/PHP-8.3.29-informational?logo=php)](https://www.php.net)
[![Apache](https://img.shields.io/badge/Apache-2.4.51-informational?logo=apache)](https://httpd.apache.org)
[![PhpStorm](https://img.shields.io/badge/PhpStorm-2025.3-informational?logo=phpstorm)](https://www.jetbrains.com/phpstorm)

## Code Quality

[![SymfonyInsight](https://insight.symfony.com/projects/cf786842-6061-4d9d-921c-e0e3a22cf2bd/mini.svg)](https://insight.symfony.com/projects/cf786842-6061-4d9d-921c-e0e3a22cf2bd)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/ab264caadf99477c8a7ac132346d99dd)](https://app.codacy.com/gh/laurentmuller/fpdf2-make-font-ui/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade)
[![PHP-Stan](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg?style=flat&logo=php)](https://phpstan.org/blog/find-bugs-in-your-code-without-writing-tests)
[![CodeFactor](https://www.codefactor.io/repository/github/laurentmuller/fpdf2-make-font-ui/badge)](https://www.codefactor.io/repository/github/laurentmuller/fpdf2-make-font-ui)
[![Codecov](https://codecov.io/gh/laurentmuller/fpdf2-make-font-ui/graph/badge.svg?token=3SCSEL8UEM)](https://codecov.io/gh/laurentmuller/fpdf2-make-font-ui)

## Actions

[![PHP-CS-Fixer](https://github.com/laurentmuller/fpdf2-make-font-ui/actions/workflows/php-cs-fixer.yaml/badge.svg)](https://github.com/laurentmuller/fpdf2-make-font-ui/actions/workflows/php-cs-fixer.yaml)
[![PHPStan](https://github.com/laurentmuller/fpdf2-make-font-ui/actions/workflows/php_stan.yaml/badge.svg)](https://github.com/laurentmuller/fpdf2-make-font-ui/actions/workflows/php_stan.yaml)
[![PHPUnit](https://github.com/laurentmuller/fpdf2-make-font-ui/actions/workflows/php_unit.yaml/badge.svg)](https://github.com/laurentmuller/fpdf2-make-font-ui/actions/workflows/php_unit.yaml)
[![Rector](https://github.com/laurentmuller/fpdf2-make-font-ui/actions/workflows/rector.yaml/badge.svg)](https://github.com/laurentmuller/fpdf2-make-font-ui/actions/workflows/rector.yaml)
[![Lint](https://github.com/laurentmuller/fpdf2-make-font-ui/actions/workflows/lint.yaml/badge.svg)](https://github.com/laurentmuller/fpdf2-make-font-ui/actions/workflows/lint.yaml)
[![StyleCI](https://github.styleci.io/repos/969444909/shield?branch=master)](https://github.styleci.io/repos/969444909?branch=master)

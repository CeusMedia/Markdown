# Markdown

![Branch](https://img.shields.io/badge/Branch-0.2.x-blue?style=flat-square)
![Release](https://img.shields.io/badge/Release-0.2.0-blue?style=flat-square)
![PHP version](https://img.shields.io/badge/PHP-%5E8.1-blue?style=flat-square&color=777BB4)
![PHPStan level](https://img.shields.io/badge/PHPStan_level----darkgreen?style=flat-square)
[![Total downloads](http://img.shields.io/packagist/dt/ceus-media/markdown.svg?style=flat-square)](https://packagist.org/packages/ceus-media/common)
[![Package version](http://img.shields.io/packagist/v/ceus-media/markdown.svg?style=flat-square)](https://packagist.org/packages/ceus-media/common)
[![License](https://img.shields.io/packagist/l/ceus-media/markdown.svg?style=flat-square)](https://packagist.org/packages/ceus-media/common)

Abstraction layer for using several Markdown converters, mostly written in PHP.

## Description

### Use Cases
Allows to convert Markdown to other formats (HTML only at the moment).
Within this library this process will be done using a <code>Renderer</code>, since a Markdown code will be rendered into another format.
Since there are several Markdown flavors and implementations, this library is providing an abstraction layer to easily switch between flavors.

Allows to convert other formats (HTML only at the moment) to Markdown.
Within this library this process will be done using a <code>Parser</code>, since other formats will be parsed to be understood as Markdown.

### Aim
This library aims to provide an abstraction layer for existing implementations for convert Markdown into and from other formats. This will be done by maintaining a list of Open Source packages and providing this collection easily using <code>composer</code>.

## Installation

Using composer:

	composer require ceus-media/markdown

## Usage

After loading the libraries or using autoloading, e.G. using <code>composer</code>, you can use this library the following ways.  

### Rendering

To render Markdown code into HTML, using the [PHP implementation][1] of [Commonmark syntax][2]:

	use \CeusMedia\Markdown\Renderer\Html;
	
	$renderer	= new Html();
	//$renderer->setRenderer( Html::RENDERER_PARSEDOWN );
	$html		= $renderer->convert( "## Heading 2" );

You can change the used renderer, for example to support tables and fenced code by switching to <code>Parsedown</code>:

	$renderer->setRenderer( Html::RENDERER_PARSEDOWN );

### Parsing

Trying to convert HTML to Markdown can be done like this:

	use \CeusMedia\Markdown\Parser\Html;
	
	$parser		= new Html();
	$markdown	= $parser->convert( "<h2>Heading</h2>" );


## Outlook
The next versions will include other output formats (like PDF or Open Document) and input formats (like DokuWiki and other Wiki syntaxes).

### Todos

#### Add DokuWiki Parser
- use [titledk/dokuwiki-to-markdown-converter][91]
- call <code>convert</code> on [DocuwikiToMarkdownExtra][92]


[1]: http://commonmark.thephpleague.com/
[2]: http://commonmark.org/

[91]: https://github.com/titledk/dokuwiki-to-markdown-converter
[92]: https://github.com/titledk/dokuwiki-to-markdown-converter/blob/master/scripts/DocuwikiToMarkdownExtra.php

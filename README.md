# Markdown
Abstraction layer for using several Markdown converters, mostly written in PHP.

## Description

### Use Cases
Allows to convert Markdown to other formats (HTML only at the moment).
Within this library this process will done using a <code>Renderer</code>, since a Markdown code will be rendered into another format.
Since there are several Markdown flavors and implementations, this library is providing an abstraction layer to easily switch between flavors.

Allows to convert other formats (HTML only at the moment) to Markdown.
Within this library this process will done using a <code>Parser</code>, since other formats will be parsed to be understood as Markdown.

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

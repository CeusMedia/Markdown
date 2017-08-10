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

### Outlook
The next versions will include other output (like PDF or Open Document) and input formats (like DokuWiki and other Wiki syntaxes).

## Installation

Using composer:

	composer require ceus-media/markdown

## Todos
### Add DokuWiki Parser
- use [titledk/dokuwiki-to-markdown-converter](https://github.com/titledk/dokuwiki-to-markdown-converter)
- call <code>convert</code> on [DocuwikiToMarkdownExtra](https://github.com/titledk/dokuwiki-to-markdown-converter/blob/master/scripts/DocuwikiToMarkdownExtra.php)

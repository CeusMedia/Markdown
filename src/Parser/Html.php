<?php
namespace CeusMedia\Markdown\Parser;

use League\HTMLToMarkdown\HtmlConverter;
use ReflectionClass;

/**
 *	Renderers:
 *	@link		[Commonmark](https://github.com/thephpleague/html-to-markdown)
 *
 *	Specs:
 *	@link		[Commonmark](http://spec.commonmark.org/)
 *	@link		[Markdown Extra](https://michelf.ca/projects/php-markdown/extra/)
 *	@link		[GitHub Flavor](https://help.github.com/categories/writing-on-github/)
 *	@link		[Markdown Extended](http://manifest.aboutmde.org/)
 */

class Html
{

	const PARSER_COMMONMARK 			= 1;

	protected int $parser		= self::PARSER_COMMONMARK;

	public function __construct( $parser = 0 ){
		$this->setParser( $parser );
	}

	static public function getParsers(): array
	{
		$reflection	= new ReflectionClass( __CLASS__ );
		$list	= array();
		foreach( $reflection->getConstants() as $key => $value )
			if( str_starts_with( $key, 'PARSER_' ) )
				$list[$key]	= $value;
		return $list;
	}

	public function convert( string $html ): string
	{
		switch( $this->parser ){
			case self::PARSER_COMMONMARK:
			default:
				$converter = new HtmlConverter();
				return $converter->convert( $html );
		}
	}

	/**
	 *	Alias for convert.
	 */
	public function render( string $html ): string
	{
		return $this->convert( $html );
	}

	public function setParser( $parser ): self
	{
		$this->parser	= $parser;
		return $this;
	}

	/**
	 *	Alias for convert.
	 */
	public function transform( $html ): string
	{
		return $this->convert( $html );
	}
}


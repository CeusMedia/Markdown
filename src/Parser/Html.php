<?php
declare(strict_types=1);

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
	const PARSER_COMMONMARK 	= 1;

	protected int $parser		= self::PARSER_COMMONMARK;

	/**
	 *	@return		array
	 */
	public static function getParsers(): array
	{
		$reflection	= new ReflectionClass( __CLASS__ );
		return array_filter( $reflection->getConstants(), function( $key ){
			return str_starts_with( $key, 'PARSER_' );
		}, ARRAY_FILTER_USE_KEY );
	}

	/**
	 *	@param		int		$parser
	 */
	public function __construct( int $parser = self::PARSER_COMMONMARK )
	{
		$this->setParser( $parser );
	}

	/**
	 *	@param		string		$html
	 *	@return		string
	 */
	public function convert( string $html ): string
	{
		switch( $this->parser ){
			case self::PARSER_COMMONMARK:
			default:
				$converter	= new HtmlConverter();
				return $converter->convert( $html );
		}
	}

	/**
	 *	Alias for convert.
	 *	@param		string		$html
	 *	@return		string
	 */
	public function render( string $html ): string
	{
		return $this->convert( $html );
	}

	/**
	 *	@param		int		$parser
	 *	@return		self
	 */
	public function setParser( int $parser = self::PARSER_COMMONMARK ): self
	{
		$this->parser	= $parser;
		return $this;
	}

	/**
	 *	Alias for convert.
	 *	@param		string		$html
	 *	@return		string
	 */
	public function transform( string $html ): string
	{
		return $this->convert( $html );
	}
}


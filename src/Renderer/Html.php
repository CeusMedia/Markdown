<?php
namespace CeusMedia\Markdown\Renderer;

use Erusev\Parsedown\Parsedown;
use League\CommonMark\CommonMarkConverter;
use MarkdownExtended\Parser as MarkdownExtendedParser;
use Michelf\Markdown;
use Michelf\MarkdownExtra;
use cebe\markdown as cebe;
use Ciconia\Ciconia;
use Ciconia\Extension\Gfm;
use Ciconia\Renderer\XhtmlRenderer;
use ReflectionClass;

/**
 *	Renderers:
 *	@link		[Commonmark](http://commonmark.thephpleague.com/)
 *	@link		[Parsedown](https://github.com/erusev/parsedown)
 *	@link		[cebe markdown]https://github.com/cebe/markdown)
 *	@link		[PHP Markdown](https://michelf.ca/projects/php-markdown/)
 *	@link		[Ciconia](https://github.com/kzykhys/Ciconia)
 *	@link		[Markdown Extended](https://github.com/e-picas/markdown-extended)
 *
 *	Specs:
 *	@link		[Commonmark](http://spec.commonmark.org/)
 *	@link		[Markdown Extra](https://michelf.ca/projects/php-markdown/extra/)
 *	@link		[GitHub Flavor](https://help.github.com/categories/writing-on-github/)
 *	@link		[Markdown Extended](http://manifest.aboutmde.org/)
 */

class Html{

	const RENDERER_COMMONMARK 			= 1;
	const RENDERER_PARSEDOWN			= 2;
	const RENDERER_MICHELF				= 3;
	const RENDERER_MICHELF_EXTRA		= 4;
	const RENDERER_CEBE					= 5;
	const RENDERER_CEBE_EXTRA			= 6;
	const RENDERER_CEBE_GITHUB			= 7;
	const RENDERER_CICONIA				= 8;
	const RENDERER_CICONIA_GITHUB		= 9;
	const RENDERER_MARKDOWN_EXTENDED	= 10;

	protected int $renderer		= self::RENDERER_COMMONMARK;

	public function __construct( $renderer = 0 ){
		$this->setRenderer( $renderer );
	}

	static public function getRenderers(): array
	{
		$reflection	= new ReflectionClass( __CLASS__ );
		$list	= array();
		foreach( $reflection->getConstants() as $key => $value )
			if( str_starts_with( $key, 'RENDERER_' ) )
				$list[$key]	= $value;
		return $list;
	}

	public function convert( $markdown ): string
	{
		switch( $this->renderer ){
			case self::RENDERER_PARSEDOWN:
				$renderer	= new Parsedown();
				return $renderer->toHtml( $markdown );
			case self::RENDERER_MICHELF:
				$renderer	= new Markdown();
				return $renderer->defaultTransform( $markdown );
			case self::RENDERER_MICHELF_EXTRA:
				$renderer	= new MarkdownExtra();
				return $renderer->defaultTransform( $markdown );
			case self::RENDERER_CEBE:
				$renderer	= new cebe\Markdown();
				return $renderer->parse( $markdown );
			case self::RENDERER_CEBE_GITHUB:
				$renderer	= new cebe\GithubMarkdown();
				return $renderer->parse( $markdown );
			case self::RENDERER_CICONIA:
				$renderer	= new Ciconia(new XhtmlRenderer());
				return $renderer->render( $markdown );
			case self::RENDERER_CICONIA_GITHUB:
				$renderer	= new Ciconia(new XhtmlRenderer());
				$renderer->addExtension(new Gfm\FencedCodeBlockExtension());
				$renderer->addExtension(new Gfm\TaskListExtension());
				$renderer->addExtension(new Gfm\InlineStyleExtension());
				$renderer->addExtension(new Gfm\WhiteSpaceExtension());
				$renderer->addExtension(new Gfm\TableExtension());
				$renderer->addExtension(new Gfm\UrlAutoLinkExtension());
				return $renderer->render( $markdown );
			case self::RENDERER_MARKDOWN_EXTENDED:
				$renderer = new MarkdownExtendedParser();
				return $renderer->transform( $markdown );
			case self::RENDERER_COMMONMARK:
			default:
				$converter = new CommonMarkConverter();
				return $converter->convert( $markdown );
		}
	}

	/**
	 *	Alias for convert.
	 */
	public function render( string $markdown ): string
	{
		return $this->convert( $markdown );
	}

	public function setRenderer( int $renderer ): self
	{
		$this->renderer	= $renderer;
		return $this;
	}

	/**
	 *	Alias for convert.
	 */
	public function transform( string $markdown ): string
	{
		return $this->convert( $markdown );
	}
}

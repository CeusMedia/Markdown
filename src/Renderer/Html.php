<?php
namespace CeusMedia\Markdown\Renderer;

use League\CommonMark\CommonMarkConverter;
use Michelf\Markdown;
use Michelf\MarkdownExtra;
use cebe\markdown as cebe;
use Ciconia\Ciconia;
use Ciconia\Extension\Gfm;
use Ciconia\Renderer\XhtmlRenderer;

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

	protected $renderer		= self::RENDERER_COMMONMARK;

	public function __construct( $renderer = 0 ){
		$this->setRenderer( $renderer );
	}

	static public function getRenderers(){
		$reflection	= new \ReflectionClass( __CLASS__ );
		$list	= array();
		foreach( $reflection->getConstants() as $key => $value )
			if( preg_match( '/^RENDERER_/', $key ) )
				$list[$key]	= $value;
		return $list;
	}

	public function convert( $markdown ){
		switch( $this->renderer ){
			case self::RENDERER_PARSEDOWN:
				$renderer	= new \Parsedown();
				return $renderer->text( $markdown );
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
				$renderer = new \MarkdownExtended\Parser();
				return $renderer->transform( $markdown );
			case self::RENDERER_COMMONMARK:
			default:
				$converter = new CommonMarkConverter();
				return $converter->convertToHtml( $markdown );
		}
	}

	/**
	 *	Alias for convert.
	 */
	public function render( $markdown ){
		return $this->convert( $markdown );
	}

	public function setRenderer( $renderer ){
		$this->renderer	= $renderer;
	}

	/**
	 *	Alias for convert.
	 */
	public function transform( $markdown ){
		return $this->convert( $markdown );
	}
}
?>

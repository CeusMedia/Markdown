<?php
namespace CeusMedia\Markdown;

use League\CommonMark\CommonMarkConverter;
use Michelf\Markdown;
use Michelf\MarkdownExtra;
use cebe\markdown as cebe;
use Ciconia\Ciconia;
use Ciconia\Extension\Gfm;
use Ciconia\Renderer\XhtmlRenderer;

/**
 *	Parsers:
 *	@link		[Commonmark](http://commonmark.thephpleague.com/)
 *	@link		[Parsedown](https://github.com/erusev/parsedown)
 *	@link		[cebe markdown]https://github.com/cebe/markdown)
 *	@link		[PHP Markdown](https://michelf.ca/projects/php-markdown/)
 *	@link		[Ciconia](https://github.com/kzykhys/Ciconia)
 *	@link		[Markdown Extended](https://github.com/e-picas/markdown-extended)
 *
 *	Specs:
 *	@link		[Markdown Extra](https://michelf.ca/projects/php-markdown/extra/)
 *	@link		[GitHub Flavor](https://help.github.com/categories/writing-on-github/)
 *	@link		[Markdown Extended](http://manifest.aboutmde.org/)
 */

class Parser{

	const PARSER_COMMONMARK 		= 0;
	const PARSER_PARSEDOWN			= 1;
	const PARSER_MICHELF			= 2;
	const PARSER_MICHELF_EXTRA		= 3;
	const PARSER_CEBE				= 4;
	const PARSER_CEBE_EXTRA			= 5;
	const PARSER_CEBE_GITHUB		= 6;
	const PARSER_CICONIA			= 7;
	const PARSER_CICONIA_GITHUB		= 8;
	const PARSER_MARKDOWN_EXTENDED	= 9;

	protected $parser		= self::PARSER_COMMONMARK;

	public function __construct( $parser = 0 ){
		$this->setParser( $parser );
	}

	static public function getParsers(){
		$reflection	= new \ReflectionClass( __CLASS__ );
		$list	= array();
		foreach( $reflection->getConstants() as $key => $value )
			if( preg_match( '/^PARSER_/', $key ) )
				$list[$key]	= $value;
		return $list;
	}

	public function parse( $markdown ){
		switch( $this->parser ){
			case self::PARSER_PARSEDOWN:
				$parser	= new \Parsedown();
				return $parser->text( $markdown );
			case self::PARSER_MICHELF:
				$parser	= new Markdown();
				return $parser->defaultTransform( $markdown );
			case self::PARSER_MICHELF_EXTRA:
				$parser	= new MarkdownExtra();
				return $parser->defaultTransform( $markdown );
			case self::PARSER_CEBE:
				$parser	= new cebe\Markdown();
				return $parser->parse( $markdown );
			case self::PARSER_CEBE_GITHUB:
				$parser	= new cebe\GithubMarkdown();
				return $parser->parse( $markdown );
			case self::PARSER_CICONIA:
				$parser	= new Ciconia(new XhtmlRenderer());
				return $parser->render( $markdown );
			case self::PARSER_CICONIA_GITHUB:
				$parser	= new Ciconia(new XhtmlRenderer());
				$parser->addExtension(new Gfm\FencedCodeBlockExtension());
				$parser->addExtension(new Gfm\TaskListExtension());
				$parser->addExtension(new Gfm\InlineStyleExtension());
				$parser->addExtension(new Gfm\WhiteSpaceExtension());
				$parser->addExtension(new Gfm\TableExtension());
				$parser->addExtension(new Gfm\UrlAutoLinkExtension());
				return $parser->render( $markdown );
			case self::PARSER_MARKDOWN_EXTENDED:
				$parser = new \MarkdownExtended\Parser();
				return $parser->transform( $markdown );
			case self::PARSER_COMMONMARK:
			default:
				$converter = new CommonMarkConverter();
				return $converter->convertToHtml( $markdown );
		}
	}

	public function setParser( $parser ){
		$this->parser	= $parser;
	}
}
?>

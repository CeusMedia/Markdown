<?php
namespace CeusMedia\Markdown;

use \CeusMedia\Markdown\Parser;

class Suggest
{
	const REQUIRE_EXTRA			= 5;
	const REQUIRE_GITHUB		= 6;
	const REQUIRE_CLI			= 0;
	const REQUIRE_SPEED			= 9;

	public static function suggest( array $requirements = [] )
	{
		$reflection	= new \ReflectionClass( '\CeusMedia\Markdown\Parser' );
		$parsers	= array();
		foreach( $reflection->getConstants() as $key => $value ){
			if( str_starts_with( $key, 'PARSER_' ) )
				$parsers[$key]	= $value;
		}
		foreach( $requirements as $requirement ){
			if( $requirement == self::REQUIRE_EXTRA ){
				$parsers	= array_intersect( $parsers, array(
					Parser::PARSER_PARSEDOWN,
					Parser::PARSER_MICHELF_EXTRA,
					Parser::PARSER_CEBE_EXTRA,
				) );
			}
			if( $requirement == self::REQUIRE_GITHUB ){
				$parsers	= array_intersect( $parsers, array(
					Parser::PARSER_PARSEDOWN,
					Parser::PARSER_CEBE_GITHUB,
					Parser::PARSER_CICONIA_GITHUB,
				) );
			}
			if( $requirement == self::REQUIRE_CLI ){
				$parsers	= array_intersect( $parsers, array(
					Parser::PARSER_COMMONMARK,
					Parser::PARSER_CEBE,
					Parser::PARSER_CEBE_EXTRA,
					Parser::PARSER_CEBE_GITHUB,
					Parser::PARSER_CICONIA,
					Parser::PARSER_CICONIA_GITHUB,
					Parser::PARSER_MARKDOWN_EXTENDED,
				) );
			}
		}
		return $parsers;
	}
}

<?php
namespace CeusMedia\Markdown;

use CeusMedia\Markdown\Renderer\Html as HtmlRenderer;

class Suggest
{
	const REQUIRE_EXTRA			= 5;
	const REQUIRE_GITHUB		= 6;
	const REQUIRE_CLI			= 0;
	const REQUIRE_SPEED			= 9;

	public static function suggest( array $requirements = [] ): array
	{
		$parsers	= HtmlRenderer::getRenderers();

		foreach( $requirements as $requirement ){
			if( self::REQUIRE_EXTRA === $requirement ){
				$parsers	= array_intersect( $parsers, [
					HtmlRenderer::RENDERER_PARSEDOWN,
					HtmlRenderer::RENDERER_MICHELF_EXTRA,
					HtmlRenderer::RENDERER_CEBE_EXTRA,
				] );
			}
			if( self::REQUIRE_GITHUB === $requirement ){
				$parsers	= array_intersect( $parsers, [
					HtmlRenderer::RENDERER_PARSEDOWN,
					HtmlRenderer::RENDERER_CEBE_GITHUB,
					HtmlRenderer::RENDERER_CICONIA_GITHUB,
				] );
			}
			if( self::REQUIRE_CLI === $requirement ){
				$parsers	= array_intersect( $parsers, [
					HtmlRenderer::RENDERER_COMMONMARK,
					HtmlRenderer::RENDERER_CEBE,
					HtmlRenderer::RENDERER_CEBE_EXTRA,
					HtmlRenderer::RENDERER_CEBE_GITHUB,
					HtmlRenderer::RENDERER_CICONIA,
					HtmlRenderer::RENDERER_CICONIA_GITHUB,
					HtmlRenderer::RENDERER_MARKDOWN_EXTENDED,
				] );
			}
		}
		return $parsers;
	}
}

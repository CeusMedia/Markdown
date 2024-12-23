<?php

namespace Parser;

use CeusMedia\Markdown\Parser\Html as HtmlParser;
use CeusMedia\Markdown\Renderer\Html as HtmlRenderer;
use PHPUnit\Framework\TestCase;

class HtmlTest extends TestCase
{
	protected string $html;
	protected string $path;
	protected HtmlParser $parser;

	public function testConvert(): void
	{
		$filePath	= $this->path.'testOutput.md';
		$html		= file_get_contents( $this->path.'test.html' );
		self::assertStringEqualsFile( $filePath, $this->parser->convert( $html ) );
	}

	public function testGetParsers(): void
	{
		self::assertEquals( ['PARSER_COMMONMARK' => 1], HtmlParser::getParsers() );
	}

	public function testRender(): void
	{
		$filePath	= $this->path.'testOutput.md';
		$html		= file_get_contents( $this->path.'test.html' );
		self::assertStringEqualsFile( $filePath, $this->parser->render( $html ) );
	}

	public function testTransform(): void
	{
		$filePath	= $this->path.'testOutput.md';
		$html		= file_get_contents( $this->path.'test.html' );
		self::assertStringEqualsFile( $filePath, $this->parser->transform( $html ) );
	}

	public function testParse(): void
	{
		$filePath	= $this->path.'testOutput.md';
		$html		= file_get_contents( $this->path.'test.html' );
		self::assertStringEqualsFile( $filePath, $this->parser->convert( $html ) );
	}

	protected function setUp(): void
	{
		$this->path		= __DIR__ . '/';
		$this->parser	= new HtmlParser();
	}
}
<?php

namespace Renderer;

use CeusMedia\Markdown\Renderer\Html as HtmlRenderer;
use PHPUnit\Framework\TestCase;

class HtmlTest extends TestCase
{
	protected string $markdown;
	protected string $path;
	protected HtmlRenderer $renderer;

	public function testRender(): void
	{
		foreach( HtmlRenderer::getRenderers() as $renderer ){
			if( HtmlRenderer::RENDERER_DEFAULT === $renderer )
				continue;
			$this->renderer->setRenderer( $renderer );
			$filePath	= $this->path.'testOutputRenderer'.$renderer.'.html';
	//		file_put_contents( $filePath, $this->renderer->render( $this->markdown ) );
			self::assertStringEqualsFile( $filePath, $this->renderer->render( $this->markdown ) );
		}
	}

	public function testStaticRenderString(): void
	{
		foreach( HtmlRenderer::getRenderers() as $renderer ){
			if( HtmlRenderer::RENDERER_DEFAULT === $renderer )
				continue;
			$this->renderer->setRenderer( $renderer );
			$filePath	= $this->path.'testOutputRenderer'.$renderer.'.html';
	//		file_put_contents( $filePath, $this->renderer->render( $this->markdown ) );
			self::assertStringEqualsFile( $filePath, HtmlRenderer::renderString( $this->markdown, $renderer ) );
		}
	}

	protected function setUp(): void
	{
		$this->path = __DIR__ . '/';
		$this->markdown = file_get_contents($this->path . 'test.md');
		$this->renderer = new HtmlRenderer();
	}
}
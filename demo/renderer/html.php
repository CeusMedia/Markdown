<?php
require_once '../../vendor/autoload.php';

use \CeusMedia\Markdown\Renderer\Html;

class Demo_Renderer_Html{

	protected $renderer;
	protected $file;

	public function run(){
		if( isset( $_GET['file'] ))
			$this->file	= $_GET['file'];
		if( isset( $_GET['renderer'] ))
			$this->renderer	= $_GET['renderer'];
		print( $this->render() );
	}

	protected function render(){
		$content	= '';
		if( $this->file && $this->renderer ){
			$markdown	= file_get_contents( $this->file );
			$converter	= new Html( $this->renderer );
			$html		= $converter->convert( $markdown );
			$content	= '
			<h3>Resulting HTML</h3>
			<div class="demo-code-container">
				'.$html.'
			</div>
			<h3>Source Markdown</h3>
			<xmp class="demo-code-container">'.$markdown.'</xmp>
			';
		}

		$renderers		= Html::getRenderers();
		$optRenderer	= array( '<option value="">- select renderer -</option>' );
		foreach( $renderers as $key => $value )
			$optRenderer[]	= '<option value="'.$value.'" '.( $this->renderer == $value ? 'selected' : '' ).'>'.preg_replace( '/^RENDERER_/', '', $key ).'</option>';
		$optRenderer	= join( $optRenderer );


		$optFile	= array( '<option value="">- select file -</option>' );
		$index	= new \DirectoryIterator('./');
		foreach( $index as $entry ){
			if( $entry->isDir() || $entry->isDot() )
				continue;
			if( !preg_match( '/md$/', $entry->getFilename() ) )
				continue;
			$optFile[]	= '<option value="'.$entry->getFilename().'" '.( $this->file == $entry->getFilename() ? 'selected' : '' ).'>'.$entry->getFilename().'</option>';
		}
		$optFile	= join( $optFile );

		$html		= '<html>
	<head>
		<script src="https://cdn.ceusmedia.de/js/jquery/1.10.2.min.js"></script>
		<link rel="stylesheet" href="//cdn.ceusmedia.de/css/bootstrap.min.css"/>
		<script>
jQuery(document).ready(function(){
	jQuery(".content table").addClass("table");
});
		</script>
		<link rel="stylesheet" href="../style.css"/>
	</head>
	<body>
		<div class="navbar navbar-static-top">
			<div class="navbar-inner">
				<div class="container">
					<form action.="./html.php" method="get">
					<span class="brand">Markdown <small>&gt;</small> <a href="../">Demo</a> <small>&gt;</small> <a href="./">Renderer</a> <small>&gt;</small> <strong>HTML</strong></span>
						<ul class="nav nav-list">
							<li><select name="file" onchange="this.form.submit();">'.$optFile.'</select></li>
							<li><select name="renderer" onchange="this.form.submit();">'.$optRenderer.'</select></li>
						</ul>
					</form>
				</div>
			</div>
		</div>
		<br/>
		<div class="container">
			'.$content.'
		</div>
	</body>
</html>';
		print( $html );
	}

	public function setRenderer( $renderer ){
		$this->renderer	= $renderer;
	}
}

$app	= new Demo_Renderer_Html();
$app->setRenderer( Html::RENDERER_PARSEDOWN );
$app->setRenderer( Html::RENDERER_MICHELF );
$app->setRenderer( Html::RENDERER_MICHELF_EXTRA );
$app->setRenderer( Html::RENDERER_CEBE );
$app->setRenderer( Html::RENDERER_CEBE_GITHUB );
$app->setRenderer( Html::RENDERER_CICONIA );
$app->setRenderer( Html::RENDERER_CICONIA_GITHUB );
#$app->setRenderer( Html::RENDERER_MARKDOWN_EXTENDED );
$app->run();

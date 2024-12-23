<?php
require_once '../../../vendor/autoload.php';
error_reporting( E_ALL );
ini_set('display_errors', 'On');

use \CeusMedia\Markdown\Parser\Html;

class Demo_Parser_Html
{
	protected $parser;
	protected $file;

	public function run(){
		if( isset( $_GET['file'] ))
			$this->file	= $_GET['file'];
		if( isset( $_GET['parser'] ))
			$this->parser	= $_GET['parser'];
		print( $this->render() );
	}

	protected function render(): void
	{
		$content	= '';
		if( $this->file && $this->parser ){
			$html		= file_get_contents( $this->file );
			$converter	= new Html( $this->parser );
			$markdown	= $converter->convert( $html );
			$content	= '
			<h3>Resulting Markdown</h3>
			<xmp class="demo-code-container">'.$markdown.'</xmp>
			<h3>Source HTML</h3>
			<div class="demo-code-container">'.$html.'</div>
			';
		}
		$parsers		= Html::getParsers();
		$optParser	= array( '<option value="">- select parser -</option>' );
		foreach( $parsers as $key => $value )
			$optParser[]	= '<option value="'.$value.'" '.( $this->parser == $value ? 'selected' : '' ).'>'.preg_replace( '/^PARSER_/', '', $key ).'</option>';
		$optParser	= join( $optParser );


		$optFile	= array( '<option value="">- select file -</option>' );
		$index	= new \DirectoryIterator('./');
		foreach( $index as $entry ){
			if( $entry->isDir() || $entry->isDot() )
				continue;
			if( !preg_match( '/\.html/', $entry->getFilename() ) )
				continue;
			$optFile[]	= '<option value="'.$entry->getFilename().'" '.( $this->file == $entry->getFilename() ? 'selected' : '' ).'>'.$entry->getFilename().'</option>';
		}
		$optFile	= join( $optFile );

		$html		= '<html>
	<head>
		<script src="https://cdn.ceusmedia.de/js/jquery/1.10.2.min.js"></script>
		<link rel="stylesheet" href="//cdn.ceusmedia.de/css/bootstrap.min.css"/>
		<script>
jQuery(document).ready(function(){});
		</script>
		<link rel="stylesheet" href="../style.css"/>
	</head>
	<body>
		<div class="navbar navbar-static-top">
			<div class="navbar-inner">
				<div class="container">
					<form action.="./html.php" method="get">
						<span class="brand">Markdown <small>&gt;</small> <a href="../../">Demo</a> <small>&gt;</small> <!--<a href="../">Parser</a>--><span>Parser</span> <small>&gt;</small> <strong>HTML</strong></span>
						<ul class="nav nav-list">
							<li><select name="file" onchange="this.form.submit();">'.$optFile.'</select></li>
							<li><select name="parser" onchange="this.form.submit();">'.$optParser.'</select></li>
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

	public function setParser( $parser ): self
	{
		$this->parser	= $parser;
		return $this;
	}

	protected function view( $file, $parser = Html::PARSER_COMMONMARK ): string
	{
		$parser		= $parser ? $parser : $this->parser;
		$markdown	= file_get_contents( $file );
		$converter	= new Html( $parser );
		return $converter->convert( $markdown );
	}
}

$app	= new Demo_Parser_Html();
#$app->setParser( Html::PARSER_COMMONMARK );
$app->run();

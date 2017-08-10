<?php
require_once '../vendor/autoload.php';

use \CeusMedia\Markdown\Parser;

class Demo_Parser{

	protected $parser;
	protected $file;

	public function run(){
		if( isset( $_GET['file'] ))
			$this->file	= $_GET['file'];
		if( isset( $_GET['parser'] ))
			$this->parser	= $_GET['parser'];

		$content	= '';
		if( $this->file )
			$content	= $this->view( $this->file );
		print( $this->render( $content ) );
	}

	protected function render( $content ){
		$parsers	= Parser::getParsers();
		$optParser	= array();
		foreach( $parsers as $key => $value )
			$optParser[]	= '<option value="'.$value.'" '.( $this->parser == $value ? 'selected' : '' ).'>'.preg_replace( '/^PARSER_/', '', $key ).'</option>';
		$optParser	= join( $optParser );


		$optFile	= array( '<option value="">- select file -</option>' );
		$index	= new DirectoryIterator('./');
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
	</head>
	<body>
		<div class="navbar navbar-static-top">
			<div class="navbar-inner">
				<div class="container">
					<form action.="./parse.php" method="get">
						<input type="hidden" name="file" value="'.$this->file.'"/>
						<a href="./parse.php" class="brand">Markdown Parser Demo</a>
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
			<div class="content">
				'.$content.'
			</div>
		</div>
	</body>
</html>';
		print( $html );
	}

	public function setParser( $parser ){
		$this->parser	= $parser;
	}

	protected function view( $file, $parser = Parser::PARSER_COMMONMARK ){
		$parser		= $parser ? $parser : $this->parser;
		$markdown	= file_get_contents( $file );
		$parser		= new Parser( $parser );
		return $parser->parse( $markdown );
	}
}

$app	= new Demo_Parser();
$app->setParser( Parser::PARSER_PARSEDOWN );
$app->setParser( Parser::PARSER_MICHELF );
$app->setParser( Parser::PARSER_MICHELF_EXTRA );
$app->setParser( Parser::PARSER_CEBE );
$app->setParser( Parser::PARSER_CEBE_GITHUB );
$app->setParser( Parser::PARSER_CICONIA );
$app->setParser( Parser::PARSER_CICONIA_GITHUB );
#$app->setParser( Parser::PARSER_MARKDOWN_EXTENDED );
$app->run();

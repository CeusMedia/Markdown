<?php
require_once '../vendor/autoload.php';

use \CeusMedia\Markdown\Suggest;

class Demo_Suggest{

	protected $requires;

	public function run(){

		if( !empty( $_GET['require'] ) )
			$this->requires	= $_GET['require'];

		$requirements	= array();
		$reflection	= new \ReflectionClass( '\CeusMedia\Markdown\Suggest' );
		foreach( $reflection->getConstants() as $key => $value ){
			if( preg_match( '/^REQUIRE_/', $key ) )
				if( isset( $this->requires[$key] ) )
					$requirements[]	= constant( '\CeusMedia\Markdown\Suggest::'.$key );
		}
		$content	= Suggest::suggest( $requirements );
		$this->render( $content );
	}

	protected function render( $content ){
		$parsers	= array();

		$list	= array();
		$reflection	= new \ReflectionClass( '\CeusMedia\Markdown\Suggest' );
		foreach( $reflection->getConstants() as $key => $value ){
			if( !preg_match( '/^REQUIRE_/', $key ) )
				continue;
			$input	= '<input type="checkbox" name="require['.$key.']" '.( isset( $this->requires[$key] ) ? 'checked' : '' ).' onchange="this.form.submit()"/>';
			$label	= '<label class="checkbox">'.$input.' '.$key.'</label>';
			$list[]	= '<li>'.$label.'</li>';
		}
		$checkboxes	= '<ul class="unstyled">'.join( $list ).'</ul>';

		$list	= array();
		foreach( $content as $parserName => $parserNumber ){
			$list[]	= '<li>'.$parserName.'</li>';
		}
		$parsers	= '<ul>'.join( $list ).'</ul>';

		$html	= '<html>
	<head>
		<link rel="stylesheet" href="//cdn.ceusmedia.de/css/bootstrap.min.css"/>
	</head>
	<body>
		<div class="navbar navbar-static-top">
			<div class="navbar-inner">
				<div class="container">
					<a href="./parse.php" class="brand">Markdown Suggest Demo</a>
					<ul class="nav nav-list">
						<li><a href=""></a></li>
					</ul>
				</div>
			</div>
		</div>
		<br/>
		<div class="container">
			<div class="row-fluid">
				<div class="span6">
					<h3>Requirements</h3>
					<p><small class="muted">Select required features.</small></p>
					<form action="./suggest.php" method="get">
						'.$checkboxes.'
					</form>
				</div>
				<div class="span6">
					<h3>Parsers</h3>
					<p><small class="muted">These parsers support your requirements.</small></p>
					'.$parsers.'
				</div>
			</div>
		</div>
	</body>
</html>';
		print( $html );
	}
}

$app	= new Demo_Suggest();
$app->run();

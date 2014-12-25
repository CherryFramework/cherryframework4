<?php

require_once "class-scss.inc.php";

$scssInput = PARENT_DIR .'/assets/scss/main.scss';
$cssOutput = PARENT_DIR .'/assets/css/main.css';

class scssCompiler extends scssc{
	function __construct(){
		parent::setFormatter("scss_formatter");
		parent::addImportPath(PARENT_DIR .'/assets/scss/');
	}

	public function auto_scss_compile($inputFile, $outputFile) {
		$inputFileContent = file_get_contents($inputFile);
		try {
			$compiledCss = parent::compile($inputFileContent);
		} catch (Exception $ex) {
			echo $ex->getMessage();
		}

		file_put_contents($outputFile, $compiledCss);
	}
}

$compiler = new scssCompiler();
$compiler -> auto_scss_compile($scssInput, $cssOutput);

?>
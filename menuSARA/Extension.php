#!/usr/bin/env php
<?php
/*
 * This file is part of Composer.
 *
 * (c) Jorge Useche <juusechec@udistrital.edu.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

process(is_array($argv) ? $argv : array());

/**
 * processes the installer
*/
function process($argv){
	var_dump($argv);
	/*
	 * Se obtienen los argumentos de instalación del módulo de $argv
	 * $ php Extension.php argumento1=valor1 argumento2=valor2
	 */
	echo '<p>Comenzando la instalación</p><br />';
}

?>

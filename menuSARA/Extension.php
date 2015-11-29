<?php
#!/usr/bin/env php
/*
 * This file is part of Composer.
 *
 * (c) Jorge Useche <juusechec@udistrital.edu.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
process(isset($argv)&&is_array($argv) ? $argv : array());

/**
 * processes the installer
*/
function process($argv){
	foreach ($argv as $arg) {
		$e=explode("=",$arg);
		if(count($e)==2)
			$params[$e[0]]=$e[1];
		else
			$params=$e[0];
	}
	/*
	 * Se obtienen los argumentos de instalación del módulo de $argv
	 * $ php Extension.php argumento1=valor1 argumento2=valor2
	 */
	echo 'Comenzando la instalación...<br />';
	$directorioDatos = $params['directorio_extension'].'/data';
	$files = directoryToArray($directorioDatos,true);
	var_dump($files);
	recursiveDiffFiles($directorioDatos,$params['directorio_sara'],$files);
	
}

function directoryToArray($directory, $onlyFiles=false, $originalDirectory='', $recursive=true) {
	$originalDirectory = ($originalDirectory=='') ? $directory : $originalDirectory;
	$array_items = array();
	if ($handle = opendir($directory)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				if (is_dir($directory. "/" . $file)) {
					if($recursive) {
						$array_items = array_merge($array_items, directoryToArray($directory. "/" . $file, $onlyFiles, $originalDirectory, $recursive));
					}
					//$file = $directory . "/" . $file;
					if(!$onlyFiles){
						$file = str_replace($originalDirectory,'',$directory) . "/" . $file;
						$array_items[] = preg_replace("/\/\//si", "/", $file);
					}					
				} else {
					//$file = $directory . "/" . $file;
					$file = str_replace($originalDirectory,'',$directory) . "/" . $file;
					$array_items[] = preg_replace("/\/\//si", "/", $file);
				}
			}
		}
		closedir($handle);
	}
	return $array_items;
}

function dirToArray($dir) {
  
   $result = array();

   $cdir = scandir($dir);
   foreach ($cdir as $key => $value)
   {
      if (!in_array($value,array(".","..")))
      {
         if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
         {
            $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
         }
         else
         {
         	$result[] = $value;
         }
      }
   }
  
   return $result;
}

function recursiveDiffFiles($orig,$dest,$files){
	foreach($files AS $file){
		$old_version = $dest.$file;
		$patch = $orig.$file;
		
		$errors = xdiff_file_patch($old_version, $patch, 'my_script-1.1.php');
		if (is_string($errors)) {
			echo "Rejects:\n";
			echo $errors;
		}
		
	}
}

?>

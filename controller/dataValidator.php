<?php

	# Verificar datos #
	function verificar_datos($filtro,$cadena){
		if(preg_match("/^".$filtro."$/", $cadena)){
			return false;
        }else{
            return true;
        }
	}
	// fuhcion para detectar intenciones malisiosas
	function detectMaliciousIntent($chain){
		$maliciousPatterns = [
			"SELECT * FROM",
			"DELETE FROM",
			"INSERT INTO",
			"DROP TABLE",
			"DROP DATABASE",
			"TRUNCATE TABLE",
			"SHOW TABLES",
			"SHOW DATABASES",
			"UPDATE",
			"CREATE",
			"ALTER",
			"RENAME",
			"DESCRIBE"
		];
	
		foreach ($maliciousPatterns as $pattern){
			if (stripos($chain, $pattern) !== false) {				
				trigger_error(E_USER_WARNING." - Intento malicioso detectado.");
				return true;
			}
		}
	}
	
	// Limpiar cadenas de texto 
	function cleanChain(&$chain){
		$chain = trim($chain);
		$chain = stripslashes($chain);
	
		// Eliminar etiquetas HTML y scripts
		$chain = str_ireplace("<script>", "", $chain);
		$chain = str_ireplace("</script>", "", $chain);
		$chain = str_ireplace("<script src", "", $chain);
		$chain = str_ireplace("<script type=", "", $chain);
		$chain = str_ireplace("<?php", "", $chain);
		$chain = str_ireplace("?>", "", $chain);
	
		// Eliminar etiquetas HTML básicas
		$chain = str_ireplace("<", "", $chain);
		$chain = str_ireplace(">", "", $chain);
		$chain = str_ireplace("/", "", $chain);
	
		// Eliminar caracteres especiales
		$chain = str_ireplace("'", "", $chain);
		$chain = str_ireplace("\"", "", $chain);
		$chain = str_ireplace(";", "", $chain);
		$chain = str_ireplace("\\", "", $chain);
	
		// Eliminar operadores SQL
		$//chain = str_ireplace("OR", "", $chain);
		$chain = str_ireplace("AND", "", $chain);
		$chain = str_ireplace("NOT", "", $chain);
		$chain = str_ireplace("LIKE", "", $chain);
		$chain = str_ireplace("=", "", $chain);
	
		$chain = trim($chain);
		$chain = stripslashes($chain);
	}
	
				
//validador de cadenas
function validateParams(&...$params){
    foreach ($params as &$param) {
        // Validar que el parámetro esté definido, no sea nulo y no esté vacío
        if (!isset($param) || is_null($param) || trim($param) === ''){
			return true;
        }

        // Detectar cualquier intento malicioso
        if(detectMaliciousIntent($param)){
			return true;
		}

        // Limpiar la cadena
        cleanChain($param);
    }
    
}








	

	
<?php
error_reporting(E_PARSE);
class ejecutarSQL {
	
    /*public static function conectar(){
        if(!$con=  mysql_connect(SERVER,USER,PASS)){
            die("Error en el servidor, verifique sus datos");
        }
        if (!mysql_select_db(BD)) {
            die("Error al conectar con la base de datos, verifique el nombre de la base de datos");
        }
        mysql_set_charset('utf8',$con);
        return $con;  
    }
    public static function consultar($query) {
        mysql_query("SET AUTOCOMMIT=0;", self::conectar());
        mysql_query("BEGIN;", ejecutarSQL::conectar());
        if (!$consul = mysql_query($query, ejecutarSQL::conectar())) {
            die(mysql_error().' Error en la consulta SQL ejecutada ');
            mysql_query("ROLLBACK;", ejecutarSQL::conectar());
        }else{
            mysql_query("COMMIT;", ejecutarSQL::conectar());
        }
        return $consul;
    }*/
	public static function conectar(){
		$mysqli = new mysqli('localhost','root','123456','librarysystem');
		if ($mysqli->connect_errno) {
			die("Error al conectar con la base de datos, verifique el nombre de la base de datos");
		}
		return $mysqli;
	}
	
	public static function consultar($query){
		$mysqli = self::conectar();
		if(!$consult = $mysqli->query($query)){
			die($mysqli->error.' Error en la consulta SQL ejecutada ');
		} else {
			mysqli_commit($mysqli);
		}
		return $consult;
	}
	
}
class consultasSQL{
    public static function limpiarCadena($valor) {
        $valor = str_ireplace("<script>", "", $valor);
        $valor = str_ireplace("</script>", "", $valor);
        $valor = str_ireplace("--", "", $valor);
        $valor = str_ireplace("^", "", $valor);
        $valor = str_ireplace("[", "", $valor);
        $valor = str_ireplace("]", "", $valor);
        //$valor = str_ireplace("\\", "", $valor);
        $valor = str_ireplace("=", "", $valor);
        return $valor;
    }
    public static function CleanStringText($val) {
        $data = addslashes($val);
        $datos = consultasSQL::limpiarCadena($data);
        return $datos;
    }
    public static function InsertSQL($tabla, $campos, $valores) {
        if (!$consul = ejecutarSQL::consultar("insert into $tabla ($campos) VALUES($valores)")) {
            die("Ha ocurrido un error al guardar los datos");
        }
        return $consul;
    }
    public static function DeleteSQL($tabla, $condicion) {
        if (!$consul = ejecutarSQL::consultar("delete from $tabla where $condicion")) {
            die("Ha ocurrido un error al eliminar los datos");
        }
        return $consul;
    }
    public static function UpdateSQL($tabla, $campos, $condicion) {
        if (!$consul = ejecutarSQL::consultar("update $tabla set $campos where $condicion")) {
            die("Ha ocurrido un error al actualizar los datos");
        }
        return $consul;
    }
}

<?php
	//abstract -> Não Permite que essa class seja estanciada diretamente
	abstract class Connection{
		private static $conn;		

		public static function getConn(){
			if(self::$conn == null){
				// self:: Porque é um atributo estático se não a gente usaria o this->$conn
				self::$conn = new PDO('mysql: host=localhost; dbname=bludata;', 'root', '');
			}			

			return self::$conn;
		}
	}
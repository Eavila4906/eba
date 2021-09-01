<?php
    class MySQL extends ConecctionDB {
        private $conexion;
        private $strQuery;
        private $arrayValues;

        public function __construct() {
            $this->conexion =new ConecctionDB();
            $this->conexion = $this->conexion->Connec();
        }

        // insertar registros
        public function InsertMySQL(String $Query, array $arrayValues) {
            $this->strQuery = $Query;
            $this->arrayValues = $arrayValues;
            $Insert = $this->conexion->prepare($this->strQuery);
            $resul_insert = $Insert->execute($this->arrayValues);
            if ($resul_insert) {
                $lastinsert = $this->conexion->lastinsertId();
            } else {
                $lastinsert = 0;
            }
            return $lastinsert;
        }

        // Actualizar registros 
        public function UpdateMySQL(String $Query, array $arrayValues) {
            $this->Query = $Query;
            $this->arrayValues = $arrayValues;
            $update = $this->conexion->prepare($this->Query);
            $result = $update->execute($this->arrayValues);
            if ($result) {
                $lastActualizar = 1;
            } else {
                $lastActualizar = 0;
            }
            return $lastActualizar;
        }

        // Eliminar registros
        public function DeleteMySQL(String $Query) {
            $this->Query = $Query;
            $result = $this->conexion->prepare($this->Query);
            $result->execute();
            if ($result) {
                $lastEliminar = 1;
            } else {
                $lastEliminar = 0;
            }
            return $lastEliminar;
        }

        // Buscar un registro
        public function SelectMySQL(String $Query) {
            $this->strQuery = $Query;
            $result = $this->conexion->prepare($this->strQuery);
            $result->execute();
            $data = $result->fetch(PDO::FETCH_ASSOC);
            return $data;
        }

        // Buscar varios registros
        public function SelectAllMySQL(String $Query) {
            $this->strQuery = $Query;
            $result = $this->conexion->prepare($this->strQuery);
            $result->execute();
            $data = $result->fetchall(PDO::FETCH_ASSOC);
            return $data;
        }
    }
?>
<?php
    class PaymentModel extends Mysql {
        public function __construct(){
            parent::__construct();
        }

        public function SelectAllPayment() {
            $Query_Select_All = "SELECT  pa.id_payment, estudiante AS DNI, CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS estudiante
                                    FROM payment pa INNER JOIN usuario us ON (pa.estudiante=us.DNI) GROUP BY estudiante";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectSeePayment(int $dni) {
            $this->dni = $dni;
            $Query_Select = "SELECT pa.estudiante AS DNI, CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS estudiante,
                                    pa.periodo, COUNT(pa.estudiante) AS cantidad, pa.valor, SUM(pa.valor) AS total_pago, 
                                    pa.estado
                                FROM payment pa INNER JOIN usuario us ON (pa.estudiante=us.DNI) 
                                WHERE pa.estudiante = '$this->dni' GROUP BY pa.estudiante, pa.periodo";
            $result = $this->SelectAllMySQL($Query_Select);
            return $result;
        }
    }
?>
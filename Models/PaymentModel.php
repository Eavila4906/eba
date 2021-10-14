<?php
    class PaymentModel extends Mysql {
        public function __construct(){
            parent::__construct();
        }

        public function SelectAllPayment() {
            $Query_Select_All = "SELECT  pa.id_payment, estudiante AS DNI, CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS estudiante
                                    FROM detail_payment dp INNER JOIN payment pa ON (dp.id_detail_payment=pa.id_payment) 
                                    INNER JOIN usuario us ON (dp.estudiante=us.DNI) 
                                    GROUP BY dp.estudiante";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectSeePayment(int $dni) {
            $this->dni = $dni;
            $Query_Select = "SELECT dp.estudiante AS DNI, CONCAT(us.nombres, ' ', us.apellidoP, ' ', us.apellidoM) AS estudiante,
                                pa.periodo, COUNT(dp.estudiante) AS cantidad, pa.valor, SUM(pa.valor) AS total_pago, 
                                pa.estado
                                FROM detail_payment dp INNER JOIN payment pa ON (dp.id_detail_payment=pa.id_payment)
                                INNER JOIN usuario us ON (dp.estudiante=us.DNI)
                                WHERE dp.estudiante = '$this->dni' GROUP BY dp.estudiante, pa.periodo, pa.estado 
                                ORDER BY pa.periodo DESC";
            $result = $this->SelectAllMySQL($Query_Select);
            return $result;
        }

        public function SelectSeeIndividualPayments0(String $periodo, String $dni) {
            $this->periodo = $periodo;
            $this->dni = $dni;

            $Query_Select_All = "SELECT pa.id_payment, pa.tipo_pago, pa.fecha_pago, pa.valor, pa.estado, pa.observacion, pa.descripcion 
                                    FROM detail_payment dp INNER JOIN payment pa ON (dp.id_detail_payment=pa.id_payment) 
                                    WHERE dp.estudiante = '$this->dni' AND pa.periodo = '$this->periodo' AND pa.estado != 5";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectSeeIndividualPayments1(String $periodo, String $dni) {
            $this->periodo = $periodo;
            $this->dni = $dni;

            $Query_Select_All = "SELECT pa.id_payment, pa.tipo_pago, pa.fecha_pago, pa.valor, pa.estado, pa.observacion, pa.descripcion 
                                    FROM detail_payment dp INNER JOIN payment pa ON (dp.id_detail_payment=pa.id_payment) 
                                    WHERE dp.estudiante = '$this->dni' AND pa.periodo = '$this->periodo' AND pa.estado = 5";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }
    }
?>
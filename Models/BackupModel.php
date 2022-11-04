<?php
    class BackupModel extends MySQL {
        public function __construct(){
            parent::__construct();
        }

        public function SelectAllBackup() {
            $Query_Select_All = "SELECT bc.id_backup, bc.nameFile, us.username AS create_by, rl.nombreRol, db.creation_date, db.status  
                                 FROM detail_backup db INNER JOIN backup bc ON (bc.id_backup=db.backup)
                                 INNER JOIN usuario us ON (us.DNI=db.create_by)
                                 INNER JOIN roles rl ON (rl.id_rol=us.rol)";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectBackup(int $id_backup) {
            $this->id_backup = $id_backup;
            $Query_Select = "SELECT bc.id_backup, bc.nameFile, us1.username AS create_by, db.creation_date, 
                                    us2.username AS eliminated_by, db.removal_date, db.status 
                             FROM detail_backup db INNER JOIN backup bc ON (bc.id_backup=db.backup)
                             INNER JOIN usuario us1 ON (us1.DNI=db.create_by)
                             INNER JOIN usuario us2 ON (us2.DNI=db.eliminated_by)
                             INNER JOIN roles rl ON (rl.id_rol=us1.rol)
                             WHERE bc.id_backup = $this->id_backup";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function InsertBackup(String $nameFile, String $create_by) {
            $this->nameFile = $nameFile;
            $this->create_by = $create_by;
            $result = 0;

            $Query_Insert_backup = "INSERT INTO backup (nameFile) VALUE (?)";
            $Array_Query_backup = array($this->nameFile);
            $result_backup = $this->InsertMySQL($Query_Insert_backup, $Array_Query_backup);

            $Query_Insert_d_backup = "INSERT INTO detail_backup (backup, create_by, eliminated_by, status) VALUES (?, ?, ?, ?)";
            $Array_Query_d_backup = array($result_backup, $this->create_by, $this->create_by, 1);
            $result_d_backup = $this->InsertMySQL($Query_Insert_d_backup, $Array_Query_d_backup);

            if ($result_backup > 0 && $result_d_backup > 0) {
                $result = 1;
            }
            return $result;
        }

        public function DeleteBackup(int $id_backup, String $eliminated_by) {
            $this->id_backup = $id_backup;
            $this->eliminated_by = $eliminated_by;

            $Query_Update = "UPDATE detail_backup SET eliminated_by=?, removal_date=current_timestamp(), status=?
                             WHERE backup = $this->id_backup";
            $Array_Query = array($this->eliminated_by, 0);
            $result = $this->UpdateMySQL($Query_Update, $Array_Query);
            if ($result) {
                $result = "ok";
            } else {
                $result = "Error";
            }
            return $result;
        }
    }
?>
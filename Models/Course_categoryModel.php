<?php
    class Course_categoryModel extends MySQL {
        public function __construct(){
            parent::__construct();
        }

        public function SelectAllCategory() {
            $Query_Select_All = "SELECT * FROM course_categoryWHERE status = 0";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }

        public function SelectCategory(int $id_category) {
            $this->id_category = $id_category;
            $Query_Select = "SELECT * FROM course_category WHERE id_course_category = $this->id_category";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }

        public function InsertCategory(String $category, String $description, int $status) {
            $this->category = $category;
            $this->description = $description;
            $this->status = $status;

            $Query_Select_All = "SELECT * FROM course_category WHERE category = '$this->category' AND estadoRol == 0 ";
            $result_Select_All = $this->SelectAllMySQL($Query_Select_All);

            if (empty($result_Select_All)) {
                $Query_Insert = "INSERT INTO course_category (category, description, status) VALUES (?, ?, ?)";
                $Array_Query = array($this->category, $this->description, $this->status);
                $result = $this->InsertMySQL($Query_Insert, $Array_Query);
            } else {
                $result = "exists";
            }
            return $result;
        }

        public function UpdateCategory(int $id_category, String $category, String $description, int $status) {
            $this->id_category = $id_category;
            $this->category = $category;
            $this->description = $description;
            $this->status = $status;

            $Query_Select_All = "SELECT * FROM course_category WHERE category = '$this->category' AND id_course_category != $this->id_category AND status == 0";
            $result_Select_All = $this->SelectAllMySQL($Query_Select_All);

            if (empty($result_Select_All)) {
                $Query_Update = "UPDATE course_category SET category=?, description=?, status=? WHERE id_course_category = $this->id_category";
                $Array_Query = array($this->id_category, $this->description, $this->status);
                $result = $this->UpdateMySQL($Query_Update, $Array_Query);
            } else {
                $result = "exists";
            }
            return $result;
        }

        public function DeleteCategory(int $id_category) {
            $this->id_category = $id_category;

            /*$Query_Select_All = "SELECT * FROM usuario WHERE rol = $this->id_category";
            $result_Select_All = $this->SelectAllMySQL($Query_Select_All);*/

            if (empty($result_Select_All)) {
                $Query_Delete = "DELETE FROM course_category WHERE id_course_category = $this->id_category";
                $result = $this->DeleteMySQL($Query_Delete);
                if ($result) {
                    $result = "ok";
                } else {
                    $result = "Error";
                }
            } else {
                $result = "Exists";
            }
            return $result;
        }
        
    }
?>
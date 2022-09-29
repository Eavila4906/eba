<?php
    class CoursesModel extends MySQL {
        public function __construct(){
            parent::__construct();
        }
        
        public function SelectAllCourses() {
            $Query_Select_All = "SELECT * FROM course co INNER JOIN course_category cc 
                                          ON (co.category=cc.id_course_category)";
            $result = $this->SelectAllMySQL($Query_Select_All);
            return $result;
        }
        
        public function SelectCourse(int $id_course) {
            $this->id_course = $id_course;
            $Query_Select = "SELECT * FROM course co INNER JOIN course_category cc 
                                      ON (co.category=cc.id_course_category)
                                      WHERE id_course = $this->id_course";
            $result = $this->SelectMySQL($Query_Select);
            return $result;
        }
        
        public function InsertCourse(String $course, int $category, String $description, String $dateStart, String $dateFinal, $value, int $status) {
            $this->course = $course;
            $this->category = $category;
            $this->description = $description;
            $this->dateStart = $dateStart;
            $this->dateFinal = $dateFinal;
            $this->value = $value;
            $this->status = $status;

            $Query_Select_All = "SELECT * FROM course WHERE name = '$this->course' AND status = 1 ";
            $result_Select_All = $this->SelectAllMySQL($Query_Select_All);

            if (empty($result_Select_All)) {
                $Query_Insert = "INSERT INTO course (name, category, description, date_start, date_final, value, status) 
                                 VALUES (?, ?, ?, ?, ?, ?, ?)";
                $Array_Query = array($this->course, $this->category, 
                                     $this->description, $this->dateStart,
                                     $this->dateFinal, $this->value,
                                     $this->status);
                $result = $this->InsertMySQL($Query_Insert, $Array_Query);
            } else {
                $result = "exists";
            }
            return $result;
        }

        public function UpdateCourse(int $id_course, String $course, int $category, String $description, String $dateStart, String $dateFinal, $value, int $status) {
            $this->id_course = $id_course;
            $this->course = $course;
            $this->category = $category;
            $this->description = $description;
            $this->dateStart = $dateStart;
            $this->dateFinal = $dateFinal;
            $this->value = $value;
            $this->status = $status;

            $Query_Select_All = "SELECT * FROM course WHERE name = '$this->course' AND id_course != $this->id_course AND status = 1";
            $result_Select_All = $this->SelectAllMySQL($Query_Select_All);

            if (empty($result_Select_All)) {
                $Query_Update = "UPDATE course SET name=?, category=?, description=?, date_start=?, date_final=?, value=?, status=? 
                                 WHERE id_course = $this->id_course";
                $Array_Query = array($this->course, $this->category, 
                                     $this->description, $this->dateStart,
                                     $this->dateFinal, $this->value,
                                     $this->status);
                $result = $this->UpdateMySQL($Query_Update, $Array_Query);
            } else {
                $result = "exists";
            }
            return $result;
        }
        
        public function DeleteCourse(int $id_course) {
            $this->id_course = $id_course;

            $Query_Select_All = "SELECT * FROM detail_accounting WHERE course = $this->id_course";
            $result_Select_All = $this->SelectAllMySQL($Query_Select_All);

            if (empty($result_Select_All)) {
                $Query_Delete = "DELETE FROM course WHERE id_course = $this->id_course";
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
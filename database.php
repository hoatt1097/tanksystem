<?php 
    class Database{
        private $conn =  null;
        private $host = 'localhost';
        private $user = 'root';
        private $pass = '';
        private $data = 'tanksystem';
        private $result = null;

        private function connect(){
            $this->conn = new mysqli($this->host,$this->user,$this->pass,$this->data) 
            or die ('Kết nối thất bại!');
            $this->conn->query('SET NAMES UTF8');
        }

        public function select($sql)
        {
            $this->connect();
            $this->result = $this->conn->query($sql);
        }

        public function fetch()
        {
            if($this->result->num_rows > 0)
            {
                $rows = $this->result->fetch_assoc();
            }
            else
            {
                $rows=0;
            }
            return $rows;
        }

        public function command($sql)
        {
            $this->connect();
            $this->conn->query($sql);
        }
    }
?>
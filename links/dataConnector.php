<?php

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        /**
         * Data Connector Class
         */
        class dataConnector{
            public $connection;

            function __construct(){
                $this->connection = new mysqli(
                    "localhost",
                    "root",
                    "",
                    "aplifydb"
                );
            }

            function select($table, $where_clause){
                $sql = "SELECT * FROM " .$table . " WHERE " . $where_clause;
                return $this->connection->query($sql);
            }
        }
        function getPrice($text){
            return str_replace("₱", "", str_replace(",", "", $text));
        }

?>

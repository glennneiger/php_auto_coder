<?php

/*
 * The MIT License
 *
 * Copyright 2019 Sujan C.Barty <Sujan@Professional Web>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

class mysql {

    function connect() {

        $mysqli = new mysqli("localhost", "root", "", "autocoders");
        return $mysqli;
    }

    function disconnect() {
        if (isset($this->database_link))
            mysql_close($this->database_link);
        else
            mysql_close();
    }

    function iquery($qry) {
        if (!isset($this->database_link))
            $this->connect();
        $temp = mysql_query($qry, $this->database_link) or die(mysql_error());
    }

    function query($qry) {
        $mysqli = $this->connect();
        $result = $mysqli->query($qry);
        if (!$mysqli->query($qry)) {
            echo ("Error in Query:: <i><u>$qry</u></i> " . $mysqli->error);
        }
        $returnArray = array();
        $i = 0;
        while ($row = $result->fetch_array(MYSQLI_BOTH))
            if ($row)
                $returnArray[$i++] = $row;
        return $returnArray;
    }

    function num_of_row($qry) {
        $mysqli = $this->connect();
        if (isset($qry)) {
            $result = $mysqli->query($qry);
            $temp = $result->num_rows;
        } else {
            $temp = null;
        }
        return $temp;
    }

    function check_exits($TableName, $condition = "1=1") {
        $mysqli = $this->connect();
        $sql = "SELECT * FROM $TableName WHERE $condition";
        if (!$mysqli->query($sql)) {
            return 0;
        } else {
            return $mysqli->query($sql)->num_rows;
        }
    }

    function get_single_field($fieldname, $TableName, $condition) {
        $mysqli = $this->connect();
        $sql = "SELECT `$fieldname` FROM `$TableName` WHERE $condition LIMIT 1";
        $result = $mysqli->query($sql);
        $value = $result->fetch_array(MYSQLI_NUM);
        return is_array($value) ? $value[0] : "";
    }

    function get_single_result($sql) {
        $mysqli = $this->connect();
        $result = $mysqli->query($sql);
        $value = $result->fetch_array(MYSQLI_NUM);
        return is_array($value) ? $value[0] : "";
    }

    function query_exc($qry, $insertid = null) {

        $mysqli = $this->connect();
        $result = $mysqli->query($qry);
        //print_r($mysqli->error);
        //echo $qry;
        if ($result) {
            if ($insertid == 1) {
                return $mysqli->insert_id;
            } else {
                return TRUE;
            }
        } else {
            return false;
        }
    }

    function update_database($sql) {
        $mysqli = $this->connect();
        $result = $mysqli->query($sql);
        if ($result) {
            return true;
        } else {
            return FALSE;
        }
    }

    function limit($page = 0, $limit = 7) {
        if ($page == 0) {
            $offset = 0;
        } else {
            $expage = $page - 1;
            $offset = $expage * $limit;
        }
        return " LIMIT $offset, $limit";
    }

    function export_table($download = 1, $tables = false, $backup_name = "DBS.csql") {
        set_time_limit(3000);
        $mysqli = $this->connect();
        $mysqli->query("SET NAMES 'utf8'");
        $queryTables = $mysqli->query('SHOW TABLES');
        while ($row = $queryTables->fetch_row()) {
            $target_tables[] = $row[0];
        } if ($tables !== false) {
            $target_tables = array_intersect($target_tables, $tables);
        }
        $content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+06:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `" . $name . "`\r\n--\r\n\r\n\r\n";
        foreach ($target_tables as $table) {
            if (empty($table)) {
                continue;
            }
            $result = $mysqli->query('SELECT * FROM `' . $table . '`');
            $fields_amount = $result->field_count;
            $rows_num = $mysqli->affected_rows;
            $res = $mysqli->query('SHOW CREATE TABLE ' . $table);
            $TableMLine = $res->fetch_row();
            $content .= "\n\n" . $TableMLine[1] . ";\n\n";
            for ($i = 0, $st_counter = 0; $i < $fields_amount; $i++, $st_counter = 0) {
                while ($row = $result->fetch_row()) { //when started (and every after 100 command cycle):
                    if ($st_counter % 100 == 0 || $st_counter == 0) {
                        $content .= "\nINSERT INTO " . $table . " VALUES";
                    }
                    $content .= "\n(";
                    for ($j = 0; $j < $fields_amount; $j++) {
                        $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));
                        if (isset($row[$j])) {
                            $content .= '"' . $row[$j] . '"';
                        } else {
                            $content .= '""';
                        } if ($j < ($fields_amount - 1)) {
                            $content .= ',';
                        }
                    } $content .= ")";
                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ((($st_counter + 1) % 100 == 0 && $st_counter != 0) || $st_counter + 1 == $rows_num) {
                        $content .= ";";
                    } else {
                        $content .= ",";
                    } $st_counter = $st_counter + 1;
                }
            } $content .= "\n\n\n";
        }
        $content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
        $backup_name = $backup_name ? $backup_name : $name . "___(" . date('d-m-Y') . "_" . date('H-i-s') . ")__rand" . rand(1, 11111111) . ".sql";
        ob_get_clean();
        $myfile = fopen("dbdata/DB_" . date('d-m-Y') . "_" . date('H-i-s') . ".sql", "w") or die("Unable to open file!");
        fwrite($myfile, $content);
        fclose($myfile);

        if ($download == FALSE) {

        } else {
            header('Content-Type: application/octet-stream');
            header("Content-Transfer-Encoding: Binary");
            header("Content-disposition: attachment; filename=\"" . $backup_name . "\"");
        }
    }

}

?>

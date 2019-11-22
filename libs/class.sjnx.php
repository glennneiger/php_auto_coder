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

require_once("class.sjnxform.php");

class sjnx extends sjnxform {

    public $appname;
    public $style;
    public $script;

    function __construct() {
        $appname = $this->appname;
        $script = $this->script;
        $style = $this->style;
    }

    function conf($varname) {
        require('confg.php');
        if (isset($conf[$varname])) {
            return $conf[$varname];
        } else {
            return false;
        }
    }

    function baseurl() {
        return $this->conf('baseurl');
    }

    function url_str($string, $mode = 0) {
        $search = array(" ", "  ", "+");
        $rplc = array("_", "~", "pppp");
        if ($mode == 0) {
            return str_replace($search, $rplc, $string);
        } else {
            return str_replace($rplc, $search, $string);
        }
    }

    function qstr($varname) {
        if (isset($_REQUEST[$varname])) {
            return $_REQUEST[$varname];
        } else {
            //index/cc=id::543::name.v.access
            foreach ($this->urltoarr() as $urlset) {
                $urlset = str_ireplace(array(":-", ":", "-", "--", "___", ".v."), ".v.", $urlset);
                $keyval = explode(".v.", $urlset);
                if ($keyval[0] == $varname) {
                    return $keyval[1];
                }
            }
        }
    }

    function includeFileContent($fileName, $data) {
        ob_start();
        if (is_array($data)) {
            extract($data);
        }
        ob_implicit_flush(false);
        include($fileName);
        return ob_get_clean();
    }

    function loadview($filename, $data) {
        if (is_array($data)) {
            $lang['null'] = "None";
            $data = array_merge($data, $lang);
            $keys = null;
            foreach (array_keys($data) as $kaename) {
                $keys .= "{" . "$kaename" . "},";
            }
            $keysearch = explode(",", rtrim($keys, ","));
            $valuetoplce = null;
            foreach (array_values($data) as $keyvalues) {
                if (is_array($keyvalues)) {
                    $valuetoplce .= "None,";
                } else {
                    $valuetoplce .= $keyvalues . ",";
                }
            }
            $valuetoplce22 = explode(",", rtrim($valuetoplce, ","));
            //style and script intrigation
            $global_search = array("{theme}", "{baseurl}", "{powredby}", "{softv}", "{ctrll}", "{appurl}", "{script}", "{style}");
            $global_paste = array(
                $this->conf('baseurl') . "/" . $this->conf('theme'),
                $this->conf('baseurl'),
                "KALNI-IT",
                $this->conf("appversion"),
                $this->appname,
                $this->conf('baseurl') . "/" . $this->appname,
                $this->script,
                $this->style
            );

            $themedata = $this->includeFileContent($this->conf('basepath') . "/" . $this->conf('theme') . "/" . $filename . ".php", $data);
            $themedata = str_ireplace($global_search, $global_paste, $themedata);

            //print_r($valuetoplce22);
            echo str_ireplace($keysearch, $valuetoplce22, $themedata);
        } else {
            echo "Error:: Data of this page cannot be initialize";
        }
    }

    function ajax_load($url, $resdivid) {
        return<<<EOT
                <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>

   <script>
    $( document ).ready(function() {
            loadurl('{$url}','{$resdivid}');

   });


    </script>
EOT;
    }

    function filtertxt($strings) {
        $search = array(
            "'",
            '"',
            "union",
            "SELECT",
            "@",
            "-",
            "*",
            "like",
            "as",
            "(",
            ")",
            "from",
            "order",
            "by"
        );
        return str_ireplace($search, "", $strings);
    }

    function rqstr($varname) {
        $search = array(
            "'",
            '"',
            "union",
            "SELECT",
            "@",
            "-",
            "*",
            "like",
            "as",
            "(",
            ")",
            "from",
            "order",
            "by"
        );
        $past = "::";
        if (isset($_GET[$varname])) {
            $string = explode("::", str_ireplace($search, $past, $_GET[$varname]));
            if (!$string[0] || $string[0] == 0) {
                header("HTTP/1.0 404 Not Found");
            }
            //print_r($string);
            $return = $string[0];
        } else {
            if (isset($_REQUEST[$varname])) {
                $return = addslashes($_REQUEST[$varname]);
            } else {
                $return = null;
            }
        }
        return $return;
    }

    function GmtTimeToLocalTime($time) {

        return $new_date->format("Y-m-d h:i:s");
    }

    function php_date_format($date, $dateonly = 0) {
        //$datetime = strtotime($date);
        date_default_timezone_set('UTC');
        $new_date = new DateTime($date);
        $new_date->setTimeZone(new DateTimeZone('Asia/kolkata'));

        if ($dateonly == 1) {
            $mysqldate = $new_date->format('d M Y');
        } else {
            $mysqldate = $new_date->format('d M Y h:i a ');
        }

        return $mysqldate;
    }

    function php_date_format2($date, $dateonly = 0, $bd = 0) {
        if (isset($_SESSION['timezone'])) {
            $timezone = $_SESSION['timezone'];
        } else {
            $timezone = 'Asia/Dhaka';
        }
        $dateee = new DateTime($date, new DateTimeZone($timezone));
//$datetime = strtotime($dateee->format('Y-m-d H:i:sP'));
        $datetime = strtotime($date);
        if ($dateonly == 1) {
            $mysqldate = date("<b>d</b>/m/<b>Y</b> ", $datetime);
        } else {
            $mysqldate = date("<b>d</b>/m/<b>Y</b>  H:i ", $datetime);
        }
        if ($bd == 1) {
            $strsrc = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
            $strrpl = array("০", "১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯");
            return str_replace($strsrc, $strrpl, $mysqldate);
        } else {
            return $mysqldate;
        }
    }

    function number_orientation($num) {
        if (!in_array(($num % 100), array(11, 12, 13))) {
            switch ($num % 10) {
                // Handle 1st, 2nd, 3rd
                case 1: return $num . '<span class="T1">st</span>';
                case 2: return $num . '<span class="T1">nd</span>';
                case 3: return $num . '<span class="T1">rd</span>';
            }
        }
        return $num . '<span class="T1">th</span>';
    }

    function number_format_tk($num) {
        return '&#36;' . number_format($num, 2) . " ";
    }

    function number_format_cr($num) {
        return number_format($num, 2);
    }

    function createDateRangeArray($strDateFrom, $strDateTo) {
        // takes two dates formatted as YYYY-MM-DD and creates an
        // inclusive array of the dates between the from and to dates.
        // could test validity of dates here but I'm already doing
        // that in the main script

        $aryRange = array();

        $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
        $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

        if ($iDateTo >= $iDateFrom) {
            array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
            while ($iDateFrom < $iDateTo) {
                $iDateFrom += 86400; // add 24 hours
                array_push($aryRange, date('Y-m-d', $iDateFrom));
            }
        }
        return $aryRange;
    }

    function stats_yn($sts) {
        if ($sts == 1) {
            return "<b><i style=\"color:green\" class=\"material-icons\">Yes</i></b>";
        } else {
            return "<b style=\"color:red\"><i class=\"material-icons\">No</i></b>";
        }
    }

    function pagination($displayrow = 30, $table, $url, $condition, $fieldName = "ID", $curentpage, $unitname = "Pages") {

        $limit = $displayrow;

        $sql = "SELECT $fieldName FROM `$table` $condition";
        $total_pages = $this->num_of_row($sql);

        $stages = 3;
        $page = $curentpage;
        if ($page) {
            $start = ($page - 1) * $limit;
        } else {
            $start = 0;
        }

        // Get page data
        $query1 = "SELECT * FROM $table LIMIT $start, $limit";
        $result = $this->query($query1);

        // Initial page num setup
        if ($page == 0) {
            $page = 1;
        }
        $prev = $page - 1;
        $next = $page + 1;
        $lastpage = ceil($total_pages / $limit);
        $LastPagem1 = $lastpage - 1;


        $paginate = '';
        if ($lastpage > 1) {




            $paginate .= "\n<ul class=\"pagination w3-pagination\">\n";
            $paginate .= "<li class=\"disabled\"><a href=\"javascript:void(0);\">$total_pages $unitname</a></li>\n";
            // Previous
            if ($page > 1) {
                $fnulr = str_replace("@pg", "$prev", $url);
                $paginate .= "<li class=\"waves-effect\"><a href='$fnulr'>previous</a></li>\n";
            } else {
                $paginate .= "<li class=\"disabled\"><a href=\"javascript:void(0);\">previous</a></li>\n";
            }



            // Pages
            if ($lastpage < 7 + ($stages * 2)) { // Not enough pages to breaking it up
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $page) {
                        $paginate .= "<li class=\"active waves-effect\"><a href=\"javascript:void(0);\">$counter</a></li>\n";
                    } else {
                        $fnulr = str_replace("@pg", "$counter", $url);
                        $paginate .= "<li class=\"waves-effect\"><a href='$fnulr'>$counter</a></li>\n";
                    }
                }
            } elseif ($lastpage > 5 + ($stages * 2)) { // Enough pages to hide a few?
                // Beginning only hide later pages
                if ($page < 1 + ($stages * 2)) {
                    for ($counter = 1; $counter < 4 + ($stages * 2); $counter++) {
                        if ($counter == $page) {
                            $paginate .= "<li class=\"active\"><a href=\"javascript:void(0);\">$counter</a></li>\n";
                        } else {
                            $fnulr = str_replace("@pg", "$counter", $url);
                            $paginate .= "<li class=\"waves-effect\"><a href='$fnulr'>$counter</a></li>\n";
                        }
                    }
                    $paginate .= "<li><a href=\"javascript:void(0);\">...</li>";
                    $fnulrlast = str_replace("@pg", "$LastPagem1", $url);
                    $fnulrlastpage = str_replace("@pg", "$lastpage", $url);
                    $paginate .= "<li class=\"waves-effect\"><a href='$fnulrlast'>$LastPagem1</a></li>\n";
                    $paginate .= "<li class=\"waves-effect\"><a href='$fnulrlastpage'>$lastpage</a></li>\n";
                }
                // Middle hide some front and some back
                elseif ($lastpage - ($stages * 2) > $page && $page > ($stages * 2)) {
                    $fnulr = str_replace("@pg", "1", $url);
                    $fnulr2 = str_replace("@pg", "2", $url);
                    $paginate .= "<li class=\"waves-effect\"><a href='$fnulr'>1</a></li>\n";
                    $paginate .= "<li class=\"waves-effect\"><a href='$fnulr2'>2</a></li>\n";
                    $paginate .= "<li class=\"waves-effect\"><a href=\"javascript:void(0);\">...</a></li>";
                    for ($counter = $page - $stages; $counter <= $page + $stages; $counter++) {
                        if ($counter == $page) {
                            $paginate .= "<li class=\"active\"><a href=\"javascript:void(0);\">$counter</a></li>\n";
                        } else {
                            $fnulr = str_replace("@pg", "$counter", $url);
                            $paginate .= "<li class=\"waves-effect\"><a href='$fnulr'>$counter</a></li>\n";
                        }
                    }
                    $paginate .= "<li><a href=\"javascript:void(0);\">...</a></li>";
                    $fnulrlast = str_replace("@pg", "$LastPagem1", $url);
                    $fnulrlastpage = str_replace("@pg", "$lastpage", $url);
                    $paginate .= "<li class=\"waves-effect\"><a href='$fnulrlast'>$LastPagem1</a></li>\n";
                    $paginate .= "<li class=\"waves-effect\"><a href='$fnulrlastpage'>$lastpage</a></li>\n";
                }
                // End only hide early pages
                else {
                    $fnulr = str_replace("@pg", "1", $url);
                    $fnulr2 = str_replace("@pg", "2", $url);
                    $paginate .= "<li><a href='$fnulr'>1</a></li>\n";
                    $paginate .= "<li><a href='$fnulr2'>2</a></li>\n";
                    $paginate .= "<li><a href=\"javascript:void(0);\">...</a></li>";
                    for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page) {
                            $paginate .= "<li class=\"active\"><a href=\"javascript:void(0);\">$counter</a></li>\n";
                        } else {
                            $fnulr = str_replace("@pg", "$counter", $url);
                            $paginate .= "<li><a href='$fnulr'>$counter</a></li>\n";
                        }
                    }
                }
            }

            // Next
            if ($page < $counter - 1) {
                $fnulr = str_replace("@pg", "$next", $url);
                $paginate .= "<li><a href='$fnulr'>next</a></li>\n";
            } else {
                $paginate .= "<li class='disabled'><a href=\"javascript:void(0);\">next</a></li>\n";
            }

            $paginate .= "</ul>";
        }
        // pagination
        $return = $paginate;
//===========================================================================



        return $return;
    }

    function checkPassword($pwd) {
        $errors = null;

        if (strlen($pwd) < 8) {
            $errors .= "Password too short!<br>";
        }

        if (!preg_match("#[0-9]+#", $pwd)) {
            $errors .= "Password must include at least one number!<br>";
        }

        if (!preg_match("#[a-zA-Z]+#", $pwd)) {
            $errors .= "Password must include at least one letter!<br>";
        }

        return $errors;
    }

    function html2text($Document) {
        $Rules = array('@<script[^>]*?>.*?</script>@si',
            '@<[\/\!]*?[^<>]*?>@si',
            '@([\r\n])[\s]+@',
            '@&(quot|#34);@i',
            '@&(amp|#38);@i',
            '@&(lt|#60);@i',
            '@&(gt|#62);@i',
            '@&(nbsp|#160);@i',
            '@&(iexcl|#161);@i',
            '@&(cent|#162);@i',
            '@&(pound|#163);@i',
            '@&(copy|#169);@i',
            '@&(reg|#174);@i'
        );
        $Replace = array('',
            '',
            '',
            '',
            '&',
            '<',
            '>',
            ' ',
            chr(161),
            chr(162),
            chr(163),
            chr(169),
            chr(174)
        );
        return preg_replace($Rules, $Replace, $Document);
    }

    function moneyformat($total) {
        if (!$total || $total == 0) {
            return null;
        } else {
            $totall = (float) $total;
            setlocale(LC_MONETARY, "en_US");
            return "$" . number_format($totall, 2, '.', ' ') . " USD";
        }
    }

    function error($messg) {
        return<<<EOT
   <div class="w3-padding w3-border w3-border-red w3-pale-red w3-text-red w3-xlarge w3-card">{$messg}</div>

EOT;
    }

    function add_transection($cr_from, $cr_to, $amount, $descr, $type) {
        $rcid = $this->query_exc("INSERT INTO  `credit_transfer_record` (`Descriptions`)VALUES('{$descr}');", 1);
        $sqll = "INSERT INTO `credit_transection`(`user_ID`, `credit_amount`, `desctiption`, `tr_type`, `trans_date_time`, `rcid`) "
                . "VALUES ('{$cr_from}','-{$amount}','{$descr}','{$type}',NOW(),'{$rcid}')";
        $sqll2 = "INSERT INTO `credit_transection`(`user_ID`, `credit_amount`, `desctiption`, `tr_type`, `trans_date_time`, `rcid`) "
                . "VALUES ('{$cr_to}','{$amount}','{$descr}','{$type}',NOW(),'{$rcid}')";

        $this->query_exc($sqll);
        return $this->query_exc($sqll2);
    }

    function add_notice($userid, $msg) {
        $sal = "INSERT INTO `notice`(`ID`, `userid`, `msg`, `readed`, `datetimes`) VALUES (NULL,'{$userid}','{$msg}',0,NOW())";
        $this->query_exc($sal);
    }

    function sendsms($mobile_no, $smstext) {
        $jsonData = array(
            'from' => '8804445653642',
            'to' => "$mobile_no",
            'text' => "$smstext"
        );
        $data_string = json_encode($jsonData);

        $ch = curl_init('http://107.20.199.106/restapi/sms/1/text/single');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Host: 107.20.199.106',
            'Authorization: Basic YmFhaWdtOTg0OlJ1cGFsaTAjMEJE==',
            'Content-Type: application/json',
            'Accept: application/json',
            'Content-Length: ' . strlen($data_string))
        );

        $js = json_decode(curl_exec($ch));
        $sms_status = $js->messages[0]->{'messageId'};

        if ($sms_status) {
            $insertsql = "INSERT INTO  `notice_sms` (
          `ID`,
          `to_number`,
          `contents`,
          `sent`,`messageID`)VALUES('',
          '{$mobile_no}',
          '{$smstext}',
          '1','{$sms_status}');";
        } else {
            $insertsql = "INSERT INTO  `notice_sms` (
          `ID`,
          `to_number`,
          `contents`,
          `sent`)VALUES('',
          '{$mobile_no}',
          '{$smstext}',
          '0');";
        }

        $this->query_exc($insertsql);
    }

    function addmsg($to, $msg) {

        $this->query_exc("INSERT INTO `message`( `userid`, `to_userid`, `message`, `msgtime`) "
                . "VALUES "
                . "('{$_SESSION['userid']}',$to,'{$msg}',NOW())");
    }

    function getUserIpAddr() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    function ipquery() {

        /* /
          $querystring = $this->get_single_result("SELECT `Querystring` FROM `iptocountry` WHERE `IPADDR`='{$this->getUserIpAddr()}'");
          if ($querystring) {
          $ipcc = json_decode($querystring, true);
          } else {
          $ipc = file_get_contents("http://ip-api.com/json/{$this->getUserIpAddr()}?fields=country,countryCode,region,regionName,city,zip,mobile,proxy");
          $this->query_exc("INSERT INTO `iptocountry`(`IPADDR`, `Querystring`) VALUES ('{$this->getUserIpAddr()}','{$ipc}')");
          $ipcc = json_decode($ipc, true);
          }

          return $ipcc; */
    }

    function get_user_dtl($userid, $filds = "*") {
        foreach ($this->query("SELECT {$filds} FROM `l_user` WHERE `ID`={$userid}") as $value) {
            return $value;
        }
    }

    function dcdurl($str, $dev = 1) {
        if ($dev == 1) {
            return $str;
        } else {
            return base64_decode(str_rot13($str));
        }
    }

    function urlval($varnum) {
        $urlset = $this->urltoarr();
        if (isset($urlset[$varnum])) {
            return $urlset[$varnum];
        } else {
            return 0;
        }
    }

    function urltoarr() {
        if (isset($_SERVER['REQUEST_URI'])) {
            $urlstr = str_ireplace("/", "::", $this->dcdurl(str_replace(array($this->conf('appdir'), $this->conf('appdir') . "/"), "/", $_SERVER['REQUEST_URI'])));
            $return = explode("::", $urlstr);
        } else {
            $return[0] = "defctrl";
        }
        return $return;
    }

    function logedin() {
        if (isset($_SESSION["UsrID"]) && isset($_SESSION["UsrName"]) && isset($_SESSION["UsrMail"]) && isset($_SESSION["UsrRole"])) {
            return true;
        } else {
            return false;
        }
    }

    function breadcumb($breditems) {
        $ret = "";
        foreach ($breditems as $key => $value) {
            $ret .= "<a href=\"{$key}\">{$value}</a> &#8649; ";
        }

        $ret2 = trim($ret, "&#8649; ");
        return $ret2;
    }

    function encode_urlsrting($string) {
        return str_replace(array(" "), array("_"), $string);
    }

}

?>
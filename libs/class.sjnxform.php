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


require_once("class.database.php");

class sjnxform extends mysql {

    function jq_post_form($submitbtnID, $formID, $URL, $viewurl, $resdivID = null, $alert = 0) {
        $return = null;
        if ($alert == 1) {
            $alertcd = "alert('Action Successfully Performed');";
        } else {
            $alertcd = null;
        }

        $return .= "<script type='text/javascript'>\n";
        $return .= <<<EOT

$("#{$submitbtnID}").click(function() {
    var url = "$URL";

    $.ajax({
           type: "POST",
           url: url,
           data: $("#{$formID}").serialize(), // serializes the form's elements.
           success: function(data)
           {
               if(data==1)
               {
               $alertcd
               loadurl('$viewurl','$resdivID');
               }else{
               	$("#sysmsg").html(data);
               	$("#sysmsg").show();
               }
           }
         });
	$("#sysmsg").html("<img src='http://i.imgur.com/RWxluph.gif' alt='Loading......'>");
	$("#sysmsg").show();
	request.done(function( html ) { $("#"+divid).html(html);$("#sysmsg").hide();});
    return false; // avoid to execute the actual submit of the form.
});


EOT;
        $return .= "</script>";
        return $return;
    }

    function jq_post_form2($submitbtnID, $formID, $URL, $loadurlofdata, $resdivID = null) {

        $return = <<<EOT

	var url = "$URL";

    $.ajax({
           type: "POST",
           url: url,
           data: $("#{$formID}").serialize(),
           success: function(data)
           {
               alert(data); // show response from the php script.
               loadurl("$loadurlofdata","$resdivID");
           }
         });

    return false;


EOT;
        return $return;
    }

    function select_fdb($name, $value, $text, $tablename, $defalt = null, $widdth = 300, $extra = null, $xoptiontext = null, $xoptionval = null) {
        $mysqli = $this->connect();
        $sql = "SELECT $value, $text FROM $tablename $extra";
//$sql2="SELECT $value, $text FROM $tablename WHERE `$value`='$defalt' $extra";
//Define SQL Query is Double For make Eassily
        $return = "
<select name=\"$name\" style=\"width:{$widdth}px\" id=\"{$name}\" class=\"w3-select w3-border\"> \n";
        if ($xoptiontext) {
            $return .= "<option value=\"$xoptionval\">$xoptiontext</option> \n";
        }

        $query = $mysqli->query($sql);
        $num = $query->num_rows;

        $i = 0;
        while ($i < $num) {
            $value = $query->fetch_array(MYSQLI_NUM);
            $ID = is_array($value) ? $value[0] : "";
            $Nname = is_array($value) ? $value[1] : "";

            if ($ID == $defalt) {
                $return .= "<option value=\"$ID\" selected>$Nname</option> \n";
            } else {
                $return .= "<option value=\"$ID\">$Nname</option> \n";
            }
            $i++;
        }
        $return .= "</select>";

        return $return;
    }

    function select_db_input($ID, $value, $text, $tablename, $action, $defalt = "1", $widdth = 200, $extra = null, $xoptiontext = null) {

        $sql = "SELECT $value, $text FROM $tablename  $extra";
//Define SQL Query is Double For make Eassily
        $return = "<select $action name=\"$ID\" class=\"w3-select  w3-border\"> \n";
        if ($xoptiontext) {
            $return .= "<option style=\"cursor:pointer;\" value=\"0\">$xoptiontext</option> \n";
        }

        foreach ($this->query($sql) as $valuee) {
            $ID = $valuee[$value];
            $Nname = $valuee[$text];
            //$actiond=str_replace("this.value","$ID",$action);
            if ($ID == $defalt) {
                $return .= "<option style=\"background-color:#008AB8;color:#99D6EB\" value=\"$ID\" selected>-$Nname</option> \n";
            } else {
                $return .= "<option value=\"$ID\" >-$Nname</option> \n";
            }
        }
        $return .= "</select>";

        return $return;
    }

    function select_nrml($name, $optionval, $defval, $app = null, $validmethod = null) {
        $ret = "<select name=\"$name\" id=\"$name\">";
        foreach (explode(",", $optionval) as $ddvalue) {
            $valueofv = explode(":", $ddvalue);
            if ($valueofv[0] == $defval) {
                $ret .= "<option value=\"{$valueofv[0]}\" selected>{$valueofv[1]}</option>";
            } else {
                $ret .= "<option value=\"{$valueofv[0]}\">{$valueofv[1]}</option>";
            }
        }

        $ret .= "</select>";

        return $ret;
    }

    function select_normal($name, $texarr, $defval = null, $app = null, $validmethod = null) {
        $return = "
<select name=\"$name\" id=\"{$name}\" class=\"w3-select w3-border\">
";

        foreach ($texarr as $key => $value) {
            if ($defval == $value) {
                $return .= "<option value=\"$value\" selected>$key</option>\n";
            } else {
                $return .= "<option value=\"$value\">$key</option>\n";
            }
        }

        $return .= "</select><br>";
        return $return;
    }

    function input_yn($name, $def = 1, $comment = "", $app = null, $validmethod) {
        $validaction = "loadurl('?act={$validmethod}&r={$name}&val='+this.value,'{$name}_msg')";
        $return = "
<select name=\"$name\" class=\"w3-input w3-border\" onchange=\"{$validaction}\">
";

        if ($def == 1) {
            $return .= "<option value=\"1\" selected>Yes $comment</option>\n";
            $return .= "<option value=\"0\">No $comment</option>\n";
        } else {
            $return .= "<option value=\"1\">Yes $comment</option>\n";
            $return .= "<option value=\"0\" selected>No $comment</option>\n";
        }


        $return .= "</select><br><span id=\"{$name}_msg\"></span>";
        return $return;
    }

    function input_date($form_name, $defalt_date = null, $defalt_time = "00:00:00") {
        if ($defalt_date == null) {
            $sql = "SELECT DATE_FORMAT(NOW(), '%d') AS date,
			 DATE_FORMAT(NOW(), '%m') AS month,
			 DATE_FORMAT(NOW(), '%M') AS monthval,
			 DATE_FORMAT(NOW(), '%Y') AS Year";
        } else {
            $sql = "SELECT DATE_FORMAT('$defalt_date $defalt_time', '%d') AS date,
			 DATE_FORMAT('$defalt_date $defalt_time', '%m') AS month,
			 DATE_FORMAT('$defalt_date $defalt_time', '%M') AS monthval,
			 DATE_FORMAT('$defalt_date $defalt_time', '%Y') AS Year";
        }
        $return = '';

        foreach ($this->query($sql) as $datetimeflek) {
            $date = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14",
                "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31");
//////////////////////////////////////////////////////////////////
            $return .= <<<EOT
<select name="{$form_name}_date">
<option value="{$datetimeflek['date']}">{$datetimeflek['date']}</option>
EOT;
            foreach ($date as $dateval) {
                //if($dateval == $datetimeflek['date'])continue;
                $return .= "<option value=\"$dateval\">$dateval</option>
";
            }
            $return .= "</select>";
///////////////////////////////////////////////////
            $return .= <<<EOT
<select name="{$form_name}_month">
<option value="{$datetimeflek['month']}">{$datetimeflek['monthval']}</option>
<Option value="01">January</Option>
<Option value="02">February</Option>
<Option value="03">March</Option>
<Option value="04">April</Option>
<Option value="05">May</Option>
<Option value="06">June</Option>
<Option value="07">July</Option>
<Option value="08">August</Option>
<Option value="09">September</Option>
<Option value="10">October</Option>
<Option value="11">November</Option>
<Option value="12">December</Option>
EOT;
            $return .= "</select>";
///////////////////////////////////////////////////////
            $return .= <<<EOT
<input type="text" name="{$form_name}_year" maxlength="4" size="5" value="{$datetimeflek['Year']}"><br>
EOT;

            return $return;
        }
    }

    function textarea($name, $value = null, $height = 150, $app = null, $validmethod = null) {
        $validaction = "loadurl('?act={$validmethod}&r={$name}&val='+this.value,'{$name}_msg')";
        return"\n<textarea name=\"$name\" id=\"$name\" class=\"w3-input w3-border\" style=\"height:{$height}px;\"onchange=\"{$validaction}\">{$value}</textarea>\n <span id=\"{$name}_msg\"></span><br>\n";
    }

    function richtext($textareaid, $value = null, $height, $app = null, $validmethod, $savebtn = "savebtn") {
        $validaction = "loadurl('?ajx=1&opt={$validmethod}&app={$app}&r={$textareaid}&val='+this.value,'{$textareaid}_msg');";
        $return = "<textarea id=\"{$textareaid}_t\" class=\"w3-input w3-border\" name=\"{$textareaid}\">$value</textarea>";
        $return .= <<<EOT
                                   <span id="{$textareaid}_msg"></span><br>
                                   <script src="{$this->conf('themepath')}/ck4/ckeditor.js"></script>
                                    <script type="text/javascript">

                                    CKEDITOR.replace( '{$textareaid}_t',
                                        {
                                            language: 'bn',
                                            uiColor: '#bdc3c7',
                                            height:150,
                                        });
                                            CKEDITOR.instances.{$textareaid}_t.on('blur', function() {
                                            {$validaction}
                                            });
                                         function CKupdate(){
                                        for ( instance in CKEDITOR.instances )
                                            CKEDITOR.instances[instance].updateElement();
                                            }
                                       $( "#{$savebtn}" ).click(function() {
                                        CKupdate();
                                        });$( "#{$savebtn}" ).click(function() {
                                        CKupdate();
                                        });
                                       $( "#{$textareaid}_t" ).change(function() {
                                        CKupdate();
                                        {$validaction}
                                        });
                            </script>

EOT;
        return $return;
    }

    function get_Date($form_name) {
        if (isset($_POST["{$form_name}_date"])) {
            $date = $_POST["{$form_name}_date"];
            $month = $_POST["{$form_name}_month"];
            $year = $_POST["{$form_name}_year"];
            return "$year-$month-$date";
        } else {
            return null;
        }
    }

    function input($type = "text", $name, $app = null, $validmethod, $value = null) {
        if ($value) {
            $valuedata = " value=\"{$value}\" ";
        } else {
            $valuedata = null;
        }
        $validaction = "loadurl('?act={$validmethod}&r={$name}&val='+this.value,'{$name}_msg')";
        $return = <<<EOTT
          <input type="{$type}" name="{$name}" {$valuedata} class="w3-input w3-border" onchange="$validaction">
          <span id="{$name}_msg"></span><br>
EOTT;
        return $return;
    }

    function w3_grid_start($classname = null) {
        return "<div class=\"w3-row-padding {$classname}\">\n";
    }

    function w3_grid_end() {
        return "\n</div>";
    }

    function w3_row($row_size, $content) {
        return <<<EOT
     <div class="w3-col $row_size">
             {$content}
     </div>

EOT;
    }

    function w3_field($title, $row_class = "s12 m6 l6", $content, $required = true) {
        $title = ucwords(str_replace("_", " ", $title));
        if ($required) {
            $requiredtxt = " <strong class=\"w3-text-red\">*</strong> <strong>{$title}</strong>  <i class=\"w3-tooltip w3-grey\">?<span class=\"w3-text w3-tag\"><b>This field is required!</b></span></i>";
        } else {
            $requiredtxt = "<strong>{$title}</strong> ";
        }
        $return = <<<EOTT
          <div class="input-field w3-col {$row_class} w3-text-blue">
          <label>{$requiredtxt}</label><br>
            {$content}
            <br>
          </div>
EOTT;
        return $return;
    }

    function w3_btn($val = "Save", $class = "w3-pink", $action = null, $url = null) {
        if ($action) {
            $actionmode = "href=\"javascript:void(0);\" onclick=\"{$action}\" ";
        } else {
            $actionmode = "href=\"{$url}\" ";
        }
        return "<a class=\"w3-btn {$class}\" {$actionmode}>$val</a>";
    }

    function w3_idbtn($val = "Save", $btnid = "thissubmit", $class = "w3-pink") {

        return "<a class=\"w3-btn {$class}\" id=\"{$btnid}\">$val</a>";
    }

}

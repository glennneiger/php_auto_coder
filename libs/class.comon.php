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

require_once 'class.sjnx.php';

class common extends sjnx {

    function random_anim() {
        $anim = array("fade", "fade-up", "fade-down", "fade-left", "fade-right", "fade-up-right", "fade-up-left", "fade-down-right", "fade-down-left", "zoom-in",
            "fade-up", "fade-up", "zoom-in-up", "zoom-in-down", "zoom-in-left", "zoom-in-right", "zoom-out", "zoom-out-up", "zoom-out-down"
            , "zoom-out-left", "zoom-out-right", "flip-up", "flip-down", "flip-left", "flip-right", "slide-up", "slide-down", "slide-left", "slide-right");
        return $anim[mt_rand(0, count($anim) - 1)];
    }

}

/*
$common = new common();

session_start();
if (!$_SESSION['userid']) {
    header('Location: login.php');
    exit();
}
if ($common->get_single_result("SELECT `active` FROM `l_user` WHERE `ID`={$_SESSION['userid']}") == "0") {
    echo $common->get_single_result("SELECT `descrp` FROM `l_user_block_desc` WHERE `userID`={$_SESSION['userid']} ORDER BY ID DESC");
    echo "<b style='font-size:16px;' class='w3-text-red'>If you have any question; Please contact to : <u>admin@inves2r.com</u></b>";
    exit();
}
$ipcc = $common->ipquery();
if ($ipcc['proxy']) {
    exit("Error to loading this application");
}
*/
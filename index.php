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


error_reporting(E_ALL);
ini_set('display_errors', 'on');
ini_set('short_open_tag', 'on');
require_once 'libs/class.comon.php';
require_once 'vendor/autoload.php';
session_start();
$sjnx = new common();
$urlset = $sjnx->urltoarr();
//print_r($urlset);
if (isset($_GET['app'])) {
    $controllername = $_GET['app'];
} else {
    if (isset($urlset[1]) && strlen($urlset[1]) > 3) {
        $controllername = $sjnx->filtertxt($urlset[1]);
    } else {
        $controllername = "indexpage";
    }
}
if (is_file($controllername . ".php")) {
    require_once($controllername . ".php");
    $sjnxff = new $controllername();
} else {
    require_once("indexpage.php");
    $sjnxff = new indexpage();
}

if ($sjnxff->adminarea == 1 && !$sjnx->logedin()) {
    require_once("login.php");
    exit();
} else {
    if (isset($_GET['opt']) && method_exists($sjnxff, $_GET['opt'])) {
        $fx = $urlset['opt'];
        $sjnxff->$fx();
    } elseif (isset($urlset[1]) && strlen($urlset[1]) > 3 && method_exists($sjnxff, $urlset[1])) {
        $fx = $urlset[1];
        $sjnxff->$fx();
    } elseif (isset($urlset[2]) && strlen($urlset[2]) > 3 && method_exists($sjnxff, $urlset[2])) {
        $fx = $urlset[2];
        $sjnxff->$fx();
    } else {

        $sjnxff->index();
    }
}

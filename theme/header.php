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
?>
<!DOCTYPE html>
<html>
    <title>{title}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="{title}">
    <meta name="description" content="{metadesc}">
    <meta http-equiv="language" content="en">
    <meta property="og:title" content="{title}" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="{metadesc}" />
    <meta property="og:url" content="https://kalni.net" />
    <meta property="og:image" content="https://i.imgur.com/xAVSEMH.png" />
    <link rel="stylesheet" href="{baseurl}/theme/css/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue.css">
    <link href="https://fonts.googleapis.com/css?family=Acme|Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{baseurl}/theme/css/materialize.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="{baseurl}/theme/css/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{baseurl}/theme/jqui/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        $(function () {
            $("#tabs").tabs({
                beforeLoad: function (event, ui) {
                    ui.jqXHR.fail(function () {
                        ui.panel.html(
                                "Couldn't load this tab. We'll try to fix this as soon as possible. " +
                                "If this wouldn't be a demo.");
                    });
                }
            });
        });
    </script>        <script>
        /* var source = new EventSource("event_stream.php?act=credit");
         source.onmessage = function (event) {
         document.getElementById("creditinfo").innerHTML = event.data;
         };*/
        function loadurl(url, divid)
        {
            $(document).ready(function () {
                var request = $.ajax({
                    url: url,
                    cache: true
                });
                $('.loader').show();
                $('#toastmsg').show();
                setTimeout(function () {
                    $(".loader").fadeOut("slow");
                }, 15000);
                request.done(function (html) {
                    $("#" + divid).html(html);
                    $("#toastmsg").html("<div class='w3-tag w3-round w3-green' style='padding:3px'><div class='w3-tag w3-round w3-green w3-border w3-border-white'>Processed</div></div>");
                    $("#modelmsg").html(" ");
                    $('.loader').hide();
                });
                setTimeout(function () {
                    $("#toastmsg").fadeOut("slow");
                }, 3000);



            });
        }
    </script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-11655513-4"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-11655513-4');
    </script>

</head>
<body>

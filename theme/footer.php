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
</div>
<div class="w3-dark-gray w3-margin-top">
    <div class="container">

        <div class="w3-row">
            <div class="w3-col s12 m3 l3 w3-center">
                <img src="{theme}/img/logo.png" style="height: 50px;">
            </div>
            <div class="w3-col s12 m3 l6 w3-padding w3-center w3-large">
                <strong><i class="fa fa-phone"></i> 8801708513203,</strong>
                &nbsp;&nbsp;
                <a href="mailto:info@kalni.net"><strong><i class="fa fa-inbox"></i> info@kalni.net</strong></a>
            </div>
            <div class="w3-col s12 m3 l3 w3-center">
                <a href="https://www.facebook.com/kalni.net/" target="_blank" class="w3-bar-item w3-button"><i class="fa fa-facebook-official fa-3x"></i></a>
                <a href="#" class="w3-bar-item w3-button"><i class="fa fa-twitter fa-3x"></i></a>
                <a href="https://www.linkedin.com/company/kalni-it" target="_blank" class="w3-bar-item w3-button"><i class="fa fa-linkedin fa-3x"></i></a>
            </div>
        </div>
    </div>
</div>
<script>

    document.addEventListener('DOMContentLoaded', function () {
        var elems = document.querySelectorAll('.sidenav');
        var instances = M.Sidenav.init(elems, options);
    });

    // Or with jQuery

    $(document).ready(function () {
        $('.sidenav').sidenav();
    });



</script>

<script>
    function openLeftMenu() {
        document.getElementById("leftMenu").style.display = "block";
    }

    function closeLeftMenu() {
        document.getElementById("leftMenu").style.display = "none";
    }

    function openRightMenu() {
        document.getElementById("rightMenu").style.display = "block";
    }

    function closeRightMenu() {
        document.getElementById("rightMenu").style.display = "none";
    }
</script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init();
</script>
</body>
</html>

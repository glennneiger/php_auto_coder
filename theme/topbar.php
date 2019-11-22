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

<div class="w3-black w3-right-align w3-text-white w3-padding w3-hide-small">
    <div class="container">
        <a href="https://kalni.host/clientarea.php"><i class="fa fa-sign-in" aria-hidden="true"></i> Client Login</a>
        &nbsp;&nbsp;&nbsp; <a href="#"><i class="fa fa-ticket" aria-hidden="true"></i> Open A Ticket </a>
        &nbsp;&nbsp;&nbsp; <a href="#"><i class="fa fa-comments" aria-hidden="true"></i> Live Chat</a>
        &nbsp;&nbsp;&nbsp; <a href="#"><i class="fa fa-phone-square" aria-hidden="true"></i> +880-1708-513203</a>
    </div>
</div>
<div class="w3-white w3-padding">
    <div class="container w3-row">
        <div class="w3-col s12 m2 l2">
            <button class="w3-button w3-xlarge w3-left w3-hide-large w3-hide-medium" style="padding-top: 10px;" onclick="openLeftMenu()">&#9776;</button>
            <a href="{baseurl}"><img src="https://i.imgur.com/xAVSEMH.png" class="w3-image" style="max-height: 40px;"></a>
        </div>
        <div class="w3-col m10 l10 w3-hide-small w3-right-align w3-large w3-text-blue" style="font-weight: bold;">

            <div class="w3-dropdown-hover">
                <button class="w3-button">Service</button>
                <div class="w3-dropdown-content w3-bar-block w3-border w3-medium" style="right:0">
                    <a href="../website_development_company_in_bangladesh" class="w3-bar-item w3-button">Web Design and Development</a>
                    <a href="#" class="w3-bar-item w3-button">Software Development</a>
                    <a href="#" class="w3-bar-item w3-button">E-commerce Development</a>
                    <a href="../Services_of_Kalni_IT" class="w3-bar-item w3-button">All Services</a>
                </div>
            </div>
            <div class="w3-dropdown-hover">
                <button class="w3-button">Domain</button>
                <div class="w3-dropdown-content w3-bar-block w3-border w3-medium" style="right:0">
                    <a href="#" class="w3-bar-item w3-button">Link 2</a>
                    <a href="#" class="w3-bar-item w3-button">Link 3</a>
                </div>
            </div>

            <div class="w3-dropdown-hover">
                <button class="w3-button">Hosting</button>
                <div class="w3-dropdown-content w3-bar-block w3-border w3-medium" style="right:0">
                    <a href="../products/5" class="w3-bar-item w3-button">SSD Shared Hosting</a>
                    <a href="../products/2" class="w3-bar-item w3-button">Business Hosting</a>
                    <a href="../products/4" class="w3-bar-item w3-button">SSD Cloud VPS</a>
                </div>
            </div>


            <div class="w3-dropdown-hover">
                <button class="w3-button">Company</button>
                <div class="w3-dropdown-content w3-bar-block w3-border w3-medium" style="right:0">
                    <a href="#" class="w3-bar-item w3-button">Company Profile</a>
                    <a href="#" class="w3-bar-item w3-button">Contact Us</a>
                    <a href="#" class="w3-bar-item w3-button">Data Center</a>
                    <a href="#" class="w3-bar-item w3-button">Our Customers</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none;top:0px;color:#fff !important; background-color:#333333 !important" id="leftMenu">
    <button onclick="closeLeftMenu()" class="w3-bar-item w3-btn w3-large w3-red">Close &times;</button>
    <a href="#" class="w3-bar-item w3-button">Web Design and Development</a>
    <a href="#" class="w3-bar-item w3-button">Software Development</a>
    <a href="#" class="w3-bar-item w3-button">E-commerce Development</a><hr>
    <a href="#" class="w3-bar-item w3-button">Shared</a>
    <a href="#" class="w3-bar-item w3-button">BDIX/Bangladeshi</a>
    <a href="#" class="w3-bar-item w3-button">Business</a>
    <a href="#" class="w3-bar-item w3-button">Wordpress</a>
    <a href="#" class="w3-bar-item w3-button">Managed VPS</a>
    <a href="#" class="w3-bar-item w3-button">Un-managed VPS</a><hr>
    <a href="#" class="w3-bar-item w3-button">Company Profile</a>
    <a href="#" class="w3-bar-item w3-button">Contact Us</a>
    <a href="#" class="w3-bar-item w3-button">Data Center</a>
    <a href="#" class="w3-bar-item w3-button">Our Customers</a>
</div>
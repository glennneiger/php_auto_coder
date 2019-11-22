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

class indexpage extends common {

    private $urlset;

    function __construct() {
        parent::__construct();
        $this->appname = get_class($this);
        $this->adminarea = 0;
        $this->urlset = $this->urltoarr();
    }

    function index() {
        if (isset($this->urlset[1]) && strlen($this->urlset[1]) > 4) {

        } else {


            $data['title'] = "Kalni | Software Development Company in Bangladesh";
            $data['metadesc'] = "Kalni is the software Development Company in Bangladesh to provide customize business software, cloud application, corporate & E-commerce website and IT consulting services.";

            $this->loadview('header', $data);
            $this->loadview('topbar', $data);
            $this->loadview('top', $data);



            $this->loadview('footer', $data);
        }
    }

}

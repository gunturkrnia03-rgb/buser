<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return '
    <html>
    <head>
        <title>SafeBrowse</title>
        <style>
            body{
                font-family:Arial;
                background:#0f172a;
                color:white;
                display:flex;
                justify-content:center;
                align-items:center;
                height:100vh;
                flex-direction:column;
            }

            h1{
                font-size:60px;
                color:#38bdf8;
            }

            p{
                font-size:20px;
            }
        </style>
    </head>

    <body>
        <h1>SafeBrowse</h1>
        <p>Simulasi Literasi Digital & Anti Hoaks</p>
    </body>
    </html>
    ';
});
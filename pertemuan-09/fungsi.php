<?php
function bersihkan($str)
{
    return htmlspecialchars(trim($str));
}

function tidakkosong($str)
{
    return streln(trim($str)) > 0;
}

function formattanggal($str)
{
    return date("d M Y", strtotime($str));
}
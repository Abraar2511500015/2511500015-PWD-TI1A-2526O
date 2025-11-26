<?php
function bersihkan($str)
{
    return htmlspecialchars(trim($str));
}

function tidakkosong($str)
{
    return streln(trim($str)) > 0;
}

<php?
function redirect_ke($url)
{
    header("Location: " . $url);
    exit();
}
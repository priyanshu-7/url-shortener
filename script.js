if (window.history.replaceState)
{
    window.history.replaceState(null, null, window.location.href);
}
function checkURL(s)
{
    var regexp = /^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]+$/
    return regexp.test(s);
}
function validate()
{
    let url = document.lnkshrt.url.value;
    if(!checkURL(url))
    {
      alert("Invalid URL. Please try again.");
      return false;
    }
}
function copy()
{
    var copyText = document.getElementById("shortURL");
    copyText.select();
    document.execCommand("copy");
}

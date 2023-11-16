<script>
    var url = document.location;
    url = unescape(url);
    var page = url.substring(url.indexOf('page=')+5, url.length);
    document.write(page);
</script>
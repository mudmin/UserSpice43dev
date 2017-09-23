<?php
// Token errors are generally caused by 1 of 2 things.
// 1. Someone trying to perform a man-in-the-middle attack on a form on the site.
// 2. Something accidentally causing the page to partially reload
//
// You can decide what you want for that error message here.
 ?>
<style>
body {
    background-color: white;
}
</style>
<?php
echo "<br><br><p align='center'>Token error. Please click refresh. If this continues to happen, please contact the administrator.</p>";
die();

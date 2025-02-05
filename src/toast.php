<?php
if (isset($_GET["toast"])) {
    echo "<div id=\"toast\" class=\"toast\">";
    echo $_GET["toast"];
    echo "</div>";
    echo "<script>
        const toast = document.getElementById(\"toast\");
        setTimeout(() => {
            toast.style.opacity = \"0\";
        }, 3000);
    </script>";
}
?>

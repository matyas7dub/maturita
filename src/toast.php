<?php
if (isset($_GET["toast"])) {
    $class = isset($_GET["toastType"]) ? "toast " . $_GET["toastType"] : "toast";
    echo "<div id=\"toast\" class=\"$class\">";
    echo $_GET["toast"];
    echo "</div>";
    echo "<script>
        const toast = document.getElementById(\"toast\");
        setTimeout(() => {
            toast.style.opacity = \"0\";
            const queryParams = new URLSearchParams(window.location.search);
            queryParams.delete(\"toast\");
            queryParams.delete(\"toastType\");
            window.history.replaceState(
                null,
                \"\",
                \"?\" + queryParams.toString()
            );
        }, 3000);
    </script>";
}
?>

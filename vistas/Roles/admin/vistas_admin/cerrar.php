<?php
session_unset();
session_destroy();

// Redirigir después de destruir la sesión
header("Location:".URL);
exit();
?>
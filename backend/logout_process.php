<?php
session_start();
session_unset();
session_destroy();

// Redirect ke React frontend (misal: http://localhost:3000 atau domain Anda)
header("Location: http://localhost:5173");
exit();

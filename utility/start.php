<?php
    require_once "htmllib.php";

    $autoload = function(string $class) {
        $fileName = "./" . str_replace("\\", "/", $class) . ".php";

        if (!is_readable($fileName)) {
            return false;
        }

        require_once $fileName;

        return true;
    };

    spl_autoload_register($autoload);

    startSession();
?>

<?php

    use dispatcher\Dispatcher;

require_once "utility/start.php";


    $dispatcher = Dispatcher::getInstance();
    $dispatcher->dispatch();

?>

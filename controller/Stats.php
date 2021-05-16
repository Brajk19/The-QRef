<?php

    namespace controller;

    class Stats {
        public function viewStats(): void{
            $s = new \view\Stats();
            $s->generateHTML();
        }
    }

?>
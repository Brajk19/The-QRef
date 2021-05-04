<?php

    namespace controller;


    class MainPage {
        public function __construct() {}

        public function showMainPage(): void{
            $mp = new \view\MainPage();
            $mp->generateHTML();
        }

        public function showSettings(): void{
            //TODO
        }
    }

?>
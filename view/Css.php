<?php

    namespace view;


    class Css {
        public static function printHTML(): void{
            addTagClass("*", ["font-family" => "Nanum Pen Script"]);

            addCustomClass("gridHeader", ["display" => "grid", "grid-template-columns" => "50% 20% 20% 10%",
                    "grid-template-rows" => "90px", "align-items" => "center", "padding" => "15px"]);
            addCustomClass("headerIcon:hover", ["height" => "80px"]);

            addCustomClass("headerBorder", ["border" => "solid black", "border-width" => "3px 4px 3px 5px",
                    "border-radius" => "2% 98% 2% 98% / 90% 15% 85% 10%"]);

            addCustomClass("fullName", ["margin-bottom" => "auto", "margin-top" => "auto", "font-size" => "33px"]);

            addCustomClass("barGrid", ["display" => "grid", "grid-template-columns" => "25% 25% 25% 25%",
                "padding" => "10px", "align-items" => "center", "height" => "60px", "justify-items" => "center"]);
            addCustomClass("barBorder", ["border" => "solid black", "border-width" => "2px 3px 2px 4px",
                "border-radius" => "98% 2% 99% 1% / 5% 92% 8% 95%"]);
            addCustomClass("bar", ["height" => "45px"]);
            addCustomClass("bar:hover", ["height" => "55px"]);

            addCustomClass("settingsGrid", ["display" => "grid", "grid-template-columns" => "50% 50%",
                "font-size" => "30px"]);

            addCustomClass("cell", ["padding-left" => "20px", "padding-right" => "20px", "border" => "2px solid black"]);

            addCustomClass("changePassword", ["text-align" => "center"]);
            addCustomClass("changePassword:hover", ["background-color" => "lightgreen"]);

            addCustomClass("changePasswordForm", ["font-size" => "25px"]);

            addCustomClass("createQuiz", ["display" => "grid", "grid-template-columns" => "50% auto auto",
                "font-size" => "20px"]);
            addCustomClass("quizCreateError", ["text-align" => "center", "font-size" => "25px", "color" => "red"]);
            addCustomClass("quizCreateSuccess", ["text-align" => "center", "font-size" => "25px", "color" => "lightgreen"]);
        }
    }

?>
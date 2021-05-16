<?php
    namespace utility;

    class Resource {

        /**
         * @return string
         * Returns HTML code for all avatars available
         */
        public static function getAvatarsHTML(): string {
            $html = create_element("p", true, ["contents" => "Please select avatar: ",
                "style" => "text-align:center"]);

            add_to_element($html, create_element("label", true, ["style" => "margin-right:40%"]));
            for($i = 1; $i <= 14; $i++){
                $image = "../resources/avatars/avatar$i.png";

                $imgHTML = create_element("img", true, ["src" => $image, "height" => "50px"]);

                add_to_element($html, create_element("input", true, ["type" => "radio", "name" => "avatar",
                                                                "value" => "avatar$i", "contents" => $imgHTML]));
                if($i % 4 === 0){
                    add_to_element($html, create_element("br", false, []));
                    add_to_element($html, create_element("label", true, ["style" => "margin-right:40%"]));
                }
            }

            close_element($html);

            return $html;
        }
    }

?>
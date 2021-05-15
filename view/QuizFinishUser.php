<?php

    namespace view;

    use model\Quizzes;
    use model\User;
    use router\Router;

    class QuizFinishUser extends QuizFinishTemplate{

        public function __construct(array $q, array $a, array $c) {
            parent::__construct();

            //inherited
            $this->questions = $q;
            $this->userAns = $a;
            $this->color = $c;      //true -> green, NULL -> yellow, false -> red
        }

        private function postComment(): void{
            echo create_element("p", true, ["contents" => "Leave a comment: ", "style" => "font-size:25px"]);

            start_form(Router::getInstance()->getRoute("AddComment"), "POST");
            $img = User::getAvatar($_SESSION["email"]);
            echo create_element("img", true, ["src" => "../../resources/avatars/$img.png", "height" => "75px"]);
            echo create_element("textarea", true, ["cols" => "100", "rows" => "10", "style" => "display:inline",
                "name" => "commentText"]);
            echo create_element("input", true, ["type" => "submit", "value" => "Post a comment."]);

            end_form();
        }

        private function loadComments(): void{
            $comments = Quizzes::getComments($_SESSION["quizID"]);

            create_table([]);

            foreach ($comments as $c){
                $avatar = $c["avatar"] . ".png";
                $img = create_element("img", true, ["src" => "../../resources/avatars/$avatar", "height" => "50px"]);
                $cell1 = create_table_cell(["contents" => $img]);

                $cell2 = create_table_cell(["contents" => $c["firstName"] . " " . $c["lastName"]]);
                $cell3 = create_table_cell(["contents" => $c["comment"], "style" => "padding-left:50px; font-size:20px"]);

                echo create_table_row(["contents" => [$cell1, $cell2, $cell3]]);
            }

            end_table();
        }

        protected function generateBody(): void{
            MainPageHeader::printHTML();
            $this->quizStats();

            if(Quizzes::commentsEnabled($_SESSION["quizID"])){
                $this->postComment();
                echo create_element("br", false, []);
                $this->loadComments();
            }
        }
    }

?>
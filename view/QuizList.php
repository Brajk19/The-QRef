<?php

    namespace view;

    use model\Quizzes;
    use router\Router;

    class QuizList extends MainPage {
        private ?int $selected;

        public function __construct(int $id = NULL) {
            parent::__construct();

            $this->selected = $id;
        }


        /**
         * @return string
         * Returns table containing all quizzes not made by logged in user.
         */
        private function listOtherQuizzes(): string{
            $q = Quizzes::getAllQuizzesExcept($_SESSION["email"]);

            $table = create_element("table", false, ["style" => "margin:auto"]);

            foreach ($q as $question){
                $id = $question["id"];
                $name = $question["name"];

                $link = create_element("a", true, ["href" => Router::getInstance()->getRoute("SolveQuizUser", $id),
                    "contents" => "$name", "class" => "quizName"]);
                $cell = create_table_cell(["contents" => $link, "style" => "font-size: 35px"]);
                add_to_element($table, create_table_row(["contents" => [$cell]]));
            }

            close_element($table);
            return $table;
        }

        private function getComments(int $id): string{
            $comments = Quizzes::getComments(strval($id));
            $html = "";

            foreach ($comments as $c){
                $avatar = $c["avatar"] . ".png";
                $img = create_element("img", true, ["src" => "../../resources/avatars/$avatar", "height" => "30px"]);
                $cell1 = create_table_cell(["contents" => $img]);

                $cell2 = create_table_cell(["contents" => $c["firstName"] . " " . $c["lastName"], "style" => "font-size:20px"]);
                $cell3 = create_table_cell(["contents" => $c["comment"], "style" => "padding-left:30px; font-size:15px"]);

                $html .= create_table_row(["contents" => [$cell1, $cell2, $cell3]]);
            }

            return $html;
        }

        /**
         * @param int $id
         * @param string $description
         * @return string
         * Returns HTML code for table containing description and all comments.
         */
        private function showQuizDetails(int $id, string $description): string{
            $html = create_element("table", false, ["style" => "margin-left:7%"]);

            $c1 = create_element("th", true, ["contents" => "QUIZ DESCRIPTION: $description", "colspan" => "3",
                "style" => "text-align:left; padding-bottom:10px"]);
            $c2 = create_element("td", true, ["contents" => "Comments:", "colspan" => "3",
                "style" => "text-align:left"]);

            add_to_element($html, create_table_row(["contents" => $c1]));
            add_to_element($html, create_table_row(["contents" => $c2]));
            add_to_element($html, $this->getComments($id));
            close_element($html);

            $cell = create_table_cell(["contents" => $html, "colspan" => "3"]);
            $spacing = create_table_row(["contents" => create_table_cell(["contents" => create_element("br", false, [])])]);
            return create_table_row(["contents" => $cell]) . $spacing;
        }

        private function listUserQuizzes(): string{
            $rows = "";

            $q = Quizzes::getUserQuizzes($_SESSION["email"]);

            foreach($q as $question){
                $name = $question["name"];
                $id = $question["id"];

                $a = create_element("a", true, ["href" => Router::getInstance()->getRoute("DetailedView", $id),
                    "contents" => "$name", "class" => "quizName"]);
                $cell1 = create_table_cell(["contents" => $a, "class" => "quizListCell", "style" => "border:2px solid black;font-size:35px"]);

                $link = create_element("a", true, ["href" => Router::getInstance()->getRoute("EditQuestion", $id),
                    "contents" => "Edit questions", "class" => "quizName"]);
                $cell2 = create_table_cell(["contents" => $link, "class" => "quizListCell", "style" => "border:2px solid black;border-right:0"]);

                $link2 = create_element("a", true, ["href" => Router::getInstance()->getRoute("SolveQuizUser", $id),
                    "contents" => "Play the quiz", "class" => "quizName"]);
                $cell3 = create_table_cell(["contents" => $link2, "style" => "border:2px solid black;border-left:0"]);

                $rows .= create_table_row(["contents" => [$cell1, $cell2, $cell3]]);

                if($this->selected === intval($id)){
                    $rows .= $this->showQuizDetails(intval($id), $question["description"]);
                }
            }

            return $rows;
        }

        protected function generateBody() {
            parent::generateBody();

            echo create_element("br", false, []);

            $grid = create_element("div", false, ["class" => "quizList"]);

            $div1 = create_element("div", false, []);
            add_to_element($div1, create_element("h1", true, ["contents" => "MY QUIZZES", "style" => "text-align:center"]));

            $table = create_element("table", false, ["style" => "margin:auto; font-size:30px; border-collapse:collapse"]);
            add_to_element($table, $this->listUserQuizzes());
            close_element($table);

            add_to_element($div1, $table);
            close_element($div1);


            $div2 = create_element("div", false, []);
            add_to_element($div2, create_element("h1", true, ["contents" => "PLAY OTHER QUIZZES", "style" => "text-align:center"]));
            add_to_element($div2, $this->listOtherQuizzes());
            close_element($div2);


            add_to_element($grid, $div1);
            add_to_element($grid, $div2);
            close_element($grid);

            echo $grid;
        }
    }

?>
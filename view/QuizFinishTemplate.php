<?php

    namespace view;

    abstract class QuizFinishTemplate extends PageTemplate {
        protected array $questions;
        protected array $userAns;
        protected array $color;

        private function quizStatRow(string $question, array $selected, array $correct, ?bool $color, int $points): void{
            $cell1 = create_table_cell(["contents" => $question, "class" => "cell"]);

            $cell2 = match ($color) {
                true => create_element("td", false, ["style" => "background-color:lightgreen", "class" => "cell"]),
                NULL => create_element("td", false, ["style" => "background-color:yellow", "class" => "cell"]),
                false => create_element("td", false, ["style" => "background-color:red", "class" => "cell"]),
            };

            foreach ($selected as $s){
                add_to_element($cell2, create_element("p", true, ["contents" => $s]));
            }
            close_element($cell2);

            $cell3 = create_element("td", false, ["class" => "cell"]);
            foreach ($correct as $c){
                add_to_element($cell3, create_element("p", true, ["contents" => $c]));
            }
            close_element($cell3);

            $cell4 = create_table_cell(["contents" => strval($points), "class" => "cell"]);

            echo create_table_row(["contents" => [$cell1, $cell2, $cell3, $cell4]]);
        }

        /**
         * Displays all answers user chose and whether or not they were correct
         */
        protected function quizStats(): void{
            echo create_element("br", false, []);
            echo create_element("br", false, []);
            create_table(["class" => "quizTable"]);

            $header1 = create_element("th", true, ["contents" => "Question", "class" => "cell"]);
            $header2 = create_element("th", true, ["contents" => "Selected", "class" => "cell"]);
            $header3 = create_element("th", true, ["contents" => "Correct", "class" => "cell"]);
            $header4 = create_element("th", true, ["contents" => "Points", "class" => "cell"]);
            echo create_table_row(["contents" => [$header1, $header2, $header3, $header4]]);

            $total = 0;
            for($i = 0; $i < count($this->userAns); $i++){
                $total+=$this->userAns[$i][2];
                $this->quizStatRow($this->questions[$i], $this->userAns[$i][0], $this->userAns[$i][1], $this->color[$i], $this->userAns[$i][2]);
            }
            end_table();
            echo create_element("br", false, []);

            create_table(["class" => "quizTable"]);
            $cell1 = create_table_cell(["contents" => "TOTAL POINTS", "class" => "cell"]);
            $cell2 = create_table_cell(["contents" => strval($total), "class" => "cell"]);
            echo create_table_row(["contents" => [$cell1, $cell2], "style" => "font-size:25px"]);
            end_table();
        }



        abstract protected function generateBody();
    }

?>
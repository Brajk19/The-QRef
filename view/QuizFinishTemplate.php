<?php

    namespace view;

    abstract class QuizFinishTemplate extends PageTemplate {
        protected array $questions;
        protected array $userAns;
        protected array $color;

        private function quizStatRow(string $question, array $selected, array $correct, ?bool $color): void{
            $cell1 = create_table_cell(["contents" => $question]);

            $cell2 = match ($color) {
                true => create_element("td", false, ["style" => "background-color:lightgreen"]),
                NULL => create_element("td", false, ["style" => "background-color:yellow"]),
                false => create_element("td", false, ["style" => "background-color:red"]),
            };

            foreach ($selected as $s){
                add_to_element($cell2, create_element("p", true, ["contents" => $s]));
            }
            close_element($cell2);

            $cell3 = create_element("td", false, []);
            foreach ($correct as $c){
                add_to_element($cell3, create_element("p", true, ["contents" => $c]));
            }
            close_element($cell3);

            echo create_table_row(["contents" => [$cell1, $cell2, $cell3]]);
        }

        /**
         * Displays all answers user chose and whether or not they were correct
         */
        protected function quizStats(): void{
            create_table(["class" => "quizTable"]);

            $header1 = create_element("th", true, ["contents" => "Question"]);
            $header2 = create_element("th", true, ["contents" => "Selected"]);
            $header3 = create_element("th", true, ["contents" => "Correct"]);
            echo create_table_row(["contents" => [$header1, $header2, $header3]]);

            for($i = 0; $i < count($this->userAns); $i++){
                $this->quizStatRow($this->questions[$i], $this->userAns[$i][0], $this->userAns[$i][1], $this->color[$i]);
            }
            end_table();
        }



        abstract protected function generateBody();
    }

?>
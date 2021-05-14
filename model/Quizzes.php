<?php

    namespace model;

    use exception\InvalidQuizIdException;

    class Quizzes {

        /**
         * @param int $id
         * @return array
         * Returns quiz info if given quiz ID exists.
         * Format: [string quizName, string description, bool isPublic, bool commentsEnabled, string qref]
         * Exception is thrown if given ID does not exist
         * @throws InvalidQuizIdException
         */
        public static function getQuiz(int $id): array{
            $db = Database::getInstance();

            $query = <<<SQL
                SELECT quiz.name, quiz.description, quiz.public, quiz.comments, quiz.qref
                FROM quiz
                WHERE quiz.id = :id
            SQL;

            $data = $db->prepare($query);
            $data->execute([":id" => strval($id)]);
            $data = $data->fetchAll();

            if(empty($data)){
                throw new InvalidQuizIdException(strval($id));
            }

            $data = $data[0];
            $public = $data["public"] === "1";
            $comments = $data["comments"] === "1";

            return array($data["name"], $data["description"], $public, $comments, $data["qref"]);
        }

        /**
         * @param int $id
         * @return array
         * Returns an array containing only questions from quiz with given ID.
         */
        public static function getQuestions(int $id): array{
            $db = Database::getInstance();

            $query = <<<SQL
                SELECT quiz.qref
                FROM quiz
                WHERE quiz.id = :id
            SQL;

            $data = $db->prepare($query);
            $data->execute([":id" => strval($id)]);
            $data = $data->fetchAll()[0];

            $questions = explode(";", $data["qref"]);
            array_pop($questions);

            for($i = 0; $i < count($questions); $i++){
                preg_match("~.+{~", $questions[$i], $arr);

                $questions[$i] = substr($arr[0], 0, -1);
                $arr = [];
            }

            return $questions;

        }
    }

?>
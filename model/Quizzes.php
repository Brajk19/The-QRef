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

        /**
         * @param string $quizID
         * @param string $email
         * @param int $score
         * Stores score from quiz to database.
         */
        public static function storeResult(string $quizID, string $email, int $score): void{
            $db = Database::getInstance();

            $query = <<<SQL
                INSERT INTO result
                VALUES (:quizID, :email, :score)
            SQL;

            $data = $db->prepare($query);
            $data->execute([":quizID" => $quizID, ":email" => $email, ":score" => $score]);
        }

        /**
         * @param string $email
         * @return array
         * Returns number of attempts and average score for each quiz user took.
         * Format: [[name => quiz name, attempts => number of attempts, avg => average score], [], ...]
         */
        public static function getStats(string $email): array{
            $db = Database::getInstance();

            $query = <<<SQL
                SELECT quiz.name, COUNT(*) as attempts, AVG(score) as avg
                FROM quiz JOIN result
                ON result.quizID = quiz.id
                WHERE result.email = :email
                GROUP BY result.quizID
            SQL;

            $data = $db->prepare($query);
            $data->execute([":email" => $email]);

            return $data->fetchAll();
        }
    }

?>
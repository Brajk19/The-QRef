<?php

    namespace model;

    class Stats {

        /**
         * @param bool $user True for quizzes made by logged in user, false for stats for every other quiz.
         * @return array
         * Returns stats of quizzes made by user that's currently logged in.
         * [[name => ..., min => ..., max => ..., avg => ..., stddev => ..., median => ...], [], ...]
         */
        public static function getQuizStats(bool $user): array{
            $db = Database::getInstance();

            $compare = ($user === true) ? "=" : "<>";

            $subquery = <<<SQL
                (SELECT DISTINCT MEDIAN(r1.score) OVER (PARTITION BY r1.quizID)
                FROM quiz as q1 LEFT JOIN result as r1
                    ON q1.id = r1.quizID
                WHERE quiz.id = q1.id)
            SQL;

            $query = <<<SQL
                SELECT quiz.name, MIN(result.score) as min, MAX(result.score) as max, AVG(result.score) as avg,
                    STDDEV(result.score) as stddev, $subquery as median
                FROM quiz LEFT JOIN result
                    ON quiz.id = result.quizID
                WHERE quiz.email $compare :email
                GROUP BY result.quizID
            SQL;

            $data = $db->prepare($query);
            $data->execute([":email" => $_SESSION["email"]]);
            $data = $data->fetchAll();

            return $data;

        }

    }

?>
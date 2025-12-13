<?php
require_once '/models/Lesson.php';

class LessonController
{
    private function checkAdmin()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
            die("Không có quyền Admin!");
        }
    }

    public function create()
    {
        $this->checkAdmin();
        $course_id = $_GET['course_id'];
        require '/views/lessons/create.php';
    }

    public function store()
    {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lesson = new Lesson();
            $lesson->create($_POST['course_id'], $_POST['title'], $_POST['video_url']);
            header("Location: /BTTH02_CNWeb/onlinecourse/courses/detail/" . $_POST['course_id']);
        }
    }

    public function delete()
    {
        $this->checkAdmin();
        $lesson = new Lesson();
        $lesson->delete($_GET['id']);
        header("Location: /BTTH02_CNWeb/onlinecourse/courses/detail/" . $_GET['course_id']);
    }
}
?>
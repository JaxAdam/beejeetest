<?php

namespace application\models;

use application\core\Model;

class Main extends Model
{
    public function getTaskValidationResult($data)
    {
        $result = true;
        if($data['authorized'] == 'yes' && empty($_SESSION['userName']) && empty($_SESSION['userEmail'])) $result = 'Вы вышли из системы';
        (!empty($data['taskText'])) ? $text = htmlspecialchars($data['taskText']) : $result = 'Введите текст задачи';
        (!empty($data['email'])) ? $email = htmlspecialchars($data['email']) : $result = 'Введите email';
        (!empty($data['name'])) ? $name = htmlspecialchars($data['name']) : $result = 'Введите имя';
        if($email != null){
            (filter_var($email, FILTER_VALIDATE_EMAIL) || $email == 'admin') ?: $result = "Не правильный формат email";
        }
        return $result;
    }

    public function addTask($data)
    {
        $this->db->addRow('INSERT INTO `tasks` (`user`, `email`, `text`) VALUES 
                                                    (:username, :email, :text)', [
            'username' => htmlspecialchars($data['name']),
            'email' => htmlspecialchars($data['email']),
            'text' => htmlspecialchars($data['taskText']),
        ]);
    }

    public function editTask($oldTask, $data)
    {
        $result = true;
        if($oldTask['text'] != htmlspecialchars($data['taskText'])){
            $this->db->doQuery('UPDATE `tasks` SET `text` = :text WHERE `id` = :id', [
                'text' => htmlspecialchars($data['taskText']),
                'id' => $oldTask['id'],
            ]);
            if($oldTask['edited'] == null){
                $this->db->doQuery("UPDATE `tasks` SET `edited` = 1 WHERE `id` = :id", ['id' => $oldTask['id']]);
            }
        }else{
            $result = false;
        }
        return $result;
    }

    public function getTasks($page, $sortBy, $sortDirection, $status, $perPage = 3)
    {
        $start = ($page - 1) * 3;
        $query = 'SELECT * FROM `tasks` ';
        $countQuery = 'SELECT COUNT(*) FROM `tasks` ';
        $queryArguments = [];
        if ($status !== null) {
            $query .= 'WHERE `status` = :status ';
            $countQuery .= 'WHERE `status` = :status ';
            $queryArguments['status'] = $status;
        }
        $query .= 'ORDER BY ' . $sortBy . ' ' . $sortDirection . ' LIMIT ' . $start . ',' . $perPage;
        $totalCount = $this->db->getValue($countQuery, $queryArguments);
        $totalPages = ceil($totalCount / 3);
        $tasks = $this->db->getAll($query, $queryArguments);
        $tasksCount = count($tasks);
        $navigationHtml = $this->getPageNavigationHtml($page, $totalPages);
        return [
            'tasks' => $tasks,
            'pagination' => $navigationHtml,
            'totalTasksCount' => $totalCount,
            'shownTasksCount' => $tasksCount,
            'totalPagesCount' => $totalPages,
        ];
    }

    public function getPageNavigationHtml($currentPage, $totalPages)
    {
        $htmlbeginning = $htmlEnding = $current = $back = $forward = $start = $end = $secondLeftPage = $firstLeftPage = $firstRightPage = $secondRightPage = null;
        if($totalPages > 1){
            $htmlbeginning = ' <nav aria-label="Page navigation example"><ul class="pagination justify-content-center">';
            $htmlEnding = ' </ul></nav>';
            $current = '<li class="page-item active disabled"><a class="page-link" href="#">'.$currentPage.'<span class="sr-only">(current)</span></a>
    </li>';
        }
        ($currentPage <= 1) ?: $back = '<li class="page-item"><a class="page-link" href="/' . ($currentPage - 1) . '" aria-label="Previous"><span aria-hidden="true">&lsaquo;</span><span class="sr-only">Назад</span></a></li>';
        ($currentPage >= $totalPages) ?: $forward = '<li class="page-item"><a class="page-link" href="/' . ($currentPage + 1) . '" aria-label="Next"><span aria-hidden="true">&rsaquo;</span><span class="sr-only">Вперед</span></a></li>';
        ($currentPage <= 3) ?: $start = '<li class="page-item"><a class="page-link" href="/" aria-label="Start"><span aria-hidden="true">&laquo;</span><span class="sr-only">Начало</span></a></li>';
        ($currentPage >= ($totalPages - 2)) ?: $end = '<li class="page-item"><a class="page-link" href="/'.$totalPages.'" aria-label="End"><span aria-hidden="true">&raquo;</span><span class="sr-only">Конец</span></a></li>';
        ($currentPage - 2 <= 0) ?: $secondLeftPage = ' <li class="page-item"><a class="page-link" href="/'. (intval($currentPage) - 2) .'">' . (intval($currentPage) - 2) . '</a></li>';
        ($currentPage - 1 <= 0) ?: $firstLeftPage = ' <li class="page-item"><a class="page-link" href="/'. (intval($currentPage) - 1) .'">' . (intval($currentPage) - 1) . '</a></li>';
        ($currentPage + 1 > $totalPages) ?: $firstRightPage = ' <li class="page-item"><a class="page-link" href="/'. (intval($currentPage) + 1) .'">' . (intval($currentPage) + 1) . '</a></li>';
        ($currentPage  + 2 > $totalPages) ?: $secondRightPage = ' <li class="page-item"><a class="page-link" href="/'. (intval($currentPage) + 2) .'">' . (intval($currentPage) + 2) . '</a></li>';
        return $htmlbeginning . $start . $back . $secondLeftPage . $firstLeftPage . $current . $firstRightPage . $secondRightPage . $forward . $end . $htmlEnding;
    }

    public function switchTaskStatus($taskId){
        $currentTaskStatus = intval($this->db->getValue('SELECT `status` FROM `tasks` WHERE `id` = :id', ['id' => $taskId]));
        if($currentTaskStatus === 0){
            $newStatus = 1;
        }elseif($currentTaskStatus === 1){
            $newStatus = 0;
        }
        $this->db->doQuery("UPDATE `tasks` SET `status` = :newStatus WHERE `id` = :taskId", [
            'newStatus' => $newStatus,
            'taskId' => $taskId,
        ]);
    }

    public function deleteTask($taskId){
        $this->db->doQuery('DELETE FROM `tasks` WHERE `id` = :id', ['id' => $taskId]);
    }

    public function getTaskById($taskId){
        return $this->db->getRow('SELECT * FROM `tasks` WHERE `id` = :id', [
            'id' => $taskId
        ]);
    }

}
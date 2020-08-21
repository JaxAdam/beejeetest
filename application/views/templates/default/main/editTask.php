<h1 class="h4 mb-3 font-weight-bold text-primary">Редактирование задачи</h1>
<form class="ajax-form" method="post" action="/edit/<?php echo $task['id']?>">
    <p><span class="font-weight-bold text-primary">Автор задачи: </span> <?php echo $task['user'];?></p>
    <p><span class="font-weight-bold text-primary">Email: </span> <?php echo $task['email'];?></p>
    <input type="hidden" name="authorized" value="yes">
    <input type="hidden" id="taskerName" name="name" value="<?php echo $userName; ?>">
    <input type="hidden" id="taskerEmail" name="email" value="<?php echo $userEmail; ?>">
    <div class="form-group">
        <label for="taskText">Текст задачи</label>
        <textarea class="form-control" id="taskText" rows="3" name="taskText"><?php echo $task['text'];?></textarea>
    </div>
    <input type="submit" class="btn btn-primary" value="Редактировать">
</form>


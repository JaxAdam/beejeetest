<form class="ajax-form" method="post" action="/add">
    <?php if (!empty($userEmail) && !empty($userName)): ?>
        <input type="hidden" name="authorized" value="yes">
    <?php else: ?>
        <input type="hidden" name="authorized" value="no">
    <?php endif; ?>
    <?php if (!empty($userName)): ?>
        <input type="hidden" id="taskerName" name="name" value="<?php echo $userName; ?>">
    <?php else: ?>
        <div class="form-group">
            <label for="taskerName">Имя</label>
            <input type="text" class="form-control" id="taskerName" name="name" placeholder="Алекс">
        </div>
    <?php endif; ?>
    <?php if (!empty($userEmail)): ?>
        <input type="hidden" id="taskerName" name="email" value="<?php echo $userEmail; ?>">
    <?php else: ?>
        <div class="form-group">
            <label for="taskerMail">E-mail</label>
            <input type="text" class="form-control" id="taskerMail" name="email" placeholder="name@example.com">
        </div>
    <?php endif; ?>
    <div class="form-group">
        <label for="taskText">Текст задачи</label>
        <textarea class="form-control" id="taskText" rows="3" name="taskText"></textarea>
    </div>
    <input type="submit" class="btn btn-primary" value="Добавить">
</form>

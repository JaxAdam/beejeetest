<form class="ajax-form" action="/signup" method="post">
    <div class="form-group">
        <label for="taskerName">Имя</label>
        <input type="text" class="form-control" id="taskerName" name="taskerName" placeholder="Алекс">
    </div>
    <div class="form-group">
        <label for="taskerMail">E-mail</label>
        <input type="text" class="form-control" id="taskerMail" name="taskerMail" placeholder="name@example.com">
    </div>
    <div class="form-group">
        <label for="password1">Пароль</label>
        <input type="password" class="form-control" id="password1" name="password1" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="password2">Повторите пароль</label>
        <input type="password" class="form-control" id="password2" name="password2" autocomplete="off">
    </div>
    <input type="submit" class="btn btn-primary" value="Зарегистрироваться">
</form>

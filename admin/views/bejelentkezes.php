<h1>Bejelentkezés</h1>

<form method="POST" action="">
    <input type="text" class="input" name=":email" placeholder="email cím">

    <input type="password" class="input" name=":password" placeholder="jelszó">
    
    <input type="hidden" name="token" value="<?=$token?>">

    <button class="input" name="login">Belépés</button>
</form>
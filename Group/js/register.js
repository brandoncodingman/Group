'use strict';
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');

    form.addEventListener("submit", function (e) {
        const username = form.username.value.trim();
        const password = form.password.value.trim();

        if (!username || !password) {
            alert('ユーザーIDとパスワードの両方を入力してください。');
            e.preventDefault();
        } else if(username && password) {
            e.preventDefault();
            const loginElement = document.querySelector('.login');
            loginElement.innerHTML = '<div class="done"></div>';
            const DoneElement = document.querySelector('.done');
            DoneElement.insertAdjacentHTML ('beforeend','<h1>登録完了しました</h1>');
            DoneElement.insertAdjacentHTML ('beforeend','<p>ログインは<a href="login.html">こちら</a>へ</p>');
        }
    });
});
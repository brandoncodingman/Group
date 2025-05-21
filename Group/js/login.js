// <!DOCTYPE html>
// <html lang="en">
// <head>
//     <meta charset="UTF-8">
//     <meta name="viewport" content="width=device-width, initial-scale=1.0">
//     <title>Document</title>
// </head>
// <body>
//     <h1>Sign in or Register</h1>
//        <!-- form with username and password and submit or register with email, username, password if not registered -->
//     <form action="" method="post">
//         <input type="text" name="username" placeholder="Username"><br>
//         <input type="password" name="password" placeholder="Password"><br>
//         <input type="submit" name="submit" value="Submit"><br>
//         <input type="submit" name="register" value="Register">
//     </form>
// </body>
// </html>

const form = getElementById("form");
const username = getElementById("username");
const password = getElementById("password");
const submit = getElementById("submit");
const register = getElementById("register");

form.addEventListener("submit", function (e) {
    e.preventDefault();
    if (submit) {
        // login
    } else if (register) {
        // register
    }
});

// Add hover effect to change background color to a random pastel color
const fancyBoxes = document.querySelectorAll(".fancy-box");
fancyBoxes.forEach((box) => {
  box.addEventListener("mouseenter", function () {
    const randomColor = getRandomPastelColor();
    box.style.backgroundColor = randomColor;
  });
});
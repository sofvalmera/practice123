<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div id="form">
        <form>
        <input type="text" name="fname" placeholder="Firstname">
        <input type="text" name="lname" placeholder="lastname">
        <input type="text" name="email" placeholder="email">
        <input type="text" name="password" placeholder="Password">
        <input type="text" name="token" placeholder="Token">
        <button>Submit</button>
        </form>
    </div>
    <script>
        const form = document.getElementById('form')

        form.addEventListener('click', function(event) {
            event.preventDefault();
            var formData = new FormData();
            console.log(formData);
        })
    </script>
</body>
</html>
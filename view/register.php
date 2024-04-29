<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>firstname</th>
                <th>lastname</th>
                <th>email</th>
                <th>password</th>
                <th>token</th>
            </tr>
        </thead>
        <tbody id="table-body">
            <tr>
                <td id="id">Id</td>
                <td id="firstname"></td>
                <td id="lastname"></td>
                <td id="email"></td>
                <td id="password"></td>
                <td id="token"></td>
            </tr>
        </tbody>
    </table>

<script>
    fetch('http://localhost/activity5/route/getalluser.php')
    .then(res => res.json())
    .then(res => {
        console.log(res);

        const firstname = document.getElementById('firstname');
        const lastname = document.getElementById('lastname');
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const token = document.getElementById('token');
        const id = document.getElementById('id')

        // for (let i = 0; i < res.length; i++) {
        //     
        // } 

        res.forEach(data => {
            id.innerHTML =  data['id'];
            firstname.innerHTML =  data['fname'];
            lastname.innerHTML =  data['lname'];
            email.innerHTML =  data['email'];
            password.innerHTML =  data['password'];
            token.innerHTML =  data['token'];
        });
        
        // console.log(res.length);
    });
</script>
</body>
</html>
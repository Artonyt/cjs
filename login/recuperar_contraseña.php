<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Recuperar Clave</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #e0e0e0; /* Fondo gris */
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 10px;
            max-width: 400px;
            width: 100%;
        }

        .forgot-form {
            text-align: center;
            width: 100%;
        }

        .forgot-form h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .forgot-form p {
            font-size: 14px;
            color: #666;
            margin: 10px 0;
            text-align: center;
        }

        .send-button, .back-button {
            background-color: #6a1b9a; /* Morado */
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
            width: 100%;
            margin-top: 10px;
        }

        .send-button:hover, .back-button:hover {
            background-color: #8e24aa; /* Morado más claro */
        }

        .send-button {
            padding: 12px 20px;
        }

        .back-button {
            padding: 8px 16px;
            font-size: 14px;
        }

        #email {
            width: 100%;
            padding: 12px;
            margin: 10px 0 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-control {
            margin-bottom: 10px;
        }

        .falla p {
            color: red;
        }

        .ok p {
            color: green;
        }

        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }

        .contact-info {
            font-size: 12px;
            color: #999;
            margin-top: 20px;
            text-align: center;
        }

        .message {
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
            width: 100%;
            text-align: center;
            display: none; /* Oculto inicialmente */
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }

        @media (max-width: 600px) {
            body {
                padding: 10px;
            }

            .container {
                width: 100%;
                box-shadow: none;
                background-color: transparent;
                padding: 20px;
            }

            .forgot-form h2 {
                font-size: 20px;
            }

            .send-button {
                font-size: 14px;
                padding: 10px 16px;
            }

            .back-button {
                font-size: 12px;
                padding: 8px 14px;
            }

            #email {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="../assets/logo.png" alt="Logo" class="logo">
        <div class="forgot-form">
            <h2>Recuperar Clave</h2>
            <p>Escriba su correo asociado para enviar su contraseña</p>
            <form id="forgot-form">
                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" required>
                <input type="button" class="send-button" value="Enviar" onclick="sendEmail()">
            </form>
            <div class="message" id="message"></div>
            <button class="back-button" onclick="window.location.href='index.php'">Volver</button>
            <div class="contact-info">
                <p>Si tiene algún problema, escriba a este correo <a href="mailto:vanegasantonio452@gmail.com">vanegasantonio452@gmail.com</a></p>
            </div>
        </div>
    </div>

    <script>
    function sendEmail() {
    console.log("Botón de enviar clickeado"); // Agrega esto para depuración
    var email = document.getElementById("email").value;
    var message = document.getElementById("message");

    if (!validateEmail(email)) {
        message.className = "message error";
        message.innerText = "Por favor, introduce un correo electrónico válido.";
        message.style.display = "block";
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "send_password.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);

                if (response.success) {
                    message.className = "message success";
                } else {
                    message.className = "message error";
                }
                message.innerText = response.message;
                message.style.display = "block";
            }
        }
    };

    xhr.send("email=" + encodeURIComponent(email));
}

function validateEmail(email) {
    var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

</script>

</body>
</html>

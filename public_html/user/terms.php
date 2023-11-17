<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!-- Favicons -->
    <link href="./img/icons.png" rel="icon">
    <title>Secure Usage Best Practices</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playpen+Sans:wght@200&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Playpen Sans', cursive;
        }

        .ck-center-h1,
        .ck-center-h3 {
            text-align: center;
        }

        .ck-hr-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 15px 0;
        }

        .ck-custom-hr {
            width: 5%;
            border-color: black;
            border-width: 2px;
        }

        .ck-section {
            background-color: #f6f3ef;
            padding: 20px;
        }
    </style>

</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <div class="mx-auto">
        <div class="ck-section">
            <br />
            <h3 class="fw-bolder ck-center-h3">Secure Usage Best Practices</h3>
            <div class="ck-hr-container">
                <hr class="ck-custom-hr"> <!-- Apply the custom-hr class to control the length -->
            </div>
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            Strong Passwords
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <ul>
                                <li>Encourage users to create strong, unique passwords for their accounts.</li>
                                <li>Emphasize the use of a combination of uppercase and lowercase letters, numbers, and special characters.</li>
                                <li>Suggest the use of password manager tools to generate and store complex passwords securely.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            Two-Factor Authentication (2FA)
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <ul>
                                <li>Promote the use of two-factor authentication to add an extra layer of security to user accounts.</li>
                                <li>Explain how 2FA can help protect accounts even if passwords are compromised.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseThree" aria-expanded="false"
                            aria-controls="flush-collapseThree">
                            Regular Password Updates
                        </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse"
                        aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <ul>
                                <li>Encourage users to update their passwords regularly to reduce the risk of unauthorized access.</li>
                                <li>Provide reminders or notifications for users to change their passwords at predefined intervals.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseFive" aria-expanded="false"
                            aria-controls="flush-collapseFive">
                            Secure Connection Practices
                        </button>
                    </h2>
                    <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <ul>
                                <li>Advise users to access the application only through secure and trusted networks.</li>
                                <li>Highlight the importance of using HTTPS to encrypt data transmitted between the user's device and the application server.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingSix">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix">
                            Phishing Awareness
                        </button>
                    </h2>
                    <div id="flush-collapseSix" class="accordion-collapse collapse" aria-labelledby="flush-headingSix"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <ul>
                                <li>Educate users on how to recognize phishing attempts, such as suspicious emails or fake websites.</li>
                                <li>Provide examples of common phishing tactics and advise users to verify the authenticity of requests for sensitive information.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingSeven">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseSeven" aria-expanded="false"
                            aria-controls="flush-collapseSeven">
                            Logout After Sessions
                        </button>
                    </h2>
                    <div id="flush-collapseSeven" class="accordion-collapse collapse"
                        aria-labelledby="flush-headingSeven" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <ul>
                                <li>Emphasize the importance of logging out of their accounts, especially on shared or public computers.</li>
                                <li>Implement automatic session timeouts to enhance security when users forget to log out.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingEight">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseEight" aria-expanded="false"
                            aria-controls="flush-collapseEight">
                            Device Security
                        </button>
                    </h2>
                    <div id="flush-collapseEight" class="accordion-collapse collapse"
                        aria-labelledby="flush-headingEight" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <ul>
                                <li>Encourage users to secure their devices with passwords or biometric authentication.</li>
                                <li>Remind them to install regular software updates and security patches for their operating systems and applications.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <br />
        </div>

        <br /><br /><br /><br />
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

</body>

</html>
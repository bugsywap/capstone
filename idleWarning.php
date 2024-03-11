<!DOCTYPE html>
<html lang="en">
<html>

<head>
    <style>
        /* Modal styles */
        .modal-idleWarning {
            display: none;
            position: fixed;
            z-index: 9;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content-idle {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 300px;
            text-align: center;
            border-radius: 10px;
        }

        @media (max-width: 600px) {
            .modal-content-idle {
                width: 80%;
                /* Adjust the width for smaller screens */
            }
        }
    </style>
</head>

<body>
    <div id="idle-warning-modal" class="modal-idleWarning">
        <div class="modal-content-idle">
            <p>Your session will expire soon due to inactivity.</p>
            <p>Please interact with the page to continue.</p>
            <p>Warning: <span id="countdown"></span> seconds left</p>
        </div>
    </div>

    <script>
        var modalTimeout;
        var countdownTimer;
        var remainingTime = 10; // Set the session timeout period to 10 seconds
        var idleWarningThreshold = 895; // Set the idle warning threshold to 5 seconds

        function showIdleWarningModal() {
            document.getElementById("idle-warning-modal").style.display = "block";
            countdownTimer = setInterval(function() {
                remainingTime--;
                document.getElementById("countdown").textContent = remainingTime;
                if (remainingTime <= 0) {
                    redirectToLogin();
                }
            }, 1000);
            modalTimeout = setTimeout(function() {
                redirectToLogin();
            }, remainingTime * 1000);
        }

        function resetIdleTimeout() {
            clearTimeout(modalTimeout);
            clearInterval(countdownTimer);
            document.getElementById("idle-warning-modal").style.display = "none";
            // Add your code to reset the idle timeout on the server
            resetSessionTimeout();
        }

        function resetSessionTimeout() {
            // Make an AJAX request to the server-side PHP script
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "session_timeout.php", true);
            xhr.send();
        }

        setTimeout(showIdleWarningModal, idleWarningThreshold * 1000);

        document.addEventListener("click", function() {
            resetIdleTimeout();
        });

        document.addEventListener("mousemove", function() {
            resetIdleTimeout();
        });

        function redirectToLogin() {
            // Redirect to the login page
            window.location.href = "login.php";
        }
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">
    <title>AI Ποιηταί | Eξυπνη ποίηση με τη βοήθεια της Τεχνητής Νοημοσύνης</title>
<head>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            overflow: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(45deg, #C33764 , #1D2671);
        }

        #chat-container {
            background-color: #00000033;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 80%;
            max-width: 600px;
            padding: 20px;
            margin: 20px auto;
        }

        /* Add some styling for the typing effect */
        #response-container {
            color:#ffffff;
            overflow: hidden;
            font-size: 20px;
            display: inline-block;
        }

        /* Create a blinking cursor */
        #response-cursor {
            display: inline-block;
            width: 0.1em;
            height: 1.2em;
            margin-left: 2px;
            background-color: #ffffff;
            animation: blink 1s infinite;
        }

        /* Apply the typing animation to response-content */
        #response-content {
            opacity: 0;
            animation: typing 3s steps(30) forwards;
        }
        #additional-text {
            display: flex;
            justify-content: flex-end;
            opacity: 0; /* Set opacity to 1 to make it visible immediately */
            transition: opacity 2s ease-in-out; /* Optional: Add a fade-in effect */
        }

        #title-container {
            color:#ffffff;
            display: flex;
            justify-content: center;
        }

        #label-text {
            font-size: 1.2rem;
            font-weight: 500;
            color: #ffffff;
        }
        #form-container {
            display: flex;
            justify-content: space-evenly;
            flex-wrap: wrap;
            gap: 10px;
        }
        .input-container {
            background: transparent;
            border: unset;
            border-bottom: 2px solid white;
            transition: all 1s ease-out;
            color:#ffffff;
        }
        .input-container:focus-visible{
            outline: unset;

        }
        #submit-button {
            background: #fdfdfd;
            color:#C33764;
            font-size: 1rem;
            padding: .25rem .75rem;
            border-radius: 8px;
            border: 2px solid #ffffff;
            font-weight: 600;
            cursor: pointer;
            transition-duration: 0.4s;
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
        }
        #recipient-text {
            border-bottom: 2px #c33764 solid;
            max-width: max-content;
        }
        .footer {
            background-color: #ffffff0d;
            color: #fff;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
            font-weight: 600;   
        }

        @keyframes blink {
            50% {
                opacity: 0;
            }
        }
        @keyframes typing {
            to {
                opacity: 1;
            }
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Page</title>
</head>
<body>
    <div id="chat-container">
        <div id="title-container"><h2>ΑΙ Ποιηταί | Ποίηση μέσω AI</h2></div>
        <form id="form-container" action="{{ route('chat.generate') }}" method="post">
            @csrf
            <label for="content" id="label-text">Φτιάξε ένα ποίημα για: </label>
            <input class="input-container" type="text" name="content" id="content" placeholder="Η λέξη σας..">
            <button id="submit-button" type="submit">Δημιουργία</button> 
        </form>

        @isset($response)
        <div id="response-container">
            <h3 id="recipient-text">Προς: {{$submittedValues['content']}}</h3>
            <h2>
                <span id="response-content">{{ $response }}</span>
                <span id="response-cursor"></span>
            </h2>
            <div id="additional-text"><p style="font-style:italic;">Αί ποιηταί</p></div>
        </div>
        @endisset
    </div>
    <div class="footer"><a href="mailto:stergiosgka@gmail.com" style="color: white; text-decoration: unset;">Contact </a>| 2024</div>
    <script>
        // Add a script to simulate the typing effect
        document.addEventListener("DOMContentLoaded", function() {
            const responseContainer = document.getElementById('response-content');
            const submitButton = document.getElementById('submit-button');
            const text = responseContainer.innerText;
            responseContainer.innerText = '';
            let i = 0;
                function type() {
                    if (i < text.length) {
                        responseContainer.innerHTML += text.charAt(i);
                        i++;
                        setTimeout(type, 50); // Adjust the typing speed (milliseconds)
                        submitButton.disabled=true;
                    } else {
                    // Typing finished, make additional text visible
                    document.getElementById('additional-text').style.opacity = 1;
                    }
                }
            //Submit button validation
            const inputField = document.getElementById('content');
            inputField.addEventListener('focus', enableButton); 
            inputField.addEventListener('input', enableButton);
                function enableButton() {
                    //enable button only if the input area is focused and has input
                    submitButton.disabled = !inputField.value.trim();
                }
            type(); 
        });
    </script>
</body>
</html>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Quiz</title>
    <!-- <link rel="stylesheet" href="quiz-style.css"> Adjust the path as needed -->
</head>
<body>






<div id="quiz-container">
    <div id="question-count"></div> <!-- New element for question count -->
    <h2 id="question">Question text...</h2>
    <ul id="answers">
        <!-- Options will be injected here -->
    </ul>
    <div id="feedback"></div>
</div>









</body>
<style>


#question-count {
    font-size: 18px;
    margin-bottom: 20px;
    color: #333;
}




@keyframes shake {
  0%, 100% { transform: translateX(0); }
  10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
  20%, 40%, 60%, 80% { transform: translateX(5px); }
}

.shake {
  animation: shake 0.2s ease-in-out;
}


.correctFeedback {
    color: green;
}

.incorrectFeedback {
    color: #e91e63;
}


@keyframes sadSmileyAnimation {
  0% { transform: translateX(0); }
  50% { transform: translateX(-5px); }
  100% { transform: translateX(0); }
}

.sadSmiley {
  display: inline-block;
  margin-left: 5px;
  animation: sadSmileyAnimation 1s ease-in-out infinite;
}



@keyframes smileyAnimation {
  0% { transform: scale(1); }
  50% { transform: scale(1.2); }
  100% { transform: scale(1); }
}

.smiley {
  display: inline-block;
  margin-left: 5px;
  animation: smileyAnimation 1s ease-in-out infinite;
}


    body {
    font-family: Arial, sans-serif;
    /* background-color: #eee; */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background-image: url('https://demo.wp.kiev.ua/wp-content/uploads/2024/02/shutterstock_1940652163-scaled.webp');
  background-size: cover; /* Cover the entire area of the container */
  background-position: center; /* Center the background image */
}

#quiz-container {
    background: #ffcb00f0;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    width: 1270px;
    text-align: center;
}

#answers {
    list-style-type: none;
    padding: 0;
}

#answers li {
    background-color: #f9f9f9;
    margin: 10px 0;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

#answers li:hover {
    background-color: #ddd;
}

button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    margin-top: 20px;
    border-radius: 5px;
    cursor: pointer;
    margin-right: auto!important;
    margin-left: auto!important;
}

button:hover {
    background-color: #0056b3;
}

#feedback {
    margin-top: 20px;
    font-weight: bold;
    /* color: #3333ff; */
    opacity: 0;
    transition: opacity 0.5s ease;
}

#question {
    margin: 20px 20px 80px 20px;
}
</style>

<script>








document.addEventListener('DOMContentLoaded', () => {
    const questions = [
        { question: "What is the best trading site?", answers: ["smarttrader.community", "community.smarttrader", "booking.com"], correct: 0 },
        { question: "Everyone should listen to how to trade", answers: ["Robert Kiyosaki", "Robert Lindner", "Robert De Niro"], correct: 1 },
        { question: "Amazon was a real fast starter - When did today's largest retailer go public?", answers: ["1995", "2004", "1997"], correct: 2 },
        // Add more questions as needed
    ];

    let currentQuestionIndex = 0;
    let score = 0;

    const questionElement = document.getElementById('question');
    const answersElement = document.getElementById('answers');
    const feedbackElement = document.getElementById('feedback');
    const quizContainer = document.getElementById('quiz-container');
    const restartButton = document.createElement('button');

    restartButton.textContent = 'Restart Quiz';
    restartButton.style.display = 'none'; // Initially hide the restart button
    quizContainer.appendChild(restartButton);

    function loadQuestion() {
    // Update question count display
    const questionCountElement = document.getElementById('question-count');
    questionCountElement.textContent = `Question ${currentQuestionIndex + 1} of ${questions.length}`;

    // Existing code to load the question...
    feedbackElement.style.opacity = 0; // Hide feedback initially
    const currentQuestion = questions[currentQuestionIndex];
    questionElement.textContent = currentQuestion.question;
    answersElement.innerHTML = '';
    currentQuestion.answers.forEach((answer, index) => {
        const li = document.createElement('li');
        li.textContent = answer;
        li.onclick = () => selectAnswer(index);
        answersElement.appendChild(li);
    });
}

    function selectAnswer(index) {
    const isCorrect = index === questions[currentQuestionIndex].correct;
    feedbackElement.innerHTML = ''; // Clear the feedback element

    // Determine the feedback message and class based on correctness
    const feedbackMessage = isCorrect ? "Correct! " : `Incorrect. The correct answer was: ${questions[currentQuestionIndex].answers[questions[currentQuestionIndex].correct]} `;
    const feedbackClass = isCorrect ? 'correctFeedback' : 'incorrectFeedback';
    const smileyFace = isCorrect ? '😊' : '😔';

    // Create the smiley span
    const smileySpan = document.createElement('span');
    smileySpan.textContent = smileyFace;
    smileySpan.className = isCorrect ? 'smiley' : 'sadSmiley';

    // Set the feedback text
    const textSpan = document.createElement('span');
    textSpan.textContent = feedbackMessage;

    // Append elements in order
    feedbackElement.appendChild(smileySpan);
    feedbackElement.appendChild(textSpan);
    feedbackElement.className = feedbackClass; // Apply the color class
    feedbackElement.style.opacity = 1;

    // If the answer is incorrect, apply the shake effect
    if (!isCorrect) {
        document.getElementById('quiz-container').classList.add('shake');

        // Remove the shake class after 2 seconds to stop the shaking
        setTimeout(() => {
            document.getElementById('quiz-container').classList.remove('shake');
        }, 2000);
    }

    // Update score and proceed with the quiz
    if (isCorrect) score++;
    if (currentQuestionIndex < questions.length - 1) {
        currentQuestionIndex++;
        setTimeout(loadQuestion, 3000);
    } else {
        setTimeout(completeQuiz, 3000);
    }
}







function completeQuiz() {
    questionElement.textContent = `Quiz completed! Your score: ${score} out of ${questions.length}.`;
    answersElement.innerHTML = ''; // Clear previous answers
    feedbackElement.textContent = ''; // Clear feedback
    restartButton.style.display = 'block'; // Show the restart button

    // Calculate the percentage of correct answers
    const scorePercentage = (score / questions.length) * 100;

    // Create the image element
    const resultImage = document.createElement('img');
    resultImage.style.marginTop = '20px'; // Add a little space above

    // Set the appropriate image URL
    if (scorePercentage > 50) {
        resultImage.src = 'https://media3.giphy.com/media/g9582DNuQppxC/200.gif'; // Change to your image URL or path
    } else {
        resultImage.src = 'https://media1.tenor.com/m/-wsLV6WhY-QAAAAC/try-again-keegan-michael-key.gif'; // Change to your image URL or path
    }

    // Append the image to the quiz container
    quizContainer.appendChild(resultImage);

    // Optionally clear or hide the #question-count element
    const questionCountElement = document.getElementById('question-count');
    questionCountElement.style.display = 'none'; // Hide the element
}





restartButton.onclick = () => {
    currentQuestionIndex = 0;
    score = 0;
    restartButton.style.display = 'none'; // Hide the restart button
    
    // Remove the result image if it exists
    const resultImage = document.querySelector('#quiz-container img');
    if (resultImage) {
        resultImage.remove();
    }

    // Optionally, reset or show the #question-count element
    const questionCountElement = document.getElementById('question-count');
    questionCountElement.style.display = ''; // Show the element or reset its display property
    
    loadQuestion(); // Restart the quiz
};


    loadQuestion(); // Initial load
});

</script>
</html>
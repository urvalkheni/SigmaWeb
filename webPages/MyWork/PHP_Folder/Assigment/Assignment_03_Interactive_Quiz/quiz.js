// Assignment 3: Interactive Quiz Application
// Student: Kheni Urval | ID: 24CE55 | Course: WDF: ITUE203

// Quiz questions data using ES6 const and objects
const quizQuestions = [
    {
        id: 1,
        question: "What does 'const' keyword do in JavaScript?",
        options: [
            "Creates a variable that can be reassigned",
            "Creates a constant variable that cannot be reassigned",
            "Creates a function",
            "Creates an object"
        ],
        correct: 1,
        explanation: "The 'const' keyword creates a constant variable that cannot be reassigned after declaration."
    },
    {
        id: 2,
        question: "Which method is used to add an element to the end of an array?",
        options: [
            "pop()",
            "shift()",
            "push()",
            "unshift()"
        ],
        correct: 2,
        explanation: "The push() method adds one or more elements to the end of an array."
    },
    {
        id: 3,
        question: "What is the difference between '==' and '===' in JavaScript?",
        options: [
            "No difference, they are the same",
            "'==' checks type and value, '===' checks only value",
            "'==' checks only value, '===' checks type and value",
            "Both check only the type"
        ],
        correct: 2,
        explanation: "'==' performs type coercion and checks value, while '===' checks both type and value without coercion."
    },
    {
        id: 4,
        question: "Which ES6 feature allows you to extract values from arrays or objects?",
        options: [
            "Destructuring",
            "Template literals",
            "Arrow functions",
            "Promises"
        ],
        correct: 0,
        explanation: "Destructuring assignment allows you to extract values from arrays or properties from objects into distinct variables."
    },
    {
        id: 5,
        question: "What does the 'addEventListener' method do?",
        options: [
            "Creates a new HTML element",
            "Attaches an event handler to an element",
            "Removes an element from DOM",
            "Changes element styles"
        ],
        correct: 1,
        explanation: "The addEventListener() method attaches an event handler to an element without overwriting existing event handlers."
    }
];

// Quiz state using let for variables that will change
let currentQuestion = 0;
let userAnswers = [];
let score = 0;
let quizStarted = false;

// DOM element references using const (ES6)
const startScreen = document.getElementById('start-screen');
const quizScreen = document.getElementById('quiz-screen');
const resultsScreen = document.getElementById('results-screen');
const reviewScreen = document.getElementById('review-screen');

const startBtn = document.getElementById('start-btn');
const prevBtn = document.getElementById('prev-btn');
const nextBtn = document.getElementById('next-btn');
const reviewBtn = document.getElementById('review-btn');
const restartBtn = document.getElementById('restart-btn');
const backToResultsBtn = document.getElementById('back-to-results');
const restartFromReviewBtn = document.getElementById('restart-from-review');

const progressFill = document.getElementById('progress-fill');
const progressText = document.getElementById('progress-text');
const questionText = document.getElementById('question-text');
const optionsContainer = document.getElementById('options-container');
const scorePercentage = document.getElementById('score-percentage');
const scoreText = document.getElementById('score-text');
const resultsBreakdown = document.getElementById('results-breakdown');
const reviewQuestions = document.getElementById('review-questions');

// Event listeners using arrow functions (ES6)
startBtn.addEventListener('click', () => startQuiz());
prevBtn.addEventListener('click', () => previousQuestion());
nextBtn.addEventListener('click', () => nextQuestion());
reviewBtn.addEventListener('click', () => showReview());
restartBtn.addEventListener('click', () => restartQuiz());
backToResultsBtn.addEventListener('click', () => showResults());
restartFromReviewBtn.addEventListener('click', () => restartQuiz());

// Initialize quiz
const initializeQuiz = () => {
    console.log('Quiz initialized by Kheni Urval (24CE55)');
    showScreen('start-screen');
};

// Start quiz function
const startQuiz = () => {
    quizStarted = true;
    currentQuestion = 0;
    userAnswers = [];
    score = 0;
    
    showScreen('quiz-screen');
    displayQuestion();
    updateNavigation();
    updateProgress();
};

// Display current question
const displayQuestion = () => {
    const question = quizQuestions[currentQuestion];
    questionText.textContent = question.question;
    
    // Clear previous options
    optionsContainer.innerHTML = '';
    
    // Create option buttons using forEach (ES6)
    question.options.forEach((option, index) => {
        const optionButton = document.createElement('button');
        optionButton.className = 'option-btn';
        optionButton.textContent = option;
        optionButton.setAttribute('data-index', index);
        
        // Check if this option was previously selected
        if (userAnswers[currentQuestion] === index) {
            optionButton.classList.add('selected');
        }
        
        // Add click event using arrow function
        optionButton.addEventListener('click', () => selectOption(index, optionButton));
        
        optionsContainer.appendChild(optionButton);
    });
};

// Select option function
const selectOption = (optionIndex, buttonElement) => {
    // Remove previous selection
    const allOptions = optionsContainer.querySelectorAll('.option-btn');
    allOptions.forEach(btn => btn.classList.remove('selected'));
    
    // Add selection to clicked button
    buttonElement.classList.add('selected');
    
    // Store user answer
    userAnswers[currentQuestion] = optionIndex;
    
    // Enable next button
    nextBtn.disabled = false;
    
    console.log(`Question ${currentQuestion + 1}: Selected option ${optionIndex + 1}`);
};

// Navigation functions
const previousQuestion = () => {
    if (currentQuestion > 0) {
        currentQuestion--;
        displayQuestion();
        updateNavigation();
        updateProgress();
    }
};

const nextQuestion = () => {
    if (currentQuestion < quizQuestions.length - 1) {
        currentQuestion++;
        displayQuestion();
        updateNavigation();
        updateProgress();
    } else {
        // Quiz completed
        calculateScore();
        showResults();
    }
};

// Update navigation buttons
const updateNavigation = () => {
    prevBtn.disabled = currentQuestion === 0;
    
    if (currentQuestion === quizQuestions.length - 1) {
        nextBtn.textContent = 'Finish Quiz';
    } else {
        nextBtn.textContent = 'Next';
    }
    
    // Check if current question is answered
    nextBtn.disabled = userAnswers[currentQuestion] === undefined;
};

// Update progress bar
const updateProgress = () => {
    const progress = ((currentQuestion + 1) / quizQuestions.length) * 100;
    progressFill.style.width = `${progress}%`;
    progressText.textContent = `Question ${currentQuestion + 1} of ${quizQuestions.length}`;
};

// Calculate final score
const calculateScore = () => {
    score = 0;
    userAnswers.forEach((answer, index) => {
        if (answer === quizQuestions[index].correct) {
            score++;
        }
    });
    
    console.log(`Quiz completed by student 24CE55. Score: ${score}/${quizQuestions.length}`);
};

// Show results screen
const showResults = () => {
    showScreen('results-screen');
    
    const percentage = Math.round((score / quizQuestions.length) * 100);
    scorePercentage.textContent = `${percentage}%`;
    scoreText.textContent = `You scored ${score} out of ${quizQuestions.length}`;
    
    // Animate score circle
    animateScore(percentage);
    
    // Display results breakdown
    displayResultsBreakdown();
};

// Animate score display
const animateScore = (targetPercentage) => {
    let currentPercentage = 0;
    const increment = targetPercentage / 50; // Animation duration
    
    const animation = setInterval(() => {
        currentPercentage += increment;
        if (currentPercentage >= targetPercentage) {
            currentPercentage = targetPercentage;
            clearInterval(animation);
        }
        scorePercentage.textContent = `${Math.round(currentPercentage)}%`;
    }, 20);
};

// Display results breakdown
const displayResultsBreakdown = () => {
    resultsBreakdown.innerHTML = '';
    
    const correctCount = score;
    const incorrectCount = quizQuestions.length - score;
    
    const breakdownHTML = `
        <div class="breakdown-item">
            <span class="breakdown-label">Correct Answers:</span>
            <span class="breakdown-value correct">${correctCount}</span>
        </div>
        <div class="breakdown-item">
            <span class="breakdown-label">Incorrect Answers:</span>
            <span class="breakdown-value incorrect">${incorrectCount}</span>
        </div>
        <div class="breakdown-item">
            <span class="breakdown-label">Accuracy:</span>
            <span class="breakdown-value">${Math.round((score / quizQuestions.length) * 100)}%</span>
        </div>
    `;
    
    resultsBreakdown.innerHTML = breakdownHTML;
};

// Show review screen
const showReview = () => {
    showScreen('review-screen');
    displayReview();
};

// Display detailed review
const displayReview = () => {
    reviewQuestions.innerHTML = '';
    
    quizQuestions.forEach((question, index) => {
        const userAnswer = userAnswers[index];
        const isCorrect = userAnswer === question.correct;
        
        const reviewItem = document.createElement('div');
        reviewItem.className = 'review-item';
        
        reviewItem.innerHTML = `
            <div class="review-question">
                <h4>Question ${index + 1}: ${question.question}</h4>
                <div class="review-status ${isCorrect ? 'correct' : 'incorrect'}">
                    ${isCorrect ? '✓ Correct' : '✗ Incorrect'}
                </div>
            </div>
            
            <div class="review-options">
                ${question.options.map((option, optIndex) => {
                    let optionClass = 'review-option';
                    
                    if (optIndex === question.correct) {
                        optionClass += ' correct-answer';
                    }
                    if (optIndex === userAnswer && !isCorrect) {
                        optionClass += ' user-incorrect';
                    }
                    if (optIndex === userAnswer) {
                        optionClass += ' user-selected';
                    }
                    
                    return `<div class="${optionClass}">${option}</div>`;
                }).join('')}
            </div>
            
            <div class="review-explanation">
                <strong>Explanation:</strong> ${question.explanation}
            </div>
        `;
        
        reviewQuestions.appendChild(reviewItem);
    });
};

// Restart quiz function
const restartQuiz = () => {
    currentQuestion = 0;
    userAnswers = [];
    score = 0;
    quizStarted = false;
    
    showScreen('start-screen');
    console.log('Quiz restarted by Kheni Urval (24CE55)');
};

// Utility function to show specific screen
const showScreen = (screenId) => {
    const screens = [startScreen, quizScreen, resultsScreen, reviewScreen];
    screens.forEach(screen => screen.classList.add('hidden'));
    
    document.getElementById(screenId).classList.remove('hidden');
};

// Initialize quiz when page loads
document.addEventListener('DOMContentLoaded', () => {
    initializeQuiz();
    console.log('Interactive Quiz loaded successfully - Created by Kheni Urval (24CE55)');
});

// Additional utility functions using ES6 features

// Get quiz statistics (using destructuring and template literals)
const getQuizStats = () => {
    const { length: totalQuestions } = quizQuestions;
    const completedQuestions = userAnswers.filter(answer => answer !== undefined).length;
    
    return {
        totalQuestions,
        completedQuestions,
        remainingQuestions: totalQuestions - completedQuestions,
        progressPercentage: Math.round((completedQuestions / totalQuestions) * 100)
    };
};

// Format time (if needed for future enhancements)
const formatTime = (seconds) => {
    const minutes = Math.floor(seconds / 60);
    const remainingSeconds = seconds % 60;
    return `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`;
};

// Export functions for testing (if needed)
// export { startQuiz, calculateScore, getQuizStats };
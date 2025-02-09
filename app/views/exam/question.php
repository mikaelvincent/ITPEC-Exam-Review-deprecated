<?php
// Safeguard against undefined 'question_number'
$questionNumber = isset($question->question_number) ? htmlspecialchars($question->question_number) : 'N/A';
$title = "Q" . $questionNumber . " | ITPEC Exam Review";

// Determine if the user has already submitted an answer
$isAnswered = isset($user_progress['selected_answer_id']);
?>
<div class="row">
    <div class="col-12 col-lg-8 order-lg-last">
        <div class="row mb-5">
            <div class="col">
                <?php if (!empty($question->image_path)): ?>
                    <img class="img-fluid" src="<?= htmlspecialchars($basePath) ?>/<?= htmlspecialchars($question->image_path) ?>" alt="Question Image">
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <form method="POST" action="<?= $basePath . htmlspecialchars($request->getUri()) ?>">
            <div class="row gy-3 row-cols-2 row-cols-xl-1 mb-5">
                <?php foreach ($question->getAnswers() as $answer): ?>
                    <?php
                    $isSelected = $isAnswered && $user_progress['selected_answer_id'] === $answer->id;
                    $isCorrect = $isAnswered && $answer->isCorrect();
                    $buttonClass = 'btn btn-outline-primary btn-lg w-100 py-4';
    
                    if ($isAnswered) {
                        if ($isSelected && $isCorrect) {
                            $buttonClass = 'btn btn-success btn-lg disabled w-100 py-4';
                        } elseif ($isSelected && !$isCorrect) {
                            $buttonClass = 'btn btn-danger btn-lg disabled w-100 py-4';
                        } elseif ($isCorrect) {
                            $buttonClass = 'btn btn-success btn-lg disabled w-100 py-4';
                        }
                    } elseif ($isSelected) {
                        $buttonClass .= ' active';
                    }
                    ?>
                    <div class="col">
                        <button
                            class="<?= $buttonClass ?>"
                            type="button"
                            <?= $isAnswered ? 'disabled' : '' ?>
                            data-answer-id="<?= htmlspecialchars($answer->id) ?>"
                            onclick="selectAnswer(this)"
                        >
                            <?= htmlspecialchars($answer->label) ?>
                        </button>
                        <input type="radio" name="selected_answer_id" value="<?= htmlspecialchars($answer->id) ?>" style="display:none;" <?= $isSelected ? 'checked' : '' ?>>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if (!$isAnswered): ?>
                <hr class="mb-5">
                <div class="row gy-3 row-cols-1 mb-5">
                    <div class="col">
                        <button class="btn btn-success btn-lg w-100" type="submit" id="submit-answer" disabled>Submit</button>
                    </div>
                    <div class="col">
                        <div class="modal fade" role="dialog" tabindex="-1" id="explanations">
                            <div class="modal-dialog modal-fullscreen" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title fw-bold">Explanation for Q<?= $questionNumber ?></h4>
                                        <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Explanations will be available soon.</p>
                                    </div>
                                    <div class="modal-footer text-bg-dark d-flex justify-content-center">
                                        <div class="me-sm-auto">
                                            <button class="btn btn-link btn-sm" type="button" id="prev-question">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-chevron-left fs-3">
                                                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"></path>
                                                </svg>
                                            </button>
                                            <span class="fs-5"><?= htmlspecialchars($currentQuestionIndex) ?> / <?= htmlspecialchars($totalQuestions) ?></span>
                                            <button class="btn btn-link btn-sm disabled" type="button" disabled>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-chevron-right fs-3">
                                                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <button class="btn btn-primary btn-lg" type="button" id="generate-explanation">Generate New Explanation</button>
                                        <button class="btn btn-secondary btn-lg d-none d-sm-flex" type="button" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-outline-primary btn-lg w-100" type="button" data-bs-target="#explanations" data-bs-toggle="modal">See Explanation</button>
                    </div>
                    <div class="col">
                        <a href="<?= htmlspecialchars($basePath) ?><?= htmlspecialchars($nextQuestionUrl) ?>" class="btn btn-primary btn-lg w-100" role="button">Next Question</a>
                    </div>
                    <div class="col">
                        <a href="<?= htmlspecialchars($basePath) ?><?= htmlspecialchars($nextQuestionUrl) ?>" class="btn btn-outline-success btn-lg w-100" role="button">Next Question</a>
                    </div>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>

<script>
    function selectAnswer(button) {
        // Remove active class from all buttons
        const buttons = document.querySelectorAll('[data-answer-id]');
        buttons.forEach(btn => btn.classList.remove('active'));

        // Add active class to the selected button
        button.classList.add('active');

        // Set the corresponding radio button as checked
        const radio = button.nextElementSibling;
        radio.checked = true;

        // Enable the submit button
        const submitButton = document.getElementById('submit-answer');
        submitButton.disabled = false;
    }

    // Handle form submission confirmation if necessary
    document.querySelector('form').addEventListener('submit', function(event) {
        // Implement any client-side validation or confirmation if needed
    });
</script>

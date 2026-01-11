(() => {
    const TEST_DURATION_SECONDS = 60;

    const DIFFICULTIES = {
        easy: { id: 4, wordCount: 50 },
        medium: { id: 5, wordCount: 100 },
        hard: { id: 6, wordCount: 150 },
        hardcore: { id: 7, wordCount: 300 },
    };

    const WORD_BANK = [
        'the','and','to','of','a','in','is','you','that','it','he','was','for','on','are','as','with','his','they','at','be','this','have','from','or','one','had','by','word','but','not','what','all','were','we','when','your','can','said','there','use','an','each','which','she','do','how','their','if','will','up','other','about','out','many','then','them','these','so','some','her','would','make','like','him','into','time','has','look','two','more','write','go','see','number','no','way','could','people','my','than','first','water','been','call','who','oil','its','now','find','long','down','day','did','get','come','made','may','part','over','new','sound','take','only','little','work','know','place','year','live','me','back','give','most','very','after','thing','our','just','name','good','sentence','man','think','say','great','where','help','through','much','before','line','right','too','means','old','any','same','tell'
    ];

    const elTextDisplay = document.getElementById('textDisplay');
    const elInput = document.getElementById('textInput');
    const elRestart = document.getElementById('restartBtn');
    const elDifficulty = document.getElementById('difficultySelect');
    const elWordCount = document.getElementById('wordCount');
    const elTime = document.getElementById('time');
    const elWpm = document.getElementById('wpm');
    const elAccuracy = document.getElementById('accuracy');
    const elErrors = document.getElementById('errors');
    const elSaveStatus = document.getElementById('saveStatus');

    let targetText = '';
    let startTimeMs = null;
    let timerId = null;
    let finished = false;

    function generateText(wordCount) {
        const words = [];
        for (let i = 0; i < wordCount; i++) {
            words.push(WORD_BANK[Math.floor(Math.random() * WORD_BANK.length)]);
        }
        return words.join(' ');
    }

    function pickText() {
        const diffKey = elDifficulty.value;
        const count = DIFFICULTIES[diffKey].wordCount;
        elWordCount.textContent = count;
        targetText = generateText(count);
        
        elTextDisplay.innerHTML = '';
        targetText.split('').forEach((ch, i) => {
            const span = document.createElement('span');
            span.className = 'ch';
            span.textContent = ch;
            if (i === 0) span.classList.add('current');
            elTextDisplay.appendChild(span);
        });
    }

    function newRound() {
        if (timerId) clearInterval(timerId);
        startTimeMs = null;
        finished = false;
        elInput.value = '';
        elInput.disabled = false;
        elSaveStatus.textContent = '';
        elTime.textContent = '0.0';
        elWpm.textContent = '0';
        elAccuracy.textContent = '100';
        elErrors.textContent = '0';
        pickText();
        elInput.focus();
    }

    function computeStats() {
        const typed = elInput.value;
        const spans = elTextDisplay.querySelectorAll('.ch');
        let correct = 0;
        let errors = 0;

        spans.forEach((span, i) => {
            span.classList.remove('correct', 'incorrect', 'current');
            if (i < typed.length) {
                if (typed[i] === targetText[i]) {
                    span.classList.add('correct');
                    correct++;
                } else {
                    span.classList.add('incorrect');
                    errors++;
                }
            }
        });

        if (typed.length < spans.length) {
            spans[typed.length].classList.add('current');
        }

        const elapsed = startTimeMs ? (Date.now() - startTimeMs) / 1000 : 0;
        const wpm = Math.round((correct / 5) / (Math.max(elapsed, 1) / 60));
        const accuracy = typed.length > 0 ? Math.round((correct / typed.length) * 100) : 100;

        elWpm.textContent = wpm;
        elAccuracy.textContent = accuracy;
        elErrors.textContent = errors;
        elTime.textContent = elapsed.toFixed(1);

        return { wpm, accuracy, elapsed, finished: typed.length >= targetText.length };
    }

    function finishRound(stats) {
        finished = true;
        elInput.disabled = true;
        clearInterval(timerId);
        elSaveStatus.textContent = 'Saving score...';

        const params = new URLSearchParams();
        params.append('difficulty_id', DIFFICULTIES[elDifficulty.value].id);
        params.append('time_seconds', Math.round(stats.elapsed));
        params.append('words_per_minute', stats.wpm);
        params.append('accuracy', stats.accuracy);

        fetch('/typing', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: params.toString()
        })
        .then(res => res.json())
        .then(data => {
            elSaveStatus.textContent = data.ok ? 'Score Saved!' : 'Error saving score.';
        })
        .catch(() => {
            elSaveStatus.textContent = 'Network error saving score.';
        });
    }

    elInput.addEventListener('input', () => {
        if (finished) return;

        if (startTimeMs === null) {
            startTimeMs = Date.now();
            timerId = setInterval(() => {
                const elapsed = (Date.now() - startTimeMs) / 1000;
                if (elapsed >= TEST_DURATION_SECONDS) {
                    finishRound(computeStats());
                } else {
                    computeStats();
                }
            }, 100);
        }

        const stats = computeStats();
        if (stats.finished) {
            finishRound(stats);
        }
    });

    elRestart.addEventListener('click', newRound);
    elDifficulty.addEventListener('change', newRound);

    // FIX: Wait for DOM to be ready before starting first round
    document.addEventListener('DOMContentLoaded', () => {
        newRound();
    });
})();
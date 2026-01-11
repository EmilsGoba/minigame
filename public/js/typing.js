(() => {
	const TEST_DURATION_SECONDS = 60;

	const DIFFICULTIES = {
		easy: { id: 4, wordCount: 50 },
		medium: { id: 5, wordCount: 100 },
		hard: { id: 6, wordCount: 150 },
		hardcore: { id: 7, wordCount: 300 },
	};

	// Small word bank; repeats are allowed, so 300 words is fine.
	const WORD_BANK = [
		'the','and','to','of','a','in','is','you','that','it','he','was','for','on','are','as','with','his','they','I',
		'at','be','this','have','from','or','one','had','by','word','but','not','what','all','were','we','when','your','can','said',
		'there','use','an','each','which','she','do','how','their','if','will','up','other','about','out','many','then','them','these','so',
		'some','her','would','make','like','him','into','time','has','look','two','more','write','go','see','number','no','way','could','people',
		'my','than','first','water','been','call','who','oil','its','now','find','long','down','day','did','get','come','made','may','part',
		'over','new','sound','take','only','little','work','know','place','year','live','me','back','give','most','very','after','thing','our','just',
		'name','good','sentence','man','think','say','great','where','help','through','much','before','line','right','too','means','old','any','same','tell',
		'boy','follow','came','want','show','also','around','form','three','small','set','put','end','does','another','well','large','must','big','even',
		'such','because','turn','here','why','ask','went','men','read','need','land','different','home','us','move','try','kind','hand','picture','again',
		'change','off','play','spell','air','away','animal','house','point','page','letter','mother','answer','found','study','still','learn','should','America','world',
		'high','every','near','add','food','between','own','below','country','plant','last','school','father','keep','tree','never','start','city','earth','eyes',
		'thought','head','under','story','saw','left','don\'t','few','while','along','might','close','something','seem','next','hard','open','example','begin','life',
		'always','those','both','paper','together','got','group','often','run','important','until','children','side','feet','car','mile','night','walk','white','sea',
		'began','grow','took','river','four','carry','state','once','book','hear','stop','without','second','later','miss','idea','enough','eat','face','watch',
		'far','real','almost','let','above','girl','sometimes','mountains','cut','young','talk','soon','list','song','being','leave','family','it\'s','body','music',
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

	if (!elTextDisplay || !elInput || !elRestart || !elDifficulty || !elWordCount || !elTime || !elWpm || !elAccuracy || !elErrors || !elSaveStatus) {
		return;
	}

	let targetText = '';
	let startTimeMs = null;
	let timerId = null;
	let running = false;
	let finished = false;

	function currentDifficultyKey() {
		const key = (elDifficulty.value || 'easy').toLowerCase();
		return Object.prototype.hasOwnProperty.call(DIFFICULTIES, key) ? key : 'easy';
	}

	function generateText(wordCount) {
		const words = [];
		for (let i = 0; i < wordCount; i++) {
			words.push(WORD_BANK[Math.floor(Math.random() * WORD_BANK.length)]);
		}
		return words.join(' ');
	}

	function applyDifficultyUI() {
		const key = currentDifficultyKey();
		elWordCount.textContent = String(DIFFICULTIES[key].wordCount);
	}

	function pickText() {
		const key = currentDifficultyKey();
		applyDifficultyUI();
		targetText = generateText(DIFFICULTIES[key].wordCount);
		elTextDisplay.innerHTML = '';
		for (const ch of targetText.split('')) {
			const span = document.createElement('span');
			span.className = 'ch';
			span.textContent = ch;
			elTextDisplay.appendChild(span);
		}
		markCurrent(0);
	}

	function newRound() {
		if (timerId) clearInterval(timerId);
		startTimeMs = null;
		running = true;
		finished = false;
		elInput.value = '';
		elInput.disabled = false;
		elRestart.disabled = false;
		elSaveStatus.textContent = '';
		elTime.textContent = '0.0';
		elWpm.textContent = '0';
		elAccuracy.textContent = '100';
		elErrors.textContent = '0';
		pickText();
		timerId = setInterval(tick, 100);
	}

	function markCurrent(index) {
		const spans = elTextDisplay.querySelectorAll('.ch');
		spans.forEach(s => s.classList.remove('current'));
		if (index >= 0 && index < spans.length) spans[index].classList.add('current');
	}

	function computeStats() {
		const typed = elInput.value;
		const spans = elTextDisplay.querySelectorAll('.ch');

		let correct = 0;
		let errors = 0;

		for (let i = 0; i < spans.length; i++) {
			spans[i].classList.remove('correct', 'incorrect');
		}

		for (let i = 0; i < typed.length; i++) {
			if (i >= targetText.length) {
				errors++;
				continue;
			}
			if (typed[i] === targetText[i]) {
				correct++;
				spans[i].classList.add('correct');
			} else {
				errors++;
				spans[i].classList.add('incorrect');
			}
		}

		markCurrent(typed.length);

		const elapsedSeconds = startTimeMs ? (Date.now() - startTimeMs) / 1000 : 0;
		const minutes = Math.max(elapsedSeconds / 60, 1 / 60);
		const wpm = Math.round((correct / 5) / minutes);
		const accuracy = typed.length > 0 ? Math.max(0, Math.min(100, (correct / typed.length) * 100)) : 100;

		elWpm.textContent = String(isFinite(wpm) ? wpm : 0);
		elAccuracy.textContent = accuracy.toFixed(0);
		elErrors.textContent = String(errors);

		return { correct, errors, wpm, accuracy, elapsedSeconds };
	}

	function tick() {
		if (!startTimeMs) return;
		const elapsedSeconds = (Date.now() - startTimeMs) / 1000;
		elTime.textContent = elapsedSeconds.toFixed(1);
		computeStats();

		if (elapsedSeconds >= TEST_DURATION_SECONDS) {
			finishRound("Time's up!");
		}
	}

	function startTimerIfNeeded() {
		if (startTimeMs !== null) return;
		startTimeMs = Date.now();
	}

	function finishRound(message) {
		if (finished) return;
		finished = true;
		running = false;
		elInput.disabled = true;
		if (timerId) clearInterval(timerId);

		const stats = computeStats();
		const timeSeconds = Math.max(1, Math.round(stats.elapsedSeconds || TEST_DURATION_SECONDS));
		elSaveStatus.textContent = message + ' Saving score…';
		const difficultyKey = currentDifficultyKey();

		const body = new URLSearchParams();
		body.set('difficulty_id', String(DIFFICULTIES[difficultyKey].id));
		body.set('time_seconds', String(timeSeconds));
		body.set('words_per_minute', String(stats.wpm));
		body.set('accuracy', String(stats.accuracy.toFixed(2)));

		fetch('/typing', {
			method: 'POST',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			body: body.toString(),
		})
		.then(async (res) => {
			const data = await res.json().catch(() => null);
			if (res.ok && data && data.ok) {
				elSaveStatus.textContent = message + ' Score saved.';
				return;
			}
			if (res.status === 401) {
				elSaveStatus.textContent = message + ' (Not logged in — score not saved.)';
				return;
			}
			elSaveStatus.textContent = message + ' (Could not save score.)';
		})
		.catch(() => {
			elSaveStatus.textContent = message + ' (Could not save score.)';
		});
	}

	elRestart.addEventListener('click', newRound);

	elDifficulty.addEventListener('change', () => {
		newRound();
	});

	elInput.addEventListener('input', () => {
		if (finished) return;
		if (!running) running = true;
		startTimerIfNeeded();

		computeStats();

		if (elInput.value.length >= targetText.length) {
			finishRound('Completed!');
			return;
		}

		const elapsedSeconds = (Date.now() - startTimeMs) / 1000;
		if (elapsedSeconds >= TEST_DURATION_SECONDS) {
			finishRound("Time's up!");
		}
	});

	// Default difficulty
	elDifficulty.value = 'easy';
	newRound();
})();

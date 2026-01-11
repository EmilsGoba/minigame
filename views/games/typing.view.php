<?php require "views/components/header.php"; ?>
<?php require "views/components/navbar.php"; ?>

<link rel="stylesheet" href="/css/typing.css">

<main style="padding: 20px; text-align: center;">
    <div class="typing-container" style="max-width: 900px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <h1>⌨️ Typing Speed Test</h1>
        
        <div class="stats-bar" style="display: flex; justify-content: space-around; background: #2c3e50; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <div>Difficulty: 
                <select id="difficultySelect" style="padding: 5px; border-radius: 4px;">
                    <option value="easy">Easy (50 words)</option>
                    <option value="medium" selected>Medium (100 words)</option>
                    <option value="hard">Hard (150 words)</option>
                    <option value="hardcore">Hardcore (300 words)</option>
                </select>
            </div>
            <div>WPM: <span id="wpm" style="font-weight: bold; color: #27ae60;">0</span></div>
            <div>Acc: <span id="accuracy" style="font-weight: bold;">100</span>%</div>
            <div>Time: <span id="time" style="font-weight: bold;">0.0</span>s</div>
        </div>

        <div id="textDisplay" class="text-display" style="text-align: left; font-family: 'Courier New', Courier, monospace; font-size: 1.4rem; line-height: 1.8; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background: #fdfdfd; min-height: 150px; margin-bottom: 20px; word-wrap: break-word;">
            Loading words...
        </div>
        
        <textarea id="textInput" placeholder="Start typing the text above..." spellcheck="false" style="width: 100%; height: 120px; padding: 15px; font-size: 1.1rem; border: 2px solid #2c3e50; border-radius: 8px; resize: none; outline: none; transition: border-color 0.3s;"></textarea>
        
        <div style="margin-top: 20px; display: flex; align-items: center; justify-content: center; gap: 20px;">
            <button id="restartBtn" style="background: #e67e22; color: white; border: none; padding: 10px 25px; border-radius: 5px; cursor: pointer; font-weight: bold;">Restart Game</button>
            <span id="saveStatus" style="font-weight: bold;"></span>
        </div>
    </div>
</main>

<script src="/js/typing.js"></script>

<?php require "views/components/footer.php"; ?>
document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("quiz-form");
  const submitButton = document.getElementById("quiz-submit");
  const resultDiv = document.getElementById("quiz-result");

  submitButton.addEventListener("click", function () {
      const selected = form.querySelector('input[name="quiz-choice"]:checked');

      if (!selected) {
          alert("選択肢を選んでください。");
          return;
      }

      const answerIndex = form.getAttribute("data-answer").trim(); // ← スペース除去
      const explanation = form.getAttribute("data-explanation");

      // デバッグログ出力
      console.log("選択された値:", selected.value);
      console.log("正解インデックス:", answerIndex);
      console.log("一致？", Number(selected.value) === Number(answerIndex));

      if (Number(selected.value) === Number(answerIndex)) {
          resultDiv.innerHTML = `
              <p class="text-green-600">✅ 正解です！</p>
              <p class="mt-2">${explanation}</p>
          `;
      } else {
          resultDiv.innerHTML = `<p class="text-red-600">❌ 不正解です。</p>`;
      }
  });

  const resetButton = document.getElementById("quiz-reset");

  resetButton.addEventListener("click", function () {
    const selected = form.querySelector('input[name="quiz-choice"]:checked');
    if (selected) selected.checked = false;
    resultDiv.innerHTML = "";
    submitButton.disabled = false;
  });

});


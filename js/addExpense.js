document.getElementById("expenseForm").addEventListener("submit", e => {
  e.preventDefault();

  fetch("api/add_expense.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      amount: amount.value,
      category_id: category.value,
      expense_date: expense_date.value
    })
  })
    .then(res => res.json())
    .then(data => {
      result.innerText = data.success
        ? "SAVED ✅"
        : "ERROR ❌";
    });
});

function loadData() {
  const month = document.getElementById("monthPicker").value;
  const category = document.getElementById("categoryFilter").value;

  if (!month) return alert("Please select a month");

  const [year, m] = month.split("-");

  fetch(`api/get_expense.php?year=${year}&month=${m}&category=${category}`)
    .then(res => res.json())
    .then(render)
    .catch(err => console.error(err));
}

function render(data) {
  total.innerText = `TOTAL: ${data.total.toLocaleString()} THB`;

  expenseTable.innerHTML = "";
  data.items.forEach(i => {
    expenseTable.innerHTML += `
      <tr>
        <td>${i.expense_date}</td>
        <td>${i.category}</td>
        <td>${i.amount}</td>
      </tr>`;
  });

  categorySummary.innerHTML = "";
  for (const c in data.byCategory) {
    categorySummary.innerHTML += `<li>${c}: ${data.byCategory[c]}</li>`;
  }
}

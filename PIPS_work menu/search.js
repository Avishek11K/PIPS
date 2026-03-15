

function searchItems() {
    let input = document.getElementById("search").value.toLowerCase();
    let rows = document.querySelectorAll("table tbody tr");

    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(input) ? "" : "none";
    });
}


function searchItems() {
    let input = document.getElementById("search").value.toLowerCase();
    let items = document.querySelectorAll("ul li");

    items.forEach(item => {
        item.style.display =
            item.innerText.toLowerCase().includes(input) ? "" : "none";
    });
}


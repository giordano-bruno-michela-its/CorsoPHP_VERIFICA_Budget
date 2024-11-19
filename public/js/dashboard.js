function sortTable(column, direction) {
    const startDate = document.getElementById("start_date").value;
    const endDate = document.getElementById("end_date").value;

    $.ajax({
        url: transactionsSortUrl,
        type: "GET",
        data: {
            column: column,
            direction: direction,
            start_date: startDate,
            end_date: endDate,
        },
        success: function (data) {
            $("#transactionsTable").html(data);
            document
                .getElementById("transactionsTable")
                .setAttribute("data-sort-dir", direction);
            updateSortArrows(column, direction);
        },
    });
}

function toggleSortDirection(column) {
    const currentDirection = document
        .getElementById("transactionsTable")
        .getAttribute("data-sort-dir");
    return currentDirection === "asc" ? "desc" : "asc";
}

function updateSortArrows(column, direction) {
    const arrows = document.querySelectorAll(".sort-arrow");
    arrows.forEach((arrow) => (arrow.innerHTML = "&#9650;&#9660;")); // Reset all arrows to up and down

    const arrow = document.getElementById(column + "_arrow");
    if (direction === "asc") {
        arrow.innerHTML = "&#9650;"; // Up arrow
    } else {
        arrow.innerHTML = "&#9660;"; // Down arrow
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const startDate = document.getElementById("start_date").value;
    const endDate = document.getElementById("end_date").value;

    document
        .getElementById("transactionsTable")
        .setAttribute("data-sort-dir", "desc");

    if (!startDate && !endDate) {
        sortTable('created_at', 'desc');
    }
});

function adjustDate(id, months) {
    const input = document.getElementById(id);
    let date = new Date(input.value);
    date.setMonth(date.getMonth() + months);

    const today = new Date();
    if (date > today) {
        date = today;
    }

    input.value = date.toISOString().split('T')[0] + 'T' + date.toTimeString().split(' ')[0];
    validateDates();
}

function validateDates() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');

    const startDate = new Date(startDateInput.value);
    const endDate = new Date(endDateInput.value);

    if (endDate < startDate) {
        endDateInput.value = startDateInput.value;
    }
}
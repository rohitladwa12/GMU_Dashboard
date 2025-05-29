$(document).ready(function () {
    // Function to update progress bars
    function updateProgressBars() {
        document.querySelectorAll(".progress-bar").forEach((bar) => {
            if (bar) {
                bar.style.width = bar.getAttribute("data-progress") + "%";
            }
        });
    }

    // Function to handle Edit
    function editRow(event) {
        let row = event.target.closest("tr"); // Get the parent row
        let cells = row.querySelectorAll("td:not(:last-child)"); // Exclude last column (Actions)

        // Convert table cells into input fields
        cells.forEach((cell) => {
            let input = document.createElement("input");
            input.type = "text";
            input.value = cell.innerText;
            cell.innerHTML = "";
            cell.appendChild(input);
        });

        // Change button to "Save"
        event.target.innerText = "Save";
        event.target.classList.remove("edit-btn");
        event.target.classList.add("save-btn");

        // Attach event listener to new "Save" button
        event.target.removeEventListener("click", editRow); // Remove old event
        event.target.addEventListener("click", saveRow);
    }

    // Function to handle Save
    function saveRow(event) {
        let row = event.target.closest("tr");
        let inputs = row.querySelectorAll("input");

        // Convert inputs back to normal text
        inputs.forEach((input) => {
            let td = input.parentElement;
            td.innerText = input.value;
        });

        // Change button back to "Edit"
        event.target.innerText = "✏️";
        event.target.classList.remove("save-btn");
        event.target.classList.add("edit-btn");

        // Attach event listener back to "Edit" button
        event.target.removeEventListener("click", saveRow);
        event.target.addEventListener("click", editRow);
    }

    function editRow(button) {
        let row = button.closest("tr");
        let cells = row.querySelectorAll("td:not(:last-child)");
        let tooltip = button.nextElementSibling; // Select the tooltip text

        if (button.textContent === "✏️") {
            // Switch to "Save" mode
            button.textContent = "💾"; // Change button to Save icon
            tooltip.textContent = "Save"; // Change tooltip to "Save"

            // Make all table cells editable
            cells.forEach((cell) => {
                let input = document.createElement("input");
                input.value = cell.textContent;
                cell.textContent = "";
                cell.appendChild(input);
            });
        } else {
            // Switch back to "Edit" mode
            button.textContent = "✏️"; // Change back to Edit icon
            tooltip.textContent = "Edit"; // Change tooltip to "Edit"

            // Save data and make it non-editable
            cells.forEach((cell) => {
                let input = cell.querySelector("input");
                if (input) {
                    cell.textContent = input.value;
                }
            });
        }
    }

    // Function to handle add teachers
    document.addEventListener("DOMContentLoaded", function () {
        const addTeacherBtn = document.getElementById("add-teacher-btn");
        const teacherTableBody = document.getElementById("teacherTableBody");

        if (!addTeacherBtn || !teacherTableBody) {
            console.error("Teacher table or Add button not found!");
            return;
        }

        addTeacherBtn.addEventListener("click", function () {
            // Create a new row with input fields
            const newRow = document.createElement("tr");

            newRow.innerHTML = `
                <td><input type="text" placeholder="Enter ID"></td>
                <td><input type="text" placeholder="Enter Name"></td>
                <td><input type="text" placeholder="Enter Subject"></td>
                <td><input type="text" placeholder="Enter Department"></td>
                <td><input type="text" placeholder="Enter Phone"></td>
                <td><input type="email" placeholder="Enter Email"></td>
                <td>
                    <div class="tooltip">
                        <button class="save-btn" onclick="saveTeacher(this)">💾</button>
                        <span class="tooltiptext">Save</span>
                    </div>
                    <div class="tooltip">
                        <button class="delete-btn" onclick="deleteRow(this)">🗑️</button>
                        <span class="tooltiptext">Delete</span>
                    </div>
                </td>
            `;

            teacherTableBody.appendChild(newRow);
        });
    });

    function saveTeacher(button) {
        const row = button.closest("tr");
        const inputs = row.querySelectorAll("input");

        let values = [];
        inputs.forEach((input) => {
            values.push(input.value);
        });

        // Check if all fields are filled
        if (values.some((value) => value.trim() === "")) {
            alert("Please fill all fields before saving!");
            return;
        }

        // Replace input fields with text values
        row.innerHTML = `
            <td>${values[0]}</td>
            <td>${values[1]}</td>
            <td>${values[2]}</td>
            <td>${values[3]}</td>
            <td>${values[4]}</td>
            <td>${values[5]}</td>
            <td>
                <div class="tooltip">
                    <button class="edit-btn" onclick="editRow(this)">✏️</button>
                    <span class="tooltiptext">Edit</span>
                </div>
                <div class="tooltip">
                    <button class="delete-btn" onclick="deleteRow(this)">🗑️</button>
                    <span class="tooltiptext">Delete</span>
                </div>
            </td>
        `;
    }

    function deleteRow(button) {
        // Get the modal and buttons
        const modal = document.getElementById("deleteConfirmModal");
        const confirmDelete = document.getElementById("confirmDelete");
        const cancelDelete = document.getElementById("cancelDelete");

        // Store the row to be deleted
        let rowToDelete = button.closest("tr");

        // Show the modal
        modal.style.display = "block";

        // When "OK" is clicked
        confirmDelete.onclick = function () {
            rowToDelete.remove(); // Delete the row
            modal.style.display = "none"; // Hide modal
        };

        // When "Cancel" is clicked
        cancelDelete.onclick = function () {
            modal.style.display = "none"; // Hide modal without deleting
        };

        // Close modal if clicked outside
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };
    }

    function editRow(button) {
        const row = button.closest("tr");
        const cells = row.querySelectorAll("td");

        const values = [];
        for (let i = 0; i < cells.length - 1; i++) {
            values.push(cells[i].innerText);
        }

        row.innerHTML = `
            <td><input type="text" value="${values[0]}"></td>
            <td><input type="text" value="${values[1]}"></td>
            <td><input type="text" value="${values[2]}"></td>
            <td><input type="text" value="${values[3]}"></td>
            <td><input type="text" value="${values[4]}"></td>
            <td><input type="email" value="${values[5]}"></td>
            <td>
                <div class="tooltip">
                    <button class="save-btn" onclick="saveTeacher(this)">💾</button>
                    <span class="tooltiptext">Save</span>
                </div>
                <div class="tooltip">
                    <button class="delete-btn" onclick="deleteRow(this)">🗑️</button>
                    <span class="tooltiptext">Delete</span>
                </div>
            </td>
        `;
    }

    // Handle save button click
    $(document).on("click", ".save-btn", function () {
        const row = $(this).closest("tr");
        const enquiryId = $(this).data("id");
        const rowData = {};

        // Collect data from inputs
        row.find("td:not(:last-child)").each(function () {
            const input = $(this).find("input");
            const columnName = $(this).data("column"); // Ensure data-column is set in HTML
            if (input.length && columnName) {
                rowData[columnName] = input.val();
            }
        });

        if (Object.keys(rowData).length === 0) {
            alert("No data to update.");
            return;
        }

        // Send updated data to the server
        $.ajax({
            type: "POST",
            url: "update_enquiry.php",
            data: { id: enquiryId, data: rowData },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    alert("Data stored successfully!");
                    row.find("td:not(:last-child)").each(function () {
                        const input = $(this).find("input");
                        if (input.length) {
                            $(this).text(input.val()); // Replace input with text
                        }
                    });
                    row.find(".save-btn").hide(); // Hide the "Save" button
                    row.find(".edit-btn").show(); // Show the "Edit" button by default
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                alert("An error occurred: " + status + " - " + error);
            },
        });
    });

    // Fetch updated data and reload the table
    function fetchUpdatedData() {
        $.ajax({
            type: "POST",
            url: "fetch_enquiries.php",
            dataType: "json",
            success: function (response) {
                if (response.data) {
                    const tableBody = $("#myTable tbody");
                    tableBody.empty(); // Clear existing rows
                    response.data.forEach((row) => {
                        const tableRow = `
                            <tr>
                                <td data-column="enquiry_no">${row.enquiry_no}</td>
                                <td data-column="aadhar">${row.aadhar}</td>
                                <td data-column="name">${row.name}</td>
                                <td data-column="source">${row.source}</td>
                                <td data-column="status">${row.status}</td>
                                <td data-column="admission_year">${row.admission_year}</td>
                                <td data-column="enquiry_date">${row.enquiry_date}</td>
                                <td data-column="college">${row.college}</td>
                                <td data-column="college_name">${row.college_name}</td>
                                <td data-column="programme">${row.programme}</td>
                                <td data-column="course">${row.course}</td>
                                <td data-column="discipline">${row.discipline}</td>
                                <td data-column="mobile_no">${row.mobile_no}</td>
                                <td data-column="email">${row.email}</td>
                                <td>
                                    <button class="edit-btn" data-id="${row.enquiry_no}">Edit</button>
                                    <button class="save-btn" data-id="${row.enquiry_no}" style="display:none;">Save</button>
                                    <button class="delete-btn" data-id="${row.enquiry_no}">Delete</button>
                                </td>
                            </tr>
                        `;
                        tableBody.append(tableRow);
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching data:", status, error);
            },
        });
    }

    // Call fetchUpdatedData on page load
    $(document).ready(function () {
        fetchUpdatedData();
    });

    // Initialize components if they exist
    if (typeof initializeCharts === 'function') {
        initializeCharts();
    }
    if (typeof updateProgressBars === 'function') {
        updateProgressBars();
    }
});

// Initialize Charts and DataTables
document.addEventListener('DOMContentLoaded', function() {
    // Initialize charts only after DOM is fully loaded
    setTimeout(() => {
        initializeCharts();
    }, 100);

    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            // Destroy existing charts
            Chart.helpers.each(Chart.instances, function(instance) {
                instance.destroy();
            });
            // Reinitialize charts
            initializeCharts();
        }, 250);
    });
});

function initializeCharts() {
    if (document.getElementById('universitysurveyChart')) {
        initializeUniversitySurveyChart();
    }
    if (document.getElementById('newadmissionsChart')) {
        initializeNewAdmissionsChart();
    }
    if (document.getElementById('studentresultChart')) {
        initializeStudentResultChart();
    }
    if (document.getElementById('studentperformanceChart')) {
        initializeStudentPerformanceChart();
    }
    if (document.getElementById('newChart')) {
        initializeNewChart();
    }
}

// Data tables for charts
const chartData = {
    universitySurvey: {
        labels: ['Facilities', 'Teaching', 'Research', 'Campus Life', 'Resources'],
        data: [
            { category: 'Facilities', satisfaction: 85, year: '2023' },
            { category: 'Teaching', satisfaction: 92, year: '2023' },
            { category: 'Research', satisfaction: 78, year: '2023' },
            { category: 'Campus Life', satisfaction: 88, year: '2023' },
            { category: 'Resources', satisfaction: 82, year: '2023' }
        ]
    },
    newAdmissions: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        data: [
            { month: 'Jan', admissions: 150, year: '2023' },
            { month: 'Feb', admissions: 280, year: '2023' },
            { month: 'Mar', admissions: 450, year: '2023' },
            { month: 'Apr', admissions: 620, year: '2023' },
            { month: 'May', admissions: 800, year: '2023' },
            { month: 'Jun', admissions: 950, year: '2023' }
        ]
    },
    studentResults: {
        labels: ['Distinction', 'First Class', 'Second Class', 'Third Class'],
        data: [
            { grade: 'Distinction', count: 15, percentage: '15%' },
            { grade: 'First Class', count: 45, percentage: '45%' },
            { grade: 'Second Class', count: 30, percentage: '30%' },
            { grade: 'Third Class', count: 10, percentage: '10%' }
        ]
    },
    studentPerformance: {
        labels: ['Mathematics', 'Science', 'History', 'Languages', 'Arts', 'Sports'],
        data: [
            { subject: 'Mathematics', score: 85, semester: 'Fall 2023' },
            { subject: 'Science', score: 92, semester: 'Fall 2023' },
            { subject: 'History', score: 78, semester: 'Fall 2023' },
            { subject: 'Languages', score: 88, semester: 'Fall 2023' },
            { subject: 'Arts', score: 76, semester: 'Fall 2023' },
            { subject: 'Sports', score: 82, semester: 'Fall 2023' }
        ]
    },
    researchPublications: {
        labels: ['2019', '2020', '2021', '2022', '2023'],
        data: [
            { year: '2019', publications: 45, impact_factor: 3.2 },
            { year: '2020', publications: 52, impact_factor: 3.5 },
            { year: '2021', publications: 68, impact_factor: 3.8 },
            { year: '2022', publications: 74, impact_factor: 4.1 },
            { year: '2023', publications: 90, impact_factor: 4.5 }
        ]
    }
};

// Update the options for all chart initializations
const commonChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            labels: {
                font: {
                    family: "'Poppins', sans-serif",
                    size: 12
                }
            }
        },
        tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            titleFont: {
                family: "'Poppins', sans-serif",
                size: 14
            },
            bodyFont: {
                family: "'Poppins', sans-serif",
                size: 13
            },
            padding: 12
        }
    }
};

function initializeUniversitySurveyChart() {
    const ctx = document.getElementById('universitysurveyChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.universitySurvey.labels,
            datasets: [{
                label: 'Satisfaction Rate',
                data: chartData.universitySurvey.data.map(item => item.satisfaction),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 2,
                borderRadius: 5,
                barThickness: 40
            }]
        },
        options: {
            ...commonChartOptions,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        },
                        font: {
                            size: 12,
                            family: "'Poppins', sans-serif"
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 12,
                            family: "'Poppins', sans-serif"
                        }
                    }
                }
            },
            plugins: {
                ...commonChartOptions.plugins,
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const data = chartData.universitySurvey.data[context.dataIndex];
                            return `Satisfaction: ${data.satisfaction}% (${data.year})`;
                        }
                    }
                }
            }
        }
    });
}

function initializeNewAdmissionsChart() {
    const ctx = document.getElementById('newadmissionsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.newAdmissions.labels,
            datasets: [{
                label: 'New Admissions',
                data: chartData.newAdmissions.data.map(item => item.admissions),
                fill: true,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                tension: 0.4,
                pointBackgroundColor: 'white',
                pointBorderColor: 'rgba(54, 162, 235, 1)',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            ...commonChartOptions,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        font: {
                            size: 12,
                            family: "'Poppins', sans-serif"
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 12,
                            family: "'Poppins', sans-serif"
                        }
                    }
                }
            },
            plugins: {
                ...commonChartOptions.plugins,
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const data = chartData.newAdmissions.data[context.dataIndex];
                            return `Admissions: ${data.admissions} (${data.year})`;
                        }
                    }
                }
            }
        }
    });
}

function initializeStudentResultChart() {
    const ctx = document.getElementById('studentresultChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: chartData.studentResults.labels,
            datasets: [{
                data: chartData.studentResults.data.map(item => item.count),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 2,
                hoverOffset: 10
            }]
        },
        options: {
            ...commonChartOptions,
            cutout: '70%',
            layout: {
                padding: {
                    top: 20,
                    bottom: 20,
                    left: 20,
                    right: 20
                }
            },
            plugins: {
                ...commonChartOptions.plugins,
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                }
            }
        }
    });
}

function initializeStudentPerformanceChart() {
    const ctx = document.getElementById('studentperformanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'radar',
        data: {
            labels: chartData.studentPerformance.labels,
            datasets: [{
                label: 'Average Performance',
                data: chartData.studentPerformance.data.map(item => item.score),
                backgroundColor: 'rgba(54, 162, 235, 0.3)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                pointBackgroundColor: 'white',
                pointBorderColor: 'rgba(54, 162, 235, 1)',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            ...commonChartOptions,
            scales: {
                r: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        stepSize: 20,
                        font: {
                            size: 11,
                            family: "'Poppins', sans-serif"
                        }
                    },
                    pointLabels: {
                        font: {
                            size: 12,
                            family: "'Poppins', sans-serif"
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    angleLines: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                }
            },
            plugins: {
                ...commonChartOptions.plugins,
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const data = chartData.studentPerformance.data[context.dataIndex];
                            return `${data.subject}: ${data.score}% (${data.semester})`;
                        }
                    }
                }
            }
        }
    });
}

function initializeNewChart() {
    const ctx = document.getElementById('newChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.researchPublications.labels,
            datasets: [{
                label: 'Research Publications',
                data: chartData.researchPublications.data.map(item => item.publications),
                backgroundColor: 'rgba(153, 102, 255, 0.8)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 2,
                borderRadius: 5,
                barThickness: 40
            }]
        },
        options: {
            ...commonChartOptions,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        font: {
                            size: 12,
                            family: "'Poppins', sans-serif"
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 12,
                            family: "'Poppins', sans-serif"
                        }
                    }
                }
            },
            plugins: {
                ...commonChartOptions.plugins,
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const data = chartData.researchPublications.data[context.dataIndex];
                            return `Publications: ${data.publications} (Impact Factor: ${data.impact_factor})`;
                        }
                    }
                }
            }
        }
    });
}

// Initialize DataTables
function initializeDataTables() {
    // Only initialize tables that are not the admissionTable
    if ($('#universitySurveyTable').length) {
        if ($.fn.DataTable.isDataTable('#universitySurveyTable')) {
            $('#universitySurveyTable').DataTable().destroy();
        }
        $('#universitySurveyTable').DataTable({
            data: chartData.universitySurvey.data,
            columns: [
                { data: 'category' },
                { data: 'satisfaction',
                  render: function(data) { return data + '%'; }
                },
                { data: 'year' }
            ],
            responsive: true,
            dom: 'Bfrtip',
            buttons: ['copy', 'excel', 'pdf'],
            pageLength: 5,
            order: [[1, 'desc']]
        });
    }

    // Initialize other tables with similar checks
    if ($('#admissionsTable').length) {
        if ($.fn.DataTable.isDataTable('#admissionsTable')) {
            $('#admissionsTable').DataTable().destroy();
        }
        $('#admissionsTable').DataTable({
            data: chartData.newAdmissions.data,
            columns: [
                { data: 'month' },
                { data: 'admissions' },
                { data: 'year' }
            ],
            responsive: true,
            dom: 'Bfrtip',
            buttons: ['copy', 'excel', 'pdf'],
            pageLength: 5,
            order: [[1, 'desc']]
        });
    }
}

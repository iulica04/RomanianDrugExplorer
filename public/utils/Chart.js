// Funcția pentru actualizarea URL-ului în funcție de anul selectat
function updateYearUrl() {
    var selectedYear = document.getElementById('year-select').value;

    if (selectedYear === '') {
        console.log('No year selected');
        return; // Dacă nu este selectat niciun an, nu face nimic

    }else{
    console.log('Selected year:', selectedYear);

    // Pentru fiecare tip de statistică, construiește URL-ul corect cu anul selectat

    ['confiscations', 'infractionality/gender', 'emergencies/gender', 'projects'].forEach(type => {
        var url = 'http://localhost:8080/RomanianDrugExplorer/DrugStats/' + type + '/' + selectedYear;
        console.log('Requesting data from:', url);
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                console.log('Response text:', data);
                try {
                    const jsonData = JSON.parse(data);
                    if (jsonData && jsonData.stats) {
                           if(type === 'emergencies/gender') {  
                            console.log('Apelând renderChartGenderDrug');
                            renderChartGenderDrug(jsonData.stats, jsonData.year);
                           }else if(type === 'infractionality/gender') {
                            console.log('Apelând renderChartGenderAGE');
                            renderChartGenderAge(jsonData.stats, jsonData.year);
                           }else if(type === 'confiscations/captures'){
                                renderPieChartCaptures(jsonData.stats, jsonData.year);
                            
                           }else {
                            renderStats(jsonData.stats, jsonData.year, type);
                           }
                    } else {
                        console.error('Empty response or invalid data received:', jsonData);
                    }
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    });
  }
}

var existingChart; // Variabilă globală pentru a păstra referința la chart-ul existent infractionality
var existingChartEmergency; // Variabilă globală pentru a păstra referința la chart-ul existent emergercy
var existingChartConfiscationPie; // Variabilă globală pentru a păstra referința la chart-ul existent confiscations

///SAVE PNG SI SVG
function saveChart(chartId, filename, format) {
    var chartCanvas = document.getElementById(chartId);
    
    // Verifică dacă canvas-ul există
    if (existingChart || existingChartEmergency ) {
        // Salvează ca PNG
        if (format === 'png') {
            chartCanvas.toBlob(function(blob) {
                var link = document.createElement('a');
                link.download = filename + '.png';
                link.href = URL.createObjectURL(blob);
                link.click();
            });
            showSnackbar('Chart saved as PNG.', 'info');

        }else if(format === 'svg'){

            showSnackbar('Can`t save chart as SVG.', 'error');
        }

        // Salvează ca SVG
    } else {
        console.error('Canvas element not found:', chartId);
        showSnackbar('Error saving chart: Canvas is empty or not found.', 'error');
    }
}

function savePieChart(chartId, filename, format) {
    var chartCanvas = document.getElementById(chartId);

    // Verifică dacă canvas-ul există
    if (existingChartConfiscationPie) {
        // Salvează ca PNG
        if (format === 'png') {
            chartCanvas.toBlob(function(blob) {
                var link = document.createElement('a');
                link.download = filename + '.png';
                link.href = URL.createObjectURL(blob);
                link.click();
            });
            showSnackbar('Chart saved as PNG.', 'info');

        }else if(format === 'svg'){
            showSnackbar('Can`t save chart as SVG.', 'error');
        } 
    }else {
        console.error('Canvas element not found:', chartId);
        showSnackbar('Error saving pie chart: Canvas is empty or not found.', 'error');
    }
}

// Funcția pentru actualizarea graficului în funcție de opțiunea selectată la radio buttons
function updateChart(chartType, statsType) {
    var selectedYear = document.getElementById('year-select').value;
    if (selectedYear === '') {
        return; // Dacă nu este selectat niciun an, nu face nimic
    }

    var url = 'http://localhost:8080/RomanianDrugExplorer/DrugStats/';
    if (statsType ==='infractionality' ){
        if( chartType === 'gender-age') {
        url += statsType + '/gender/' + selectedYear;
        } else if ( chartType === 'penalties-situation') {
        url += statsType + '/penalities/' + selectedYear;
    }
    } else {
        console.error('Unsupported chart type:', chartType);
        return;
    }
   console.log('Requesting data from 1 :', url);
    // Trimite cererea GET pentru tipul de statistică selectat
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            console.log('Response text:', data);
             // Verifică dacă răspunsul nu este gol
        if (data.trim().length === 0) {
            throw new Error('Empty response received');
        }
        try {
                const jsonData = JSON.parse(data);
                if (jsonData && jsonData.stats) {
                    if (chartType === 'gender-age') {
                        renderChartGenderAge(jsonData.stats, jsonData.year);
                    } else if (chartType === 'penalties-situation') {
                        renderChartPenalitiesSituation(jsonData.stats, jsonData.year);
                    } else {
                        renderStats(jsonData.stats, jsonData.year, chartType);
                    }
                } else {
                    console.error('Empty response or invalid data received:', jsonData);
                }
            } catch (error) {
                console.error('Error parsing JSON:', error);
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}
function renderChartGenderAge(stats, year) {
    var ctx = document.getElementById('infractionality-chart').getContext('2d');
    if (existingChart) {
        existingChart.destroy();
    }

    if (stats.length === 0 ) {
        ctx.canvas.height = 200;
        existingChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [''],
                datasets: [{
                    label: 'No data found',
                    data: [0],
                    backgroundColor: ['#d3d3d3']
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        display: false
                    },
                    x: {
                        display: false
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'No data found',
                        color: '#FF0000',
                        font: {
                            family: 'Arial',
                            size: 30,
                            weight: 'bold'
                        },
                        padding: {
                            top: 10,
                            bottom: 30
                        }
                    },
                    legend: {
                        display: false
                    }
                }
            }
        });
        return;
    }

    var chartData = {
        labels: ["Male - Major", "Male - Minor", "Female - Major", "Female - Minor"],
        datasets: [{
            label: 'Number of Cases',
            backgroundColor: ["#007bff", "#87cefa", "#ff69b4", "#ffb6c1"],
            borderColor: ["#0056b3", "#6495ed", "#ff1493", "#ffa07a"],
            borderWidth: 1,
            data: [0, 0, 0, 0]
        }]
    };

    stats.forEach(stat => {
        if (stat.subcategory === 'Barbati' && stat.type === 'Majori') {
            chartData.datasets[0].data[0] = stat.value;
        } else if (stat.subcategory === 'Barbati' && stat.type === 'Minori') {
            chartData.datasets[0].data[1] = stat.value;
        } else if (stat.subcategory === 'Femei' && stat.type === 'Majori') {
            chartData.datasets[0].data[2] = stat.value;
        } else if (stat.subcategory === 'Femei' && stat.type === 'Minori') {
            chartData.datasets[0].data[3] = stat.value;
        }
    });

    ctx.canvas.height = 200;
    existingChart = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: "rgba(0, 0, 0, 0.1)",
                        borderDash: [2, 2]
                    },
                    title: {
                        display: true,
                        text: 'Number of Cases',
                        color: '#333',
                        font: {
                            family: 'Arial',
                            size: 14,
                            weight: 'bold'
                        }
                    }
                },
                x: {
                    grid: {
                        color: "rgba(0, 0, 0, 0.1)",
                        borderDash: [2, 2]
                    },
                    title: {
                        display: true,
                        text: 'Category',
                        color: '#333',
                        font: {
                            family: 'Arial',
                            size: 14,
                            weight: 'bold'
                        }
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Drug Related Infractionality by Gender and Age (' + year + ')',
                    color: '#000',
                    font: {
                        family: 'Arial',
                        size: 18,
                        weight: 'bold'
                    },
                    padding: {
                        top: 10,
                        bottom: 30
                    }
                },
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: '#000',
                        font: {
                            family: 'Arial',
                            size: 12,
                            weight: 'bold'
                        },
                        padding: 20
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleFont: {
                        family: 'Arial',
                        size: 14,
                        weight: 'bold',
                        color: '#fff'
                    },
                    bodyFont: {
                        family: 'Arial',
                        size: 12,
                        color: '#fff'
                    },
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    });
}
// Funcția pentru afișarea statisticilor de stare si numar
function renderChartPenalitiesSituation(stats, year) {

    var ctx = document.getElementById('infractionality-chart').getContext('2d');
    if (existingChart) {
        existingChart.destroy();
    }

    if (stats.length === 0 ) {
        ctx.canvas.height = 200;
        existingChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [''],
                datasets: [{
                    label: 'No data found',
                    data: [0],
                    backgroundColor: ['#d3d3d3']
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        display: false
                    },
                    x: {
                        display: false
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'No data found',
                        color: '#FF0000',
                        font: {
                            family: 'Arial',
                            size: 30,
                            weight: 'bold'
                        },
                        padding: {
                            top: 10,
                            bottom: 30
                        }
                    },
                    legend: {
                        display: false
                    }
                }
            }
        });
        return;
    }

    var chartData = {
        labels: ["Persoane cercetate", "Persoane trimise în judecată", "Persoane condamnate"],
        datasets: [{
            label: 'Number of Cases',
            backgroundColor: ["#007bff", "#87cefa", "#ff69b4"],
            borderColor: ["#0056b3", "#6495ed", "#ff1493"],
            borderWidth: 1,
            data: [0, 0, 0]
        }]
    };

    stats.forEach(stat => {
        if (stat.subcategory === 'Persoane cercetate' ) {
            chartData.datasets[0].data[0] = stat.value;
        } else if (stat.subcategory === 'Persoane trimise in judecata' ) {
            chartData.datasets[0].data[1] = stat.value;
        } else if (stat.subcategory === 'Persoane condamnate' ) {
            chartData.datasets[0].data[2] = stat.value;
        } 
    });

    ctx.canvas.height = 200;
    existingChart = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: "rgba(0, 0, 0, 0.1)",
                        borderDash: [2, 2],
                    },
                    title: {
                        display: true,
                        text: 'Number of Cases',
                        color: '#333',
                        font: {
                            family: 'Arial',
                            size: 14,
                            weight: 'bold',
                        },
                    }
                },
                x: {
                    grid: {
                        color: "rgba(0, 0, 0, 0.1)",
                        borderDash: [2, 2],
                    },
                    title: {
                        display: true,
                        text: 'Category',
                        color: '#333',
                        font: {
                            family: 'Arial',
                            size: 14,
                            weight: 'bold',
                        },
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Drug Related Infractionality by Penalties and Situation (' + year + ')',
                    color: '#000',
                    font: {
                        family: 'Arial',
                        size: 18,
                        weight: 'bold',
                    },
                    padding: {
                        top: 10,
                        bottom: 30
                    },
                },
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: '#000',
                        font: {
                            family: 'Arial',
                            size: 12,
                            weight: 'bold',
                        },
                        padding: 20,
                    },
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleFont: {
                        family: 'Arial',
                        size: 14,
                        weight: 'bold',
                        color: '#fff',
                    },
                    bodyFont: {
                        family: 'Arial',
                        size: 12,
                        color: '#fff',
                    },
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    });
}

 ////////////////////PENTRU EMRGENCIES
 // Funcția pentru actualizarea graficului în funcție de opțiunea selectată la radio buttons
 function updateChartEmergencies(chartType, statsType) {
    var selectedYear = document.getElementById('year-select').value;
    if (selectedYear === '') {
        return; // Dacă nu este selectat niciun an, nu face nimic
    }

    var url = 'http://localhost:8080/RomanianDrugExplorer/DrugStats/';
    if (statsType ==='emergencies'){
          if(chartType === 'age-drug') {
          url += statsType + '/age/' + selectedYear;
          } else if (chartType === 'gender-drug') {
           url += statsType + '/gender/' + selectedYear;
           } else if ( chartType === 'emergencie-drug-canabis' || chartType === 'emergencie-drug-stimulanti' || chartType === 'emergencie-drug-opiacee' || chartType === 'emergencie-drug-NSP') {
             url += statsType + '/emergency/' + selectedYear;
            }
    } else {
        console.error('Unsupported chart type:', chartType);
        return;
    }
   console.log('Requesting data from 1 :', url);
    // Trimite cererea GET pentru tipul de statistică selectat
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            console.log('Response text:', data);
             // Verifică dacă răspunsul nu este gol
        if (data.trim().length === 0) {
            throw new Error('Empty response received');
        }
        try {
                const jsonData = JSON.parse(data);
                if (jsonData && jsonData.stats) {
                   if (chartType === 'age-drug') {
                        renderChartAgeDrug(jsonData.stats, jsonData.year);
                    }else if (chartType === 'gender-drug') {
                       
                        renderChartGenderDrug(jsonData.stats, jsonData.year);
                    }else if (chartType === 'emergencie-drug-stimulanti' ||chartType === 'emergencie-drug-canabis' || chartType === 'emergencie-drug-opiacee' || chartType === 'emergencie-drug-NSP') {
                        let parts = chartType.split('-');
                        let type = parts[parts.length - 1];
                        console.log('Type:', type);
                        renderChartEmergencyDrug(jsonData.stats, jsonData.year, type);
                    }else {
                        renderStats(jsonData.stats, jsonData.year, chartType);
                    }
                } else {
                    console.error('Empty response or invalid data received:', jsonData);
                }
            } catch (error) {
                console.error('Error parsing JSON:', error);
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}
// Functia pentru afisarea statisticilor de gen si droguri
function renderChartGenderDrug(stats, year) {
    var ctx = document.getElementById('emergencies-chart').getContext('2d');

    if (existingChartEmergency) {
        existingChartEmergency.destroy();
    }
    if (stats.length === 0 ) {
        ctx.canvas.height = 200;
        existingChartEmergency = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [''],
                datasets: [{
                    label: 'No data found',
                    data: [0],
                    backgroundColor: ['#d3d3d3']
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        display: false
                    },
                    x: {
                        display: false
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'No data found',
                        color: '#FF0000',
                        font: {
                            family: 'Arial',
                            size: 30,
                            weight: 'bold'
                        },
                        padding: {
                            top: 10,
                            bottom: 30
                        }
                    },
                    legend: {
                        display: false
                    }
                }
            }
        });
        return;
    }



    var chartData = {
        labels: ["M-Canabis", "M-Stimulanti", "M-Opiacee", "M-NSP", "F-Canabis", "F-Stimulanti", "F-Opiacee", "F-NSP"],
        datasets: [{
            label: 'Number of Cases',
            backgroundColor: ["#007bff", "#87cefa", "#26c4ec", "#73cde3", "#ff69b4", "#ffb6c1", "#fd3f92", "#e11b72"],
            borderColor: ["#0056b3", "#6495ed", "#1a99c4", "#58b6c3", "#ff458a", "#ff99b3", "#e02c6d", "#b8135b"],
            borderWidth: 1,
            data: [0, 0, 0, 0, 0, 0, 0, 0]
        }]
    };

    console.log('AICI Chart data before processing:', chartData);
    stats.forEach(stat => {
        if (stat.drug_type === 'Canabis' && stat.subcategory === 'Feminin') {
            chartData.datasets[0].data[4] = stat.cases;
        } else if (stat.drug_type === 'Canabis' && stat.subcategory === 'Masculin') {
            chartData.datasets[0].data[0] = stat.cases;
        } else if (stat.drug_type === 'Stimulanti' && stat.subcategory === 'Feminin') {
            chartData.datasets[0].data[5] = stat.cases;
        } else if (stat.drug_type === 'Stimulanti' && stat.subcategory === 'Masculin') {
            chartData.datasets[0].data[1] = stat.cases;
        } else if (stat.drug_type === 'Opiacee' && stat.subcategory === 'Feminin') {
            chartData.datasets[0].data[6] = stat.cases;
        } else if (stat.drug_type === 'Opiacee' && stat.subcategory === 'Masculin') {
            chartData.datasets[0].data[2] = stat.cases;
        } else if (stat.drug_type === 'NSP' && stat.subcategory === 'Feminin') {
            chartData.datasets[0].data[7] = stat.cases;
        } else if (stat.drug_type === 'NSP' && stat.subcategory === 'Masculin') {
            chartData.datasets[0].data[3] = stat.cases;
        }
    });


    ctx.canvas.height = 200; // Set the canvas height
    existingChartEmergency = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: "rgba(0, 0, 0, 0.1)",
                        borderDash: [2, 2],
                    },
                    title: {
                        display: true,
                        text: 'Number of Cases',
                        color: '#333',
                        font: {
                            family: 'Arial',
                            size: 14,
                            weight: 'bold',
                        },
                    }
                },
                x: {
                    grid: {
                        color: "rgba(0, 0, 0, 0.1)",
                        borderDash: [2, 2],
                    },
                    title: {
                        display: true,
                        text: 'Category',
                        color: '#333',
                        font: {
                            family: 'Arial',
                            size: 14,
                            weight: 'bold',
                        },
                    }
                }
            },
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Drug Related Emergencies by Gender and Drugs (' + year + ')',
                    color: '#000',
                    font: {
                        family: 'Arial',
                        size: 18,
                        weight: 'bold',
                    },
                    padding: {
                        top: 10,
                        bottom: 30
                    },
                },
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: '#000',
                        font: {
                            family: 'Arial',
                            size: 12,
                            weight: 'bold',
                        },
                        padding: 20,
                    },
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleFont: {
                        family: 'Arial',
                        size: 14,
                        weight: 'bold',
                        color: '#fff',
                    },
                    bodyFont: {
                        family: 'Arial',
                        size: 12,
                        color: '#fff',
                    },
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    });
}
// Functia pentru afisarea statisticilor de varsta și drog
function renderChartAgeDrug(stats, year) {
    var ctx = document.getElementById('emergencies-chart').getContext('2d');

    if (existingChartEmergency) {
        existingChartEmergency.destroy();
    }

    if (stats.length === 0 ) {
        ctx.canvas.height = 200;
        existingChartEmergency = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [''],
                datasets: [{
                    label: 'No data found',
                    data: [0],
                    backgroundColor: ['#d3d3d3']
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        display: false
                    },
                    x: {
                        display: false
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'No data found',
                        color: '#FF0000',
                        font: {
                            family: 'Arial',
                            size: 30,
                            weight: 'bold'
                        },
                        padding: {
                            top: 10,
                            bottom: 30
                        }
                    },
                    legend: {
                        display: false
                    }
                }
            }
        });
        return;
    }


    var chartData = {
        labels: ["(<25)-Canabis", "(25-34)-Canabis", "(>35)-Canabis", "(<25)-Stimulanti", "(25-34)-Stimulanti", "(>35)-Stimulanti", "(<25)-Opiacee", "(25-34)-Opiacee", "(>35)-Opiacee", "(<25)-NSP", "(25-34)-NSP", "(>35)-NSP"],
        datasets: [{
            label: 'Number of Cases',
            backgroundColor: ["#007bff", "#87cefa", "#ff69b4", "#ffb6c1", "#7bff00", "#cefa87", "#69b4ff", "#b6c1ff", "#ff8c00", "#ffd700", "#32cd32", "#8b0000"], // Custom colors
            borderColor: ["#0056b3", "#6495ed", "#ff1493", "#ffa07a", "#5f9ea0", "#98fb98", "#4682b4", "#dda0dd", "#cd853f", "#ffc0cb", "#7fff00", "#ff4500"], // Custom border colors
            borderWidth: 1, // Border width
            data: Array(12).fill(0) // Initialize with zero for each category
        }]
    };

    stats.forEach(stat => {
        if (stat.drug_type === 'Canabis') {
            if (stat.subcategory === '<25') chartData.datasets[0].data[0] = stat.cases;
            else if (stat.subcategory === '25-34') chartData.datasets[0].data[1] = stat.cases;
            else if (stat.subcategory === '>35') chartData.datasets[0].data[2] = stat.cases;
        } else if (stat.drug_type === 'Stimulanti') {
            if (stat.subcategory === '<25') chartData.datasets[0].data[3] = stat.cases;
            else if (stat.subcategory === '25-34') chartData.datasets[0].data[4] = stat.cases;
            else if (stat.subcategory === '>35') chartData.datasets[0].data[5] = stat.cases;
        } else if (stat.drug_type === 'Opiacee') {
            if (stat.subcategory === '<25') chartData.datasets[0].data[6] = stat.cases;
            else if (stat.subcategory === '25-34') chartData.datasets[0].data[7] = stat.cases;
            else if (stat.subcategory === '>35') chartData.datasets[0].data[8] = stat.cases;
        } else if (stat.drug_type === 'NSP') {
            if (stat.subcategory === '<25') chartData.datasets[0].data[9] = stat.cases;
            else if (stat.subcategory === '25-34') chartData.datasets[0].data[10] = stat.cases;
            else if (stat.subcategory === '>35') chartData.datasets[0].data[11] = stat.cases;
        }
    });

    ctx.canvas.height = 200; // Canvas height

    existingChartEmergency = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: "rgba(0, 0, 0, 0.1)", // Grid color
                        borderDash: [2, 2], // Dashed grid lines
                    },
                    title: {
                        display: true,
                        text: 'Number of Cases',
                        color: '#333', // Text color
                        font: {
                            family: 'Arial',
                            size: 14,
                            weight: 'bold',
                        },
                    }
                },
                x: {
                    grid: {
                        color: "rgba(0, 0, 0, 0.1)",
                        borderDash: [2, 2],
                    },
                    title: {
                        display: true,
                        text: 'Category',
                        color: '#333',
                        font: {
                            family: 'Arial',
                            size: 14,
                            weight: 'bold',
                        },
                    }
                }
            },
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Drug Related Emergencies by Age and Drugs (' + year + ')',
                    color: '#000', // Title color
                    font: {
                        family: 'Arial',
                        size: 18,
                        weight: 'bold',
                    },
                    padding: {
                        top: 10,
                        bottom: 30
                    },
                },
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: '#000',
                        font: {
                            family: 'Arial',
                            size: 12,
                            weight: 'bold',
                        },
                        padding: 20,
                    },
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleFont: {
                        family: 'Arial',
                        size: 14,
                        weight: 'bold',
                        color: '#fff',
                    },
                    bodyFont: {
                        family: 'Arial',
                        size: 12,
                        color: '#fff',
                    },
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    });
}
//Functia pentru afisarea statisticilor de urgente medicale si droguri
function renderChartEmergencyDrug(stats, year, type) {

    var ctx = document.getElementById('emergencies-chart').getContext('2d');

    if (existingChartEmergency) {
        existingChartEmergency.destroy();
    }
    if (stats.length === 0 ) {
        ctx.canvas.height = 200;
        existingChartEmergency = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [''],
                datasets: [{
                    label: 'No data found',
                    data: [0],
                    backgroundColor: ['#d3d3d3']
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        display: false
                    },
                    x: {
                        display: false
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'No data found',
                        color: '#FF0000',
                        font: {
                            family: 'Arial',
                            size: 30,
                            weight: 'bold'
                        },
                        padding: {
                            top: 10,
                            bottom: 30
                        }
                    },
                    legend: {
                        display: false
                    }
                }
            }
        });
        return;
    }

    var chartData = {
        labels: ["Intoxicație", "Utilizare nocivă", "Dependență", "Sevraj", "Tulburări de comportament", "Supradoză", "Alte diagnostice", "Testare toxicologică"],
        datasets: [{
            label: 'Number of Cases',
            backgroundColor: ["#007bff", "#87cefa", "#ff69b4", "#ffb6c1", "#7bff00", "#cefa87", "#ff8c00", "#ffd700"], // Custom colors
            borderColor: ["#0056b3", "#6495ed", "#ff1493", "#ffa07a", "#5f9ea0", "#98fb98", "#cd853f", "#ffc0cb"], // Custom border colors
            borderWidth: 1, // Border width
            data: Array(8).fill(0) // Initialize with zero for each category
        }]
    };

    stats.forEach(stat => {
        if(type === 'stimulanti') {
        if(stat.drug_type === 'Stimulanti') {
        if (stat.subcategory === 'Intoxicatie') {
            chartData.datasets[0].data[0] = stat.cases;
        } else if (stat.subcategory  === 'Utilizare nociva') {
            chartData.datasets[0].data[1] = stat.cases;
        } else if (stat.subcategory  === 'Dependenta') {
            chartData.datasets[0].data[2] = stat.cases;
        } else if (stat.subcategory  === 'Sevraj') {
            chartData.datasets[0].data[3] =stat.cases;
        } else if (stat.subcategory  === 'Tulburari de comportament') {
            chartData.datasets[0].data[4] = stat.cases;
        } else if (stat.subcategory  === 'Supradoaza') {
            chartData.datasets[0].data[5] = stat.cases;
        } else if (stat.subcategory  === 'Alte diagnostice') {
            chartData.datasets[0].data[6] = stat.cases;
        } else if (stat.subcategory  === 'Testare toxicologica') {
            chartData.datasets[0].data[7] = stat.cases;
        }
       }
    }else if(type === 'canabis'){
        if(stat.drug_type === 'Canabis') {
            if (stat.subcategory === 'Intoxicatie') {
                chartData.datasets[0].data[0] = stat.cases;
            } else if (stat.subcategory  === 'Utilizare nociva') {
                chartData.datasets[0].data[1] = stat.cases;
            } else if (stat.subcategory  === 'Dependenta') {
                chartData.datasets[0].data[2] = stat.cases;
            } else if (stat.subcategory  === 'Sevraj') {
                chartData.datasets[0].data[3] =stat.cases;
            } else if (stat.subcategory  === 'Tulburari de comportament') {
                chartData.datasets[0].data[4] = stat.cases;
            } else if (stat.subcategory  === 'Supradoaza') {
                chartData.datasets[0].data[5] = stat.cases;
            } else if (stat.subcategory  === 'Alte diagnostice') {
                chartData.datasets[0].data[6] = stat.cases;
            } else if (stat.subcategory  === 'Testare toxicologica') {
                chartData.datasets[0].data[7] = stat.cases;
            }
           }
       }else if(type === 'opiacee'){
        if(stat.drug_type === 'Opiacee') {
            if (stat.subcategory === 'Intoxicatie') {
                chartData.datasets[0].data[0] = stat.cases;
            } else if (stat.subcategory  === 'Utilizare nociva') {
                chartData.datasets[0].data[1] = stat.cases;
            } else if (stat.subcategory  === 'Dependenta') {
                chartData.datasets[0].data[2] = stat.cases;
            } else if (stat.subcategory  === 'Sevraj') {
                chartData.datasets[0].data[3] =stat.cases;
            } else if (stat.subcategory  === 'Tulburari de comportament') {
                chartData.datasets[0].data[4] = stat.cases;
            } else if (stat.subcategory  === 'Supradoaza') {
                chartData.datasets[0].data[5] = stat.cases;
            } else if (stat.subcategory  === 'Alte diagnostice') {
                chartData.datasets[0].data[6] = stat.cases;
            } else if (stat.subcategory  === 'Testare toxicologica') {
                chartData.datasets[0].data[7] = stat.cases;
            }
           }
       }else if(type === 'NSP'){
        if(stat.drug_type === 'NSP') {
            if (stat.subcategory === 'Intoxicatie') {
                chartData.datasets[0].data[0] = stat.cases;
            } else if (stat.subcategory  === 'Utilizare nociva') {
                chartData.datasets[0].data[1] = stat.cases;
            } else if (stat.subcategory  === 'Dependenta') {
                chartData.datasets[0].data[2] = stat.cases;
            } else if (stat.subcategory  === 'Sevraj') {
                chartData.datasets[0].data[3] =stat.cases;
            } else if (stat.subcategory  === 'Tulburari de comportament') {
                chartData.datasets[0].data[4] = stat.cases;
            } else if (stat.subcategory  === 'Supradoaza') {
                chartData.datasets[0].data[5] = stat.cases;
            } else if (stat.subcategory  === 'Alte diagnostice') {
                chartData.datasets[0].data[6] = stat.cases;
            } else if (stat.subcategory  === 'Testare toxicologica') {
                chartData.datasets[0].data[7] = stat.cases;
            }
           }
       }
     });


    ctx.canvas.height = 200; // Canvas height

    existingChartEmergency = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: "rgba(0, 0, 0, 0.1)", // Grid color
                        borderDash: [5, 5], // Dashed grid lines
                    },
                    title: {
                        display: true,
                        text: 'Number of Cases',
                        color: '#333', // Text color
                        font: {
                            family: 'Arial',
                            size: 14,
                            weight: 'bold',
                        },
                    }
                },
                x: {
                    grid: {
                        color: "rgba(0, 0, 0, 0.1)",
                        borderDash: [5, 5],
                    },
                    title: {
                        display: true,
                        text: 'Category',
                        color: '#333',
                        font: {
                            family: 'Arial',
                            size: 14,
                            weight: 'bold',
                        },
                    }
                }
            },
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Drug Related Emergencies by '+ type +' (' + year + ')',
                    color: '#000', // Title color
                    font: {
                        family: 'Arial',
                        size: 18,
                        weight: 'bold',
                    },
                    padding: {
                        top: 10,
                        bottom: 30
                    },
                },
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: '#000',
                        font: {
                            family: 'Arial',
                            size: 12,
                            weight: 'bold',
                        },
                        padding: 20,
                    },
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleFont: {
                        family: 'Arial',
                        size: 14,
                        weight: 'bold',
                        color: '#fff',
                    },
                    bodyFont: {
                        family: 'Arial',
                        size: 12,
                        color: '#fff',
                    },
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    });
}

//////////////////////PENTRU CONFISCATIONS
function updateChartPie(chartType, statsType) {
    var selectedYear = document.getElementById('year-select').value;
    if (selectedYear === '') {
        return; // Dacă nu este selectat niciun an, nu face nimic
    }

    var url = 'http://localhost:8080/RomanianDrugExplorer/DrugStats/';
    if (statsType ==='confiscations' ){
        if( chartType === 'drug-captures') {
        url += statsType + '/captures/' + selectedYear;
        } else if ( chartType === 'drug-grams') {
        url += statsType + '/grams/' + selectedYear;
       }else if ( chartType === 'drug-tablets') {
        url += statsType + '/tablets/' + selectedYear;
        }
    } else {
        console.error('Unsupported chart type:', chartType);
        return;
    }
   console.log('Requesting data from 1 :', url);
    // Trimite cererea GET pentru tipul de statistică selectat
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            console.log('Response text:', data);
             // Verifică dacă răspunsul nu este gol
        if (data.trim().length === 0) {
            throw new Error('Empty response received');
        }
        try {
                const jsonData = JSON.parse(data);
                if (jsonData && jsonData.stats) {
                    if (chartType === 'drug-captures') {
                        renderPieChartCaptures(jsonData.stats, jsonData.year);
                    } else if (chartType === 'drug-grams') {
                        renderPieChartGrams(jsonData.stats, jsonData.year);
                    } else if (chartType === 'drug-tablets') {
                        renderPieChartTablets(jsonData.stats, jsonData.year);
                    }
                } else {
                    console.error('Empty response or invalid data received:', jsonData);
                }
            } catch (error) {
                console.error('Error parsing JSON:', error);
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}

function renderPieChartCaptures(stats, year) {
    var ctx = document.getElementById('confiscations-chartpie').getContext('2d');

    if (existingChartConfiscationPie) {
        existingChartConfiscationPie.destroy();
    }

    if (stats.length === 0 ) {
        ctx.canvas.height = 200;
        existingChartConfiscationPie = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [''],
                datasets: [{
                    label: 'No data found',
                    data: [0],
                    backgroundColor: ['#d3d3d3']
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        display: false
                    },
                    x: {
                        display: false
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'No data found',
                        color: '#FF0000',
                        font: {
                            family: 'Arial',
                            size: 30,
                            weight: 'bold'
                        },
                        padding: {
                            top: 10,
                            bottom: 30
                        }
                    },
                    legend: {
                        display: false
                    }
                }
            }
        });
        return;
    }


    var labels = stats.map(stat => stat.drug_name); // Utilizăm numele drogurilor pentru etichetele graficului
    var values = stats.map(stat => stat.catches); // Utilizăm numărul de capturi pentru valorile graficului
    var colors = ['#b91d47','#00aba9','#2b5797','#e8c3b9','#1e7145','#007bff', '#28a745', '#dc3545']; // Culorile pentru fiecare sectiune, poti ajusta la preferinta ta

    var pieChartData = {
        labels: labels,
        values: values,
        colors: colors
    };

    
    existingChartConfiscationPie = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: pieChartData.labels,
            datasets: [{
                label: 'Number of Captures', // Titlul pentru dataset
                data: pieChartData.values,
                backgroundColor: pieChartData.colors,
                borderWidth: 1,
                size: 700
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Drug Confiscation Statistics By Catches(' + year + ')', // Titlul graficului cu anul curent
                    font: {
                        size: 18
                    }
                },
                legend: {
                    display: false,
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return `${tooltipItem.label}: ${tooltipItem.raw}`;
                        }
                    }
                }
            }
        }
    });
}
function renderPieChartGrams(stats, year) {

    var ctx = document.getElementById('confiscations-chartpie').getContext('2d');

    if (existingChartConfiscationPie) {
        existingChartConfiscationPie.destroy();
    }

    if (stats.length === 0 ) {
        ctx.canvas.height = 200;
        existingChartConfiscationPie = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [''],
                datasets: [{
                    label: 'No data found',
                    data: [0],
                    backgroundColor: ['#d3d3d3']
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        display: false
                    },
                    x: {
                        display: false
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'No data found',
                        color: '#FF0000',
                        font: {
                            family: 'Arial',
                            size: 30,
                            weight: 'bold'
                        },
                        padding: {
                            top: 10,
                            bottom: 30
                        }
                    },
                    legend: {
                        display: false
                    }
                }
            }
        });
        return;
    }

    var labels = stats.map(stat => stat.drug_name); // Utilizăm numele drogurilor pentru etichetele graficului
    var values = stats.map(stat => stat.grams); // Utilizăm numărul de capturi pentru valorile graficului
    var colors = ['#b91d47','#00aba9','#2b5797','#e8c3b9','#1e7145','#007bff', '#28a745', '#dc3545']; // Culorile pentru fiecare sectiune, poti ajusta la preferinta ta

    var pieChartData = {
        labels: labels,
        values: values,
        colors: colors
    };

    existingChartConfiscationPie = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: pieChartData.labels,
            datasets: [{
                label: 'Number of Captures', // Titlul pentru dataset
                data: pieChartData.values,
                backgroundColor: pieChartData.colors,
                borderWidth: 1,
                size: 700
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Drug Confiscation Statistics By Grams(' + year + ')', // Titlul graficului cu anul curent
                    font: {
                        size: 18
                    }
                },
                legend: {
                    display: false,
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return `${tooltipItem.label}: ${tooltipItem.raw}`;
                        }
                    }
                }
            }
        }
    });
    
}
function renderPieChartTablets(stats, year) {

    var ctx = document.getElementById('confiscations-chartpie').getContext('2d');

    if (existingChartConfiscationPie) {
        existingChartConfiscationPie.destroy();
    }

    if (stats.length === 0 ) {
        ctx.canvas.height = 200;
        existingChartConfiscationPie = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [''],
                datasets: [{
                    label: 'No data found',
                    data: [0],
                    backgroundColor: ['#d3d3d3']
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        display: false
                    },
                    x: {
                        display: false
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'No data found',
                        color: '#FF0000',
                        font: {
                            family: 'Arial',
                            size: 30,
                            weight: 'bold'
                        },
                        padding: {
                            top: 10,
                            bottom: 30
                        }
                    },
                    legend: {
                        display: false
                    }
                }
            }
        });
        return;
    }

    var labels = stats.map(stat => stat.drug_name); // Utilizăm numele drogurilor pentru etichetele graficului
    var values = stats.map(stat => stat.grams); // Utilizăm numărul de capturi pentru valorile graficului
    var colors = ['#b91d47','#00aba9','#2b5797','#e8c3b9','#1e7145','#007bff', '#28a745', '#dc3545']; // Culorile pentru fiecare sectiune, poti ajusta la preferinta ta

    var pieChartData = {
        labels: labels,
        values: values,
        colors: colors
    };

    
    existingChartConfiscationPie = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: pieChartData.labels,
            datasets: [{
                label: 'Number of Captures', // Titlul pentru dataset
                data: pieChartData.values,
                backgroundColor: pieChartData.colors,
                borderWidth: 1,
                size: 700
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Drug Confiscation Statistics By Tablets (' + year + ')', // Titlul graficului cu anul curent
                    font: {
                        size: 18
                    }
                },
                legend: {
                    display: false,
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return `${tooltipItem.label}: ${tooltipItem.raw}`;
                        }
                    }
                }
            }
        }
    });

   
}




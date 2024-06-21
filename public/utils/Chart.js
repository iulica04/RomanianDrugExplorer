// Funcția pentru actualizarea URL-ului în funcție de anul selectat
function updateYearUrl() {
    var selectedYear = document.getElementById('year-select').value;
    if (selectedYear === '') {
        return; // Dacă nu este selectat niciun an, nu face nimic
    }
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
                      
                            renderChartGenderAge(jsonData.stats, jsonData.year);
                            renderChartGenderDrug(jsonData.stats, jsonData.year);
                            renderStats(jsonData.stats, jsonData.year, type);
                        
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

var existingChart; // Variabilă globală pentru a păstra referința la chart-ul existent infractionality
var existingChartEmergency; // Variabilă globală pentru a păstra referința la chart-ul existent emergercy

///SAVE PNG SI SVG
// Funcția pentru a salva chart-ul ca PNG sau SVG
function saveChart(chartId, filename, format) {
    var chartCanvas = document.getElementById(chartId);
    

    // Verifică dacă canvas-ul există
    if (existingChart) {
        // Salvează ca PNG
        if (format === 'png') {
            chartCanvas.toBlob(function(blob) {
                var link = document.createElement('a');
                link.download = filename + '.png';
                link.href = URL.createObjectURL(blob);
                link.click();
            });
            showSnackbar('Chart saved as PNG.', 'info');
        }
        // Salvează ca SVG
        else if (format === 'svg') {
            var chartCanvas = document.getElementById(chartId);
            var svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            svg.setAttribute('width', chartCanvas.width);
            svg.setAttribute('height', chartCanvas.height);
        
            // Clonează canvas-ul în SVG
            var svgRect = chartCanvas.cloneNode(true);
            svg.appendChild(svgRect);
        
            // Serializează SVG
            var serializer = new XMLSerializer();
            var svgString = serializer.serializeToString(svg);
        
            // Crează un link pentru descărcare
            var link = document.createElement('a');
            link.download = filename + '.svg';
            link.href = 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(svgString);
            link.click();
        } else {
            console.error('Unsupported format:', format);
        }
    } else {
        console.error('Canvas element not found:', chartId);
        showSnackbar('Error saving chart: Canvas is empty or not found.', 'error');
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
    var chartData = {
        labels: ["Male - Major", "Male - Minor", "Female - Major", "Female - Minor"],
        datasets: [{
            label: 'Number of Cases',
            backgroundColor: ["#007bff", "#87cefa", "#ff69b4", "#ffb6c1"], // Culori personalizate
            borderColor: ["#0056b3", "#6495ed", "#ff1493", "#ffa07a"], // Culori de border personalizate
            borderWidth: 1, // Grosimea borderului
            
            innerHeight: 300, // Înălțimea interioară a barelor
            outerHeight: 300, // Înălțimea exterioară a barelor
            data: [0, 0, 0, 0] // Inițializare cu zero pentru fiecare categorie
        }]
    };

    stats.forEach(stat => {
        if (stat.gen === 'barbati' && stat.varsta === 'majori') {
            chartData.datasets[0].data[0] = stat.numar;
        } else if (stat.gen === 'barbati' && stat.varsta === 'minori') {
            chartData.datasets[0].data[1] = stat.numar;
        } else if (stat.gen === 'femei' && stat.varsta === 'majori') {
            chartData.datasets[0].data[2] = stat.numar;
        } else if (stat.gen === 'femei' && stat.varsta === 'minori') {
            chartData.datasets[0].data[3] = stat.numar;
        }
    });

    var ctx = document.getElementById('infractionality-chart').getContext('2d');
   // ctx.canvas.height = 350; // Înălțimea canvas-ului
    //ctx.canvas.backgroundColor = '#f8f9fa'; // Culoarea de fundal a canvas-ului
    // Distruge chart-ul existent dacă există
    if (existingChart) {
        existingChart.destroy();
    }
    
     ctx.canvas.height = 200; // Înălțimea canvas-ului
    //ctx.canvas.backgroundColor = '#f8f9fa'; // Culoarea de fundal a canvas-ului

    existingChart = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: "rgba(0, 0, 0, 0.1)", // Culoarea grilajului
                        borderDash: [2, 2], // Linie întreruptă pentru grilaj
                    },
                    title: {
                        display: true,
                        text: 'Number of Cases',
                        color: '#333', // Culoarea textului
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
                    text: 'Drug Related Infractionality by Gender and Age (' + year + ')',
                    color: '#000', // Culoarea titlului
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
// Funcția pentru afișarea statisticilor de stare si numar
function renderChartPenalitiesSituation(stats, year) {
    var chartData = {
        labels: ["Persoane cercetate", "Persoane trimise în judecată", "Persoane condamnate"],
        datasets: [{
            label: 'Number of Cases',
            backgroundColor: ["#007bff", "#87cefa", "#ff69b4"],
            borderColor: ["#0056b3", "#6495ed", "#ff1493"],
            borderWidth: 1,
            data: [0, 0, 0, 0]
        }]
    };

    stats.forEach(stat => {
        if (stat.stare === 'persoane cercetate' ) {
            chartData.datasets[0].data[0] = stat.numar;
        } else if (stat.stare === 'persoane trimise in judecata' ) {
            chartData.datasets[0].data[1] = stat.numar;
        } else if (stat.stare === 'persoane condamnate' ) {
            chartData.datasets[0].data[2] = stat.numar;
        } 
    });

    var ctx = document.getElementById('infractionality-chart').getContext('2d');
    if (existingChart) {
        existingChart.destroy();
    }

    existingChart = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            responsive: true,
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
 ////////////////////PENTRU EMRGENCIE
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
           } else if ( chartType === 'emergencie-drug') {
             url +=statsType + '/emergency/' + selectedYear;
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
                    }else if (chartType === 'emergencie-drug') {
                        renderChartEmergencyDrug(jsonData.stats, jsonData.year);
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

// Funcția pentru afișarea statisticilor de uregnte medicale si drog 
// Funcția pentru afișarea statisticilor de urgențe medicale și droguri
function renderChartGenderDrug(stats, year) {
    var chartData = {
        labels: ["M-Canabis", "M-Stimulanti", "M-Opiacee", "M-NSP", "F-Canabis", "F-Stimulanti", "F-Opiacee", "F-NSP"],
        datasets: [{
            label: 'Number of Cases',
            backgroundColor: ["#007bff", "#87cefa", "#26c4ec", "#73cde3", "#ff69b4", "#ffb6c1", "#fd3f92", "#e11b72"], // Culori personalizate
            borderColor: ["#0056b3", "#6495ed", "#1a99c4", "#58b6c3", "#ff458a", "#ff99b3", "#e02c6d", "#b8135b"], // Culori de border personalizate
            borderWidth: 1, // Grosimea borderului
            data: [0, 0, 0, 0, 0, 0, 0, 0] // Inițializare cu zero pentru fiecare categorie
        }]
    };

    stats.forEach(stat => {
        if (stat.drog === 'Canabis' && stat.gen === 'femei') {
            chartData.datasets[0].data[4] = stat.numar;
        } else if (stat.drog === 'Canabis' && stat.gen === 'barbati') {
            chartData.datasets[0].data[0] = stat.numar;
        } else if (stat.drog === 'Stimulenti' && stat.gen === 'femei') {
            chartData.datasets[0].data[5] = stat.numar;
        } else if (stat.drog === 'Stimulenti' && stat.gen === 'barbati') {
            chartData.datasets[0].data[1] = stat.numar;
        } else if (stat.drog === 'Opiacee' && stat.gen === 'femei') {
            chartData.datasets[0].data[6] = stat.numar;
        } else if (stat.drog === 'Opiacee' && stat.gen === 'barbati') {
            chartData.datasets[0].data[2] = stat.numar;
        } else if (stat.drog === 'NSP' && stat.gen === 'femei') {
            chartData.datasets[0].data[7] = stat.numar;
        } else if (stat.drog === 'NSP' && stat.gen === 'barbati') {
            chartData.datasets[0].data[3] = stat.numar;
        }
    });

    var ctx = document.getElementById('emergencies-chart').getContext('2d');

    // Distruge chart-ul existent dacă există
    if (existingChartEmergency) {
        existingChartEmergency.destroy();
    }
    
    ctx.canvas.height = 200; // Înălțimea canvas-ului
    existingChartEmergency = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: "rgba(0, 0, 0, 0.1)", // Culoarea grilajului
                        borderDash: [2, 2], // Linie întreruptă pentru grilaj
                    },
                    title: {
                        display: true,
                        text: 'Number of Cases',
                        color: '#333', // Culoarea textului
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
                    text: 'Drug Related Emergencies by Gender and Drugs (' + year + ')',
                    color: '#000', // Culoarea titlului
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


// Funcția pentru afișarea statisticilor de vârstă și drog
function renderChartAgeDrug(stats, year) {
    var chartData = {
        labels: ["Male - Major", "Male - Minor", "Female - Major", "Female - Minor"],
        datasets: [{
            label: 'Number of Cases',
            backgroundColor: ["#007bff", "#87cefa", "#ff69b4", "#ffb6c1"], // Culori personalizate
            borderColor: ["#0056b3", "#6495ed", "#ff1493", "#ffa07a"], // Culori de border personalizate
            borderWidth: 1, // Grosimea borderului
            
            innerHeight: 300, // Înălțimea interioară a barelor
            outerHeight: 300, // Înălțimea exterioară a barelor
            data: [0, 0, 0, 0] // Inițializare cu zero pentru fiecare categorie
        }]
    };

    stats.forEach(stat => {
        if (stat.gen === 'barbati' && stat.varsta === 'majori') {
            chartData.datasets[0].data[0] = stat.numar;
        } else if (stat.gen === 'barbati' && stat.varsta === 'minori') {
            chartData.datasets[0].data[1] = stat.numar;
        } else if (stat.gen === 'femei' && stat.varsta === 'majori') {
            chartData.datasets[0].data[2] = stat.numar;
        } else if (stat.gen === 'femei' && stat.varsta === 'minori') {
            chartData.datasets[0].data[3] = stat.numar;
        }
    });

    var ctx = document.getElementById('emergencies-chart').getContext('2d');
   // ctx.canvas.height = 350; // Înălțimea canvas-ului
    //ctx.canvas.backgroundColor = '#f8f9fa'; // Culoarea de fundal a canvas-ului
    // Distruge chart-ul existent dacă există
    if (existingChartEmergency) {
        existingChartEmergency.destroy();
    }
    
     ctx.canvas.height = 200; // Înălțimea canvas-ului
    //ctx.canvas.backgroundColor = '#f8f9fa'; // Culoarea de fundal a canvas-ului

    existingChartEmergency = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: "rgba(0, 0, 0, 0.1)", // Culoarea grilajului
                        borderDash: [2, 2], // Linie întreruptă pentru grilaj
                    },
                    title: {
                        display: true,
                        text: 'Number of Cases',
                        color: '#333', // Culoarea textului
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
                    text: 'Drug Related Emergencies by Age and Drugs (' + year + ')',
                    color: '#000', // Culoarea titlului
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
function renderChartEmergencyDrug(stats, year) {
    var chartData = {
        labels: ["Male - Major", "Male - Minor", "Female - Major", "Female - Minor"],
        datasets: [{
            label: 'Number of Cases',
            backgroundColor: ["#007bff", "#87cefa", "#ff69b4", "#ffb6c1"], // Culori personalizate
            borderColor: ["#0056b3", "#6495ed", "#ff1493", "#ffa07a"], // Culori de border personalizate
            borderWidth: 1, // Grosimea borderului
            
            innerHeight: 300, // Înălțimea interioară a barelor
            outerHeight: 300, // Înălțimea exterioară a barelor
            data: [0, 0, 0, 0] // Inițializare cu zero pentru fiecare categorie
        }]
    };

    stats.forEach(stat => {
        if (stat.gen === 'barbati' && stat.varsta === 'majori') {
            chartData.datasets[0].data[0] = stat.numar;
        } else if (stat.gen === 'barbati' && stat.varsta === 'minori') {
            chartData.datasets[0].data[1] = stat.numar;
        } else if (stat.gen === 'femei' && stat.varsta === 'majori') {
            chartData.datasets[0].data[2] = stat.numar;
        } else if (stat.gen === 'femei' && stat.varsta === 'minori') {
            chartData.datasets[0].data[3] = stat.numar;
        }
    });

    var ctx = document.getElementById('emergencies-chart').getContext('2d');
   // ctx.canvas.height = 350; // Înălțimea canvas-ului
    //ctx.canvas.backgroundColor = '#f8f9fa'; // Culoarea de fundal a canvas-ului
    // Distruge chart-ul existent dacă există
    if (existingChartEmergency) {
        existingChartEmergency.destroy();
    }
    
     ctx.canvas.height = 200; // Înălțimea canvas-ului
    //ctx.canvas.backgroundColor = '#f8f9fa'; // Culoarea de fundal a canvas-ului

    existingChartEmergency = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: "rgba(0, 0, 0, 0.1)", // Culoarea grilajului
                        borderDash: [2, 2], // Linie întreruptă pentru grilaj
                    },
                    title: {
                        display: true,
                        text: 'Number of Cases',
                        color: '#333', // Culoarea textului
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
                    text: 'Drug Related Emergencies by Emergencies and Drugs (' + year + ')',
                    color: '#000', // Culoarea titlului
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

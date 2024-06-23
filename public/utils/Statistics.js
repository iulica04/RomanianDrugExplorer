// Funcția pentru actualizarea URL-ului în funcție de anul selectat
document.addEventListener('DOMContentLoaded', function() {
     console.log('AICI Sunt in document ready');

    ['confiscations', 'infractionality', 'emergencies', 'projects'].forEach(type => {
        var url = 'http://localhost/RomanianDrugExplorer/DrugStats/' + type + '/';
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
                           if(type === 'emergencies') {  
                             renderChartEmergencyDrug(jsonData.stats);
                           }else if(type === 'infractionality') {
                            renderChartInfractionality(jsonData.stats);
                           }else if(type === 'confiscations'){
                            renderChartConfiscations(jsonData.stats);
                           }else if(type === 'projects'){
                            renderChartProjects(jsonData.stats);
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
});

var existingChart; // Variabilă globală pentru a păstra referința la chart-ul existent infractionality
var existingChartEmergency; // Variabilă globală pentru a păstra referința la chart-ul existent emergercy
var existingChartConfiscationPie; // Variabilă globală pentru a păstra referința la chart-ul existent confiscations
var existingChartProjects; // Variabilă globală pentru a păstra referința la chart-ul existent projects

///////////////////////////////////////////////////////////////

///SAVE PNG SI SVG
function saveChart(chartId, filename, format) {
    var chartCanvas = document.getElementById(chartId);
    
    // Verifică dacă canvas-ul există pt orice chart 
    if (existingChart || existingChartEmergency || existingChartConfiscationPie || existingChartProjects) {
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
    } else {
        console.error('Canvas element not found:', chartId);
        showSnackbar('Error saving chart: Canvas is empty or not found.', 'error');
    }
}

//Funcția pentru afișarea 
function renderChartConfiscations(stats) {
    var chartData = {
        labels: ["2021","2022", "2023"], // Actualizează etichetele pentru anii pentru care ai date
        datasets: [{
            label: 'Number of Cases',
            backgroundColor: ["#007bff", "#87cefa", "#007bff"],
            borderColor: ["#0056b3", "#6495ed", "#0056b3"],
            borderWidth: 1,
            data: [0, 0, 0] // Initializează cu zero pentru fiecare categorie
        }]
    };

    stats.forEach(stat => {
        if (stat.year === 2021) {
            chartData.datasets[0].data[0] = parseInt(stat.total_value, 10);
        } else if (stat.year === 2022) {
            chartData.datasets[0].data[1] = parseInt(stat.total_value, 10);
        } else if (stat.year === 2023) {
            chartData.datasets[0].data[2] = parseInt(stat.total_value, 10);
        }
    });

    var ctx = document.getElementById('confiscation-chart').getContext('2d');

    // Distrug graficul existent dacă există
    if (existingChartConfiscationPie) {
        existingChartConfiscationPie.destroy();
    }

    ctx.canvas.height = 200; // Setează înălțimea canvas-ului

    existingChartConfiscationPie = new Chart(ctx, {
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
                        text: 'Year',
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
                    text: 'Drug Related Confiscations',
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
// Funcția pentru afișarea statisticilor de stare si numar
function renderChartInfractionality(stats) {
    var chartData = {
        labels: ["2021", "2022", "2023"],
        datasets: [{
            label: 'Number of Cases',
            backgroundColor: ["#007bff", "#87cefa", "#ff69b4"],
            borderColor: ["#0056b3", "#6495ed", "#ff1493"],
            borderWidth: 1,
            data: [0, 0, 0]
        }]
    };

    stats.forEach(stat => {
        if (stat.year === 2021) {
            chartData.datasets[0].data[0] = parseInt(stat.total_value, 10);
        } else if (stat.year === 2022) {
            chartData.datasets[0].data[1] = parseInt(stat.total_value, 10);
        } else if (stat.year === 2023) {
            chartData.datasets[0].data[2] = parseInt(stat.total_value, 10);
        }
    });

    var ctx = document.getElementById('infractionality-chart').getContext('2d');
    if (existingChart) {
        existingChart.destroy();
    }
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
                    text: 'Drug Related Infractionality ',
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
function renderChartEmergencyDrug(stats) {
    console.log('AICI Received stats:', stats);

    var chartData = {
        labels: ["2021", "2022", "2023"],
        datasets: [{
            label: 'Number of Cases',
            backgroundColor: ["#007bff", "#87cefa", "#26c4ec"],
            borderColor: ["#0056b3", "#6495ed", "#1a99c4"],
            borderWidth: 1,
            data: [0, 0, 0 ]
        }]
    };

    console.log('AICI Chart data before processing:', chartData);

    stats.forEach(stat => {
        if (stat.year === 2021) {
            chartData.datasets[0].data[0] = parseInt(stat.total_value, 10);
        } else if (stat.year === 2022) {
            chartData.datasets[0].data[1] = parseInt(stat.total_value, 10);
        } else if (stat.year === 2023) {
            chartData.datasets[0].data[2] = parseInt(stat.total_value, 10);
        }
    });

    var ctx = document.getElementById('emergencies-chart').getContext('2d');

    // Destroy the existing chart if it exists
    if (existingChartEmergency) {
        existingChartEmergency.destroy();
    }

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
            plugins: {
                title: {
                    display: true,
                    text: 'Drug Related Emergencies ',
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
function renderChartProjects(stats) {
    var chartData = {
        labels: ["2021", "2022", "2023"],
        datasets: [{
            label: 'Number of Cases',
            backgroundColor: ["#007bff", "#87cefa", "#ff69b4", "#ffb6c1", "#7bff00", "#cefa87", "#69b4ff", "#b6c1ff", "#ff8c00", "#ffd700", "#32cd32", "#8b0000"], // Custom colors
            borderColor: ["#0056b3", "#6495ed", "#ff1493", "#ffa07a", "#5f9ea0", "#98fb98", "#4682b4", "#dda0dd", "#cd853f", "#ffc0cb", "#7fff00", "#ff4500"], // Custom border colors
            borderWidth: 1, // Border width
            data: [0, 0, 0]// Initialize with zero for each category
        }]
    };

    stats.forEach(stat => {
        if (stat.year === 2021) {
            chartData.datasets[0].data[0] = parseInt(stat.total_value, 10);
        } else if (stat.year === 2022) {
            chartData.datasets[0].data[1] = parseInt(stat.total_value, 10);
        } else if (stat.year === 2023) {
            chartData.datasets[0].data[2] = parseInt(stat.total_value, 10);
        }
        
    });

    var ctx = document.getElementById('projects-chart').getContext('2d');

    // Destroy existing chart if it exists
    if (existingChartProjects) {
        existingChartProjects.destroy();
    }

    ctx.canvas.height = 200; // Canvas height

    existingChartProjects= new Chart(ctx, {
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
            plugins: {
                title: {
                    display: true,
                    text: 'Drug Related Projects',
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

function saveChartNotLoggedIn(){
    showSnackbar('You need to be logged in to save the chart!', 'error');
}